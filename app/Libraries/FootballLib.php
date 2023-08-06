<?php

namespace App\Libraries;

use App\Models\League as lModel;
use App\Models\LeagueSeason as lsModel;
use App\Models\LeagueSeasonGroup as lsgModel;
use App\Libraries\ArrayLib as arrayLib;

class FootballLib
{

    var $lModel;
    var $lsModel;
    var $lsgModel;
    var $arrayLib;
    function __construct()
    {
        $this->lModel = new lModel();
        $this->lsModel = new lsModel();
        $this->lsgModel = new lsgModel();
        $this->arrayLib = new arrayLib();
    }
    /**
     *  vypíše pouze ty soutěže dané asociace, které nemají pro danou sezonu vytvořený záznam
     */

    function getFreeLeaguesForSeason($idAssociation, $idSeason)
    {
        $result = array();
        $leagues = $this->lModel->where('id_association', $idAssociation)->orderBy('level', 'asc')->findAll();
        $leagueSeason = $this->lsModel->join('association_season', 'league_season.id_assoc_season=association_season.id_assoc_season', 'inner')->where('id_season', $idSeason)->where('association_season.id_association', $idAssociation)->findAll();

        $result = array();
        foreach ($leagues as $row) {
            if (!$this->findValue($leagueSeason, 'id_league', $row->id_league)) {
                $result[] = $row;
            }
        }

        return $result;
    }
    /**
     * hledá jestli v daném poli objektů existuje hodnota pro daný atribut. vrací true/false
     */
    private function findValue($array, $attribute, $value)
    {
        $result = false;
        foreach ($array as $row) {
            if ($row->$attribute == $value) {
                $result = true;
            }
        }

        return $result;
    }
    //ošetří změny v databázi, pokud došlo ke změnám ohledně skupin, vrátí pole s sql dotazy, které je potřeba provést
    /**
     * $data = objekt s daty o dané lize a sezóně v db
     * $groups = int číslo 1- nemá skupiny, 2 má skupiny, hodnota z formuláře - taková má být nová hodnota, z formuláře
     * $groupsDB - údaje o skupinách aktuálně v DB - id a název skupiny
     * $groupsform - pole s údaji o skupinách, jak bylo vloženo ve formuláři
     */
    function fixGroups($data, $groups, $groupsDB, $groupsForm)
    {
        $id_league_season = $data->id_league_season;

        if ($groups == 1) {
            $groupsForm[] = NULL;
        }
        $builder = $this->lsgModel->builder();
        $result = array();
        $vysledek = $this->arrayLib->validArray($groupsDB, 'groupname', 'valid', $groupsForm);

        //co se nezvalidovalo, to musím vyházet (smazat z Db a pokud něco zbylo, tak to musím přidat do db)
        $dataDB = $vysledek[0];
        $dataForm = $vysledek[1];
        foreach ($dataDB as $row) {
            if (!isset($row->valid)) {
                $sql = $builder->where('id_league_season_group', $row->id_league_season_group)->getCompiledDelete();
                $result[] = $sql;
            }
        }
        foreach ($dataForm as $row2) {
            $data = array(
                'groupname' => $row2,
                'id_league_season' => $id_league_season
            );
            $sql = $builder->set($data)->getCompiledInsert();
            $result[] = $sql;
        }


        return $result;
    }

    /**
     * připraví pole transakcí pro vkládání(1), editaci(2), delete(3)
     * $data - pole s údaji, které se budou dávat do transakcí
     * $table - do které tabulky
     * $type - 1 - insert, 2- update, 3 - delete
     * $where - podmínka pro update a delete
     */
    function prepareTransaction($data, $table, $type, $where = array())
    {
        $result = array();
        $builder = $this->lsgModel->builder($table);
        if ($type == 3) {
            //u mazání není třeba mít $data
            $sql = $builder->where($where)->getCompiledDelete();
            $result[] = $sql;
        } else if ($type == 1) {
            foreach ($data as $row) {
                $sql = $builder->set($row)->getCompiledInsert();
                $result[] = $sql;
            }
        } else if ($type == 2) {
            foreach ($data as $row) {
                $sql = $builder->set($row)->where($where)->getCompiledUpdate();
                $result[] = $sql;
            }
        }

        return $result;
    }
}
