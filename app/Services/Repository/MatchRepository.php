<?php namespace App\Services\Repository;

use App\Match;
use App\Summoner;
use Illuminate\Database\Eloquent\Collection;

class MatchRepository extends Repository
{
    /**
     * @param $data
     *
     * @return static
     */
    public function set($data)
    {
        $winner = array_values(array_filter($data->teams, function ($team) {
            return $team->winner;
        }))[0]->teamId;

        $match = Match::create([
            'matchId'   => $data->matchId,
            'region'    => $data->region,
            'timestamp' => $data->matchCreation,
            'version'   => $data->matchVersion,
            'season'    => $data->season,
            'winner'    => $winner,
            'data'      => json_encode($data)
        ]);

        $relations = [];
        foreach ($data->participants as $participant) {
            $relations[] = [
                'summonerId' => $participant->player->summonerId,
                'championId' => $participant->championId,
                'teamId'     => $participant->teamId,
                'matchId'    => $data->matchId,
                'winner'     => $winner == $participant->teamId
            ];
        }

        \DB::table('match_summoner_champion')->insert($relations);

        return $match;
    }

    /**
     * @param $matchIds
     * @param $region
     *
     * @return string
     */
    public function get($matchIds, $region)
    {
        if (!is_array($matchIds)) {
            $matchIds = [$matchIds];
        }

        /**
         * @var Collection $matches
         */
        $matches = Match::whereIn('matchId', $matchIds)
            ->where('region', $region)
            ->orderBy('timestamp', 'DESC')->get();

        $missingMatches = array_diff($matchIds, $matches->map(function (Match $match) {
            return $match->matchId;
        })->all());

        // When the match is not yet saved in the database, we fetch it from the API
        // and then reorder the collection
        if (count($missingMatches) > 0) {
            $res = $this->client->request('GET', $this->baseurl . '/match/' . implode(',', $missingMatches), [
                'query' => ['region' => $region]
            ]);

            $res = json_decode($res->getBody());

            if (!is_array($res)) {
                $res = [$res];
            }

            foreach ($res as $match) {
                $matches->push($this->set($match));
            }

            $matches->sort(function (Match $match1, Match $match2) {
                return $match1->matchCreation - $match2->matchCreation;
            });
        }

        if (count($matchIds) === 1) {
            $matches = $matches->first();
        }

        return $matches;
    }
}