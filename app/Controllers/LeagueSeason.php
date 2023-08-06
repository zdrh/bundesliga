<?php

namespace App\Controllers;

use App\Models\AssociationSeason as asModel;
use App\Models\League as lMOdel;
use App\Models\LeagueSeason as lsModel;
use App\Models\Season as sModel;
use App\Models\LeagueSeasonGroup as lsgModel;
use App\Models\Menu as MenuModel;


use Config\Config;
use App\Libraries\ArrayLib;
use App\Libraries\FootballLib;
use App\Libraries\UploadLib;
use App\Libraries\TransactionLib;
use stdClass;

class LeagueSeason extends BaseController
{

    var $db;
    var $asModel;
    var $lModel;
    var $lsModel;
    var $sModel;
    var $lsgModel;
    var $menu;
    var $config;
    var $arrayLib;
    var $footballLib;
    var $uploadlib;
    var $transactionLib;


    function __construct()
    {
        $model = new MenuModel();
        $this->menu = $model->orderBy('priority', 'desc')->findAll();
        $this->config = new Config();
        $this->arrayLib = new ArrayLib();
        $this->footballLib = new FootballLib();
        $this->uploadlib = new UploadLib();
        $this->transactionLib = new TransactionLib();
        $this->asModel = new asModel();
        $this->lModel = new lMOdel();
        $this->lsModel = new lsModel();
        $this->sModel = new sModel();
        $this->lsgModel = new lsgModel();
    }

    function new($id_assoc_season)
    {
        $data["title"] = "Přidat sezonu soutěže";
        $data['menu'] = $this->menu;
        $data['svazSezona'] = $this->asModel->getSeasonByIdAssocSeason()->find($id_assoc_season);

        $id_association = $data['svazSezona']->id_association;
        $id_season = $data['svazSezona']->id_season;
        $ligy_dispozici = $this->footballLib->getFreeLeaguesForSeason($id_association, $id_season);

        $ligy_filtr = $this->arrayLib->dataForDropdown($ligy_dispozici, 'id_league', 'name');
        $data['liga'] = $ligy_filtr;
        $data['ligyDispozici'] = Count($data['liga']);


        echo view('addLeagueSeason', $data);
    }

    function create()
    {
        $id_league = $this->request->getPost('id_league');
        $id_assoc_season = $this->request->getPost('id_assoc_season');
        $logo = $this->request->getFile('logo_league');
        $groups = $this->request->getPost('groups');
        $league_name = $this->request->getPost('league_name');
        $group_name = $this->request->getPost('group_name');
        $id_season = $this->asModel->find($id_assoc_season)->id_season;
        $season = $this->sModel->find($id_season);
        $uploadPath = $this->config->uploadPath;
        $ext = $logo->getClientExtension();
        $newName = 'logo_liga_' . $id_league . '_' . $id_season . '.' . $ext;
        $logo->move($uploadPath, $newName);

        $data = array(
            'id_league' => $id_league,
            'id_assoc_season' => $id_assoc_season,
            'league_name_in_season' => $league_name,
            'logo' => $newName,
            'groups' => $groups
        );
        $this->lsModel->save($data);
        $id_league_season = $this->lsModel->where('id_league', $id_league)->where('id_assoc_season', $id_assoc_season)->findAll()[0]->id_league_season;
        if (is_array($group_name)) {
            foreach ($group_name as $group) {
                $data2 = array(
                    'id_league_season' => $id_league_season,
                    'groupname' => $group
                );
                $this->lsgModel->save($data2);
            }
        } else {
            $data2 = array(
                'id_league_season' => $id_league_season
            );
            $this->lsgModel->save($data2);
        }
        return redirect()->to('sezona/zobrazit/' . $season->start . '-' . $season->finish . '/' . $id_season);
    }

    function delete($id_league_season)
    {
        $ligaSezona = $this->lsModel->join('association_season', 'association_season.id_assoc_season=league_season.id_assoc_season', 'inner')->join('season', 'season.id_season=association_season.id_season', 'inner')->find($id_league_season);
        $poleTransakci = array();
        $builder = $this->lsModel->builder();
        $sql = $builder->where('id_league_season', $id_league_season)->getCompiledDelete();
        $poleTransakci[] = $sql;

        $builder = $this->lsgModel->builder();
        $sql = $builder->where('id_league_season', $id_league_season)->getCompiledDelete();
        $poleTransakci[] = $sql;

        $this->transactionLib->doTransactions($poleTransakci);

        return redirect()->to('sezona/zobrazit/' . $ligaSezona->start . '-' . $ligaSezona->finish . '/' . $ligaSezona->id_season);
    }

    function edit($id_league_season)
    {
        $data["title"] = "Editovat sezonu soutěže";
        $data['menu'] = $this->menu;
        $data['uploadPath'] = $this->config->uploadPath;
        //info o aktuální sezoně, kterou edituju
        $data['ligaSezona'] = $this->lsModel->join('association_season', 'league_season.id_assoc_season=association_season.id_assoc_season', 'inner')->join('season', 'association_season.id_season=season.id_season')->find($id_league_season);
        //  $data['liga'] = $this->lsModel->join('league_season_group', 'league_season_group.id_league_season=league_season.id_league_season', 'inner')->where('league_season.id_league_season', $id_league_season)->orderBy('id_league_season_group', 'asc')->findAll();
        //výpis skupin
        $data['groups'] = $this->lsgModel->where('id_league_season', $id_league_season)->orderBy('id_league_season_group', 'asc')->findAll();
        echo view('editLeagueSeason', $data);
    }

    function update()
    {
        $group_name = array();
        $league_name = $this->request->getPost('league_name');
        $groups = $this->request->getPost('groups');
        if ($groups == 2) {
            $group_name =  $this->request->getPost('group_name');
        }

        $id_league_season = $this->request->getPost('id_league_season');
        $logo = $this->request->getFile('logo');
        $logoName = $logo->getClientName();
        $data = array();
        $ligaSezona = $this->lsModel->join('association_season', 'association_season.id_assoc_season=league_season.id_assoc_season', 'inner')->join('season', 'season.id_season=association_season.id_season', 'inner')->find($id_league_season);
        $skupinyDB = $this->lsgModel->where('id_league_season', $id_league_season)->findAll();
        if ($logoName != "") {

            $uploadPath = $this->config->uploadPath;
            $ext = $logo->getClientExtension();
            $newName = 'logo_liga_' . $ligaSezona->id_league . '_' . $ligaSezona->id_season . "." . $ext;
            $this->uploadlib->uploadFile($logo, $uploadPath, $newName);
            $data['logo'] = $newName;
        }


        $data['league_name_in_season'] = $league_name;
        $data['groups'] = $groups;


        $poleTransakci = array();
        $builder = $this->lsModel->builder();
        $sql = $builder->where('id_league_season', $id_league_season)->set($data)->getCompiledUpdate();
        $poleTransakci[] = $sql;



        //ošetří tabulku skupin, pokud došlo ke změně u skupin
        $dotazy = $this->footballLib->fixGroups($ligaSezona, $groups, $skupinyDB, $group_name);

        $poleTransakci = $this->arrayLib->arrayAdd($poleTransakci, $dotazy);
        $this->transactionLib->doTransactions($poleTransakci);

        return redirect()->to('sezona/zobrazit/' . $ligaSezona->start . '-' . $ligaSezona->finish . '/' . $ligaSezona->id_season);
    }

    

    function listGroup($id_league_season)
    {
        $data["title"] = "Přidat sezonu soutěže";
        $data['menu'] = $this->menu;
        $data['config'] = $this->config->crudForm;
        $data['ligaSezona'] = $this->arrayLib->links($this->lsModel->join('association_season', 'league_season.id_assoc_season=association_season.id_assoc_season', 'inner')->join('season', 'association_season.id_season=season.id_season')->find($id_league_season), "league_name_in_season", "linkName", false);
        $data['skupina'] = $this->lsgModel->where('id_league_season', $id_league_season)->orderBy('id_league_season_group', 'asc')->findAll();
        echo view('groupsList', $data);
    }

    function addGroup($id_league_season)
    {
        $data["title"] = "Přidat skupinu soutěže";
        $data['menu'] = $this->menu;
        $data['config'] = $this->config->crudForm;
        $data['ligaSezona'] = $this->lsModel->join('association_season', 'league_season.id_assoc_season=association_season.id_assoc_season', 'inner')->join('season', 'association_season.id_season=season.id_season')->find($id_league_season);
        echo view('addGroup', $data);
    }

    function createGroup()
    {

        $group_name = $this->request->getPost('group_name');

        $id_league_season = $this->request->getPost('id_league_season');
        $ligaSezona = $this->lsModel->join('association_season', 'league_season.id_assoc_season=association_season.id_assoc_season', 'inner')->join('season', 'association_season.id_season=season.id_season')->find($id_league_season);
        foreach ($group_name as $group) {
            $data[] = array(
                'groupname' => $group,
                'id_league_season' => $id_league_season
            );
        }
        $dataForTransaction = $this->transactionLib->prepareTransactions($data, $this->lsgModel, 1);
        //var_dump($dataForTransaction);
        $transaction = $this->transactionLib->doTransactions2($dataForTransaction);
       // $transactions = $this->footballLib->prepareTransaction($data, 'league_season_group', 1);
        
        //$this->transactionLib->doTransactions($transactions);

        //return redirect()->to('sezona/zobrazit/' . $ligaSezona->start . '-' . $ligaSezona->finish . '/' . $ligaSezona->id_season);
    }

    function editGroup($id_league_season_group)
    {
        $data["title"] = "Editovat skupinu soutěže";
        $data['menu'] = $this->menu;
        $data['config'] = $this->config->crudForm;
        $data['group'] = $this->lsgModel->find($id_league_season_group);
        $id_league_season = $data["group"]->id_league_season;
        $data['ligaSezona'] = $this->lsModel->join('association_season', 'league_season.id_assoc_season=association_season.id_assoc_season', 'inner')->join('season', 'association_season.id_season=season.id_season')->find($id_league_season);
        echo view('editGroup', $data);
    }

    function updateGroup()
    {
        $group_name = $this->request->getPost('group_name');
        $id_league_season_group = $this->request->getPost('id_league_season_group');
        $ligaSezonaSkupina = $this->lsgModel->find($id_league_season_group);
        $id_league_season = $ligaSezonaSkupina->id_league_season;
        $ligaSezona = $this->lsModel->join('association_season', 'league_season.id_assoc_season=association_season.id_assoc_season', 'inner')->join('season', 'association_season.id_season=season.id_season')->find($id_league_season);

        $data = array(
            'groupname' => $group_name,
            'id_league_season_group' => $id_league_season_group
        );

        $this->lsgModel->save($data);

        return redirect()->to('sezona/zobrazit/' . $ligaSezona->start . '-' . $ligaSezona->finish . '/' . $ligaSezona->id_season);
    }

    function deleteGroup($id_league_season_group)
    {
       // $this->lsgModel->delete($id_league_season_group);
    
        $ligaSezonaSkupina = $this->lsgModel->find($id_league_season_group);
        var_dump($ligaSezonaSkupina);
        $id_league_season = $ligaSezonaSkupina->id_league_season;
        $ligaSezona = $this->lsModel->join('association_season', 'league_season.id_assoc_season=association_season.id_assoc_season', 'inner')->join('season', 'association_season.id_season=season.id_season')->find($id_league_season);
       // return redirect()->to('sezona/zobrazit/' . $ligaSezona->start . '-' . $ligaSezona->finish . '/' . $ligaSezona->id_season);
    }

    function show($id_league_season)
    {

        $data["title"] = "Sezóna";
        $data['menu'] = $this->menu;
       // $data['tymyAvailable'] = $this->tModel->getTeamsWithoutLeague($id_league_season)->findAll();
        $sezonaLiga = $this->lsModel->join('association_season', 'association_season.id_assoc_season=league_season.id_assoc_season', 'inner')->join('season', 'season.id_season=association_season.id_season')->find($id_league_season);
        //var_dump($sezonaLiga);
        $data['sezonaLiga'] = $this->arrayLib->links($sezonaLiga, 'league_name_in_season', 'linkName', false);
        //$data['tymyLiga'] = $this->tlsModel->join('team', 'team.id_team=team_league_season.id_team', 'inner')->where('id_league_season', $id_league_season)->orderBy('team.general_name', 'asc')->findAll();
        $data['config'] = $this->config->crudForm;
        echo view('showSeasonLeague', $data);
    }
}
