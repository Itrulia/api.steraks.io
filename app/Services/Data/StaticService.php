<?php namespace App\Services\Data;

use App\Services\Repository\StaticRepository;

class StaticService
{

    /**
     * @var \App\Services\Repository\StaticRepository
     */
    protected $repository;

    /**
     * @param \App\Services\Repository\StaticRepository $repository
     */
    public function __construct(StaticRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $championId
     *
     * @return array
     */
    public function getChampionData($championId)
    {
        $realm = $this->repository->getRealm();
        $champions = $this->repository->getChampions();

        if (isset($champions->$championId)) {
            return [
                $champions->$championId->name,
                $realm->cdn . '/' . $realm->dd . '/img/champion/' . $champions->$championId->image->full,
            ];
        }

        return [null, null];
    }

    /**
     * @param $masteryId
     *
     * @return array
     */
    public function getMasteryData($masteryId)
    {
        $realm = $this->repository->getRealm();
        $masteries = $this->repository->getMasteries();

        if (isset($masteries->data->$masteryId)) {
            return [
                $masteries->data->$masteryId->name,
                $masteries->data->$masteryId->description,
                $realm->cdn . '/' . $realm->dd . '/img/mastery/' . $masteries->data->$masteryId->image->full,
            ];
        }

        return [null, null];
    }

    /**
     * @param int $runeId
     *
     * @return array
     */
    public function getRuneData($runeId)
    {
        $realm = $this->repository->getRealm();
        $runes = $this->repository->getRunes();

        if (isset($runes->$runeId)) {
            return [
                $runes->$runeId->name,
                $runes->$runeId->description,
                $realm->cdn . '/' . $realm->dd . '/img/rune/' . $runes->$runeId->image->full,
            ];
        }

        return [null, null, null];
    }

    public function getSummonerSpellData($spellId) {
        $realm = $this->repository->getRealm();
        $spells = $this->repository->getSummonerSpells();

        if (isset($spells->$spellId)) {
            return [
                $spells->$spellId->name,
                $realm->cdn . '/' . $realm->dd . '/img/spell/' . $spells->$spellId->image->full,
            ];
        }

        return [null, null];
    }

    public function getItemData($itemId) {
        $realm = $this->repository->getRealm();
        $items = $this->repository->getItems();

        if (isset($items->$itemId)) {
            return [
                $items->$itemId->name,
                $realm->cdn . '/' . $realm->dd . '/img/item/' . $items->$itemId->image->full,
            ];
        }

        return [null, null];
    }
}