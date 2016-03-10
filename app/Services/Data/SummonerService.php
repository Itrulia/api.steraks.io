<?php namespace App\Services\Data;

class SummonerService extends StaticService
{

    /**
     * @param array $matches
     *
     * @return array
     */
    public function setMatches(array $matches)
    {
        foreach ($matches as $key => $match) {
            list(
                $matches[$key]->championName,
                $matches[$key]->championAvatar
            ) = $this->getChampionData($match->champion);
        }

        return $matches;
    }

    /**
     * @param array $runePages
     *
     * @return array
     */
    public function setRunes(array $runePages)
    {
        foreach ($runePages as $runePage) {
            if (!isset($runePage->slots)) continue;

            foreach ($runePage->slots as $key => $rune) {
                list(
                    $runePage->slots[$key]->runeName,
                    $runePage->slots[$key]->runeDescription,
                    $runePage->slots[$key]->runeAvatar
                ) = $this->getRuneData($rune->runeId);
            }
        }

        return $runePages;
    }
}