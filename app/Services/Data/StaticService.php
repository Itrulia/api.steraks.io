<?php namespace App\Services\Data;

use App\Services\Repository\StaticRepository;

class StaticService
{
    /**
     * @var \stdClass
     */
    protected $realmData;

    /**
     * @var \stdClass
     */
    protected $masteryData;

    /**
     * @var \stdClass
     */
    protected $champData;

    /**
     * @var \stdClass
     */
    protected $runeData;

    /**
     * @var \stdClass
     */
    protected $itemData;

    /**
     * @var \stdClass
     */
    protected $summonerSpellData;

    /**
     * @var \stdClass
     */
    protected $summonerIconData;

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
        if (is_null($this->realmData)) {
            $this->realmData = $this->repository->getRealm();
        }

        if (is_null($this->champData)) {
            $this->champData = $this->repository->getChampions();
        }

        if (isset($this->champData->$championId)) {
            return [
                $this->champData->$championId->name,
                $this->realmData->cdn . '/' . $this->realmData->dd . '/img/champion/' . $this->champData->$championId->image->full,
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
        if (is_null($this->realmData)) {
            $this->realmData = $this->repository->getRealm();
        }

        if (is_null($this->masteryData)) {
            $this->masteryData = $this->repository->getMasteries();
        }

        if (isset($this->masteryData->data->$masteryId)) {
            return [
                $this->masteryData->data->$masteryId->name,
                $this->masteryData->data->$masteryId->description,
                $this->realmData->cdn . '/' . $this->realmData->dd . '/img/mastery/' . $this->masteryData->data->$masteryId->image->full,
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
        if (is_null($this->realmData)) {
            $this->realmData = $this->repository->getRealm();
        }

        if (is_null($this->runeData)) {
            $this->runeData = $this->repository->getRunes();
        }

        if (isset($this->runeData->$runeId)) {
            return [
                $this->runeData->$runeId->name,
                $this->runeData->$runeId->description,
                $this->realmData->cdn . '/' . $this->realmData->dd . '/img/rune/' . $this->runeData->$runeId->image->full,
            ];
        }

        return [null, null, null];
    }

    public function getSummonerSpellData($spellId) {
        if (is_null($this->realmData)) {
            $this->realmData = $this->repository->getRealm();
        }

        if (is_null($this->summonerSpellData)) {
            $this->summonerSpellData = $this->repository->getSummonerSpells();
        }

        if (isset($this->summonerSpellData->$spellId)) {
            return [
                $this->summonerSpellData->$spellId->name,
                $this->realmData->cdn . '/' . $this->realmData->dd . '/img/spell/' . $this->summonerSpellData->$spellId->image->full,
            ];
        }

        return [null, null];
    }

    public function getSummonerIconData($iconId) {
        if (is_null($this->realmData)) {
            $this->realmData = $this->repository->getRealm();
        }

        return $this->realmData->cdn . '/' . $this->realmData->dd . '/img/profileicon/' . $iconId . '.png';
    }

    public function getItemData($itemId) {
        if (is_null($this->realmData)) {
            $this->realmData = $this->repository->getRealm();
        }

        if (is_null($this->itemData)) {
            $this->itemData = $this->repository->getItems();
        }

        if (isset($this->itemData->$itemId)) {
            return [
                $this->itemData->$itemId->name,
                $this->realmData->cdn . '/' . $this->realmData->dd . '/img/item/' . $this->itemData->$itemId->image->full,
            ];
        }

        return [null, null];
    }
}