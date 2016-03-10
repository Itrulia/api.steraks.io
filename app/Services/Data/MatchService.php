<?php namespace App\Services\Data;

use App\Match;

class MatchService extends StaticService
{
    public function setMatch(Match $match) {
        $matchData = json_decode($match->data);

        foreach($matchData->participants as $participant) {
            $participant = $this->setChampionData($participant);
            $participant = $this->setSummonerSpellData($participant);
            $participant = $this->setItemData($participant);
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
    protected function setItemData($participant) {
        $items = [];
        $itemKeys = ['item0', 'item1', 'item2', 'item3', 'item4', 'item5', 'item6'];

        foreach($itemKeys as $itemName) {
            $item = new \stdClass();
            $item->itemId = $participant->stats->$itemName;

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