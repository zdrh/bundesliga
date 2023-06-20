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

class LeagueSeason extends BaseController {
    
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


    function __construct() {
        $model = new MenuModel();
        $this->menu = $model->orderBy('priority', 'desc')->findAll();
        $this->config = new Config();
        $this->arrayLib = new ArrayLib();
        $this->footballLib = new FootballLib();
        $this->uploadlib = new UploadLib();
        $this->asModel = new asModel();
        $this->lModel = new lMOdel();
        $this->lsModel = new lsModel();
        $this->sModel = new sModel();
        $this->lsgModel = new lsgModel();
    }

    function new($id_assoc_season) {
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

    function create() {
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
        $newName = 'logo_liga_'.$id_league.'_'.$id_season.'.'.$ext;
        $logo->move($uploadPath, $newName);

        $data = array(
            'id_league' => $id_league,
            'id_assoc_season' => $id_assoc_season,
            'league_name_in_season' => $league_name,
            'logo' => $newName,
            'groups' => $groups
        );
        $this->lsModel->save($data);
        $id_league_season = $this->lsModel->where('id_league', $id_league)->where('id_assoc_season',$id_assoc_season)->findAll()[0]->id_league_season;
        if(is_array($group_name)) {
            foreach($group_name as $group) {
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
        return redirect()->to('sezona/zobrazit/'.$season->start.'-'.$season->finish.'/'.$id_season);
    
    }

    function delete($id_league_season) {

    }

    function edit($id_league_season) {
        $data["title"] = "Přidat sezonu soutěže";
        $data['menu'] = $this->menu;
        $data['ligaSezona'] = $this->lsModel->join('association_season', 'league_season.id_assoc_season=association_season.id_assoc_season', 'inner')->join('season', 'association_season.id_season=season.id_season')->find($id_league_season);
        $data['liga'] = $this->lsModel->join('league_season_group', 'league_season_group.id_league_season=league_season.id_league_season', 'inner')->where('league_season.id_league_season', $id_league_season)->orderBy('id_league_season_group', 'asc')->findAll();
        echo view('editLeagueSeason', $data);
    }

    function update() {
        $league_name = $this->request->getPost('league_name');
        $groups = $this->request->getPost('groups');
        $id_league_season = $this->request->getPost('id_league_season');
        $ligaSezona = $this->lsModel->join('association_season', 'association_season.id_assoc_season=league_season.id_assoc_season', 'inner')->join('season', 'season.id_season=association_season.id_season', 'inner')->find($id_league_season);
        $logo = $this->request->getFile('logo');
        $logoName = $logo->getClientName();
        $data = array();
        if($logoName != ""){
            $uploadPath = $this->config->uploadPath;
            $ext = $logo->getClientExtension();
            $newName = 'logo_liga_'.$ligaSezona->id_league.'_'.$ligaSezona->id_season.".".$ext;
            $this->uploadlib->uploadFile($logo, $uploadPath, $newName);
            $data['logo'] = $newName;
        
        }

        $data['id_league_season'] = $id_league_season;
        $data['league_name_in_season'] = $league_name;
        $data['groups'] = $groups;
        
        $this->lsModel->save($data);
        //ošetří tabulku skupin, pokud došlo ke změně u skupin
        $this->footballLib->fixGroups($ligaSezona, $groups);
        
        return redirect()->to('sezona/zobrazit/'.$ligaSezona->start.'-'.$ligaSezona->finish.'/'.$ligaSezona->id_season);
       
        
    }

    function show($id_league_season) {
        
    }

    function listGroup($id_league_season) {
        $data["title"] = "Přidat sezonu soutěže";
        $data['menu'] = $this->menu;
        $data['config'] = $this->config->crudForm;
        $data['ligaSezona'] = $this->arrayLib->links($this->lsModel->join('association_season', 'league_season.id_assoc_season=association_season.id_assoc_season', 'inner') ->join('season', 'association_season.id_season=season.id_season')->find($id_league_season),"league_name_in_season","linkName", false);
        $data['skupina'] = $this->lsgModel->where('id_league_season', $id_league_season)->orderBy('id_league_season_group', 'asc')->findAll();
        echo view('groupsList', $data);
    }

    function addGroup($id_league_season) {
        $data["title"] = "Přidat sezonu soutěže";
        $data['menu'] = $this->menu;
        $data['config'] = $this->config->crudForm;
        $data['ligaSezona'] = $this->lsModel->join('association_season', 'league_season.id_assoc_season=association_season.id_assoc_season', 'inner') ->join('season', 'association_season.id_season=season.id_season')->find($id_league_season);
        echo view('addGroup', $data);
    }

    function createGroup() {
        $group_name = $this->request->getPost('name');
        $id_league_season = $this->request->getPost('id_league_season');
        $ligaSezona = $this->lsModel->join('association_season', 'league_season.id_assoc_season=association_season.id_assoc_season', 'inner') ->join('season', 'association_season.id_season=season.id_season')->find($id_league_season);
        $data = array(
            'groupname' => $group_name,
            'id_league_season' => $id_league_season
        );
        $this->lsgModel->save($data);
        return redirect()->to('sezona/zobrazit/'.$ligaSezona->start.'-'.$ligaSezona->finish.'/'.$ligaSezona->id_season);

    }

    function editGroup($id_league_season) {

    }

    function deleteGroup($id_league_season) {

    }

}