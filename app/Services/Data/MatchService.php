<?php namespace App\Services\Data;

use App\Match;

class MatchService extends StaticService
{
    /**
     * @var string
     */
    private $version;

    private function setVersion($version)
    {
        $parts = explode('.', $version);
        $version = $parts[0] . '.' . $parts[1];
        $this->version = $version;
    }

    /**
     * @return mixed
     */
    protected function getRealmData() {
        $realm = $this->repository->getRealm();
        $versions = $this->repository->getVersions();

        $match = array_filter($versions, function($version) {
            return strpos($version, $this->version) !== false;
        });

        if (count($match) >= 1) {
            $realm->dd = array_shift($match);
        }

        return $realm;
    }

    public function setMatch(Match $match) {
        $matchData = json_decode($match->data);
        $this->setVersion($matchData->matchVersion);

        foreach($matchData->participants as $participant) {
            $this->setChampionData($participant);
            $this->setSummonerSpellData($participant);
            $this->setItemData($participant);
            $this->setMasteryData($participant);
        }

        $match->data = json_encode($matchData);

        return $match;
    }

    /**
     * @param $participant
     *
     * @return mixed
     */
    protected function setChampionData($participant) {
        list(
            $participant->championName,
            $participant->championAvatar
        ) = $this->getChampionData($participant->championId);

        return $participant;
    }

    /**
     * @param $participant
     *
     * @return mixed
     */
    protected function setSummonerSpellData($participant) {
        list(
            $participant->spell2Name,
            $participant->spell2Avatar
        ) = $this->getSummonerSpellData($participant->spell2Id);

        list(
            $participant->spell1Name,
            $participant->spell1Avatar
        ) = $this->getSummonerSpellData($participant->spell1Id);

        return $participant;
    }

    /**
     * @param $participant
     *
     * @return mixed
     */
    protected function setMasteryData($participant) {
        if (!isset($participant->masteries)) return $participant;

        foreach($participant->masteries as $mastery) {
            list(
                $mastery->masteryName,
                $mastery->masteryDescription,
                $mastery->masteryAvatar
            ) = $this->getMasteryData($mastery->masteryId);
        }

        return $participant;
    }

    /**
     * @param $participant
     *
     * @return mixed
     */
    protected function setItemData($participant) {
        $items = [];
        $itemKeys = ['item0', 'item1', 'item2', 'item3', 'item4', 'item5', 'item6'];

        foreach($itemKeys as $itemKey) {
            $item = new \stdClass();
            $item->itemId = $participant->stats->$itemKey;

            list(
                $item->itemName,
                $item->itemAvatar
            ) = $this->getItemData($item->itemId);

            $items[] = $item;
        }

        $participant->stats->items = $items;

        return $participant;
    }
}