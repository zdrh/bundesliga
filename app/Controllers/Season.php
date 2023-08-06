<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use Config\Config;
use App\Libraries\ArrayLib;
use App\Models\Menu as MenuModel;
use App\Models\Season as sModel;
use App\Models\League as lModel;
use App\Models\LeagueSeason as lsModel;
use App\Models\LeagueSeasonGroup as lsgModel;

class Season extends BaseController
{
    var $menu;
    var $sModel;
    var $lsModel;
    var $lModel;
    var $lsgModel;
    var $config;
    var $array;


    function __construct() {
        $model = new MenuModel();
        $this->sModel = new sModel();
        $this->lsModel = new lsModel();
        $this->lModel = new lModel();
        $this->lsgModel = new lsgModel();
        $this->config = new Config();
        $this->array = new ArrayLib();
        $this->menu = $model->orderBy('priority', 'desc')->findAll();
    }
    
    function new() {
        $data["title"] = "Přidat sezónu";
        $data['menu'] = $this->menu;
        $data['year'] = $this->config->year;
        echo view('addSeason', $data);
    }

    function create() {
        $start = $this->request->getPost('start');
        $finish = $this->request->getPost('finish');
        $data = array(
            'start' => $start,
            'finish' => $finish,
        );
        $this->sModel->save($data);
       
        return redirect()->route('seznam-sezon');


    }

    function edit($id) {
        $data["title"] = "Editovat sezónu";
        $data['menu'] = $this->menu;
        $data['year'] = $this->config->year;
        $data['sezona'] = $this->sModel->find($id);
        echo view('editSeason', $data);
    }

    function update() {
        $start = $this->request->getPost('start');
        $finish = $this->request->getPost('finish');
        $id_season = $this->request->getPost('id_season');
        $data = array(
            'start' => $start,
            'finish' => $finish,
            'id_season' => $id_season
        );
        $this->sModel->save($data);
        return redirect()->route('seznam-sezon');
    }

    function delete($id) {
        $this->sModel->delete($id);
        return redirect()->route('seznam-sezon');
    }

    function index() {
        $data["title"] = "Seznam sezón";
        $data['menu'] = $this->menu;
        $sezony = $this->sModel->orderBy('start', 'asc')->findAll();
        $data['config'] = $this->config->crudForm;
        $data['sezony'] = $sezony;
        echo view('seasonsList', $data);

    }

    function show($id) {
        $data["title"] = "Seznam sezón";
        $data['menu'] = $this->menu;
        $data['uploadPath'] = $this->config->uploadPath;
        $data['sezona'] = $this->sModel->find($id);
        $data['config'] = $this->config->crudForm;
        $ligy = $this->lsModel->join('league', 'league.id_league=league_season.id_league', 'inner')->join('association_season', 'association_season.id_assoc_season=league_season.id_assoc_season', 'inner')->join('season', 'association_season.id_season=season.id_season', 'inner')->where('association_season.id_season', $data['sezona']->id_season)->orderBy('level', 'asc')->orderBy('league_season.league_name_in_season')->findAll();
        
        $ligy = $this->array->links($ligy,'league_name_in_season', 'linkName');
        
        $skupiny = $this->lsgModel->join('league_season', 'league_season.id_league_season=league_season_group.id_league_season', 'inner')->join('association_season', 'league_season.id_assoc_season=association_season.id_assoc_season', 'inner')->where('association_season.id_season',$id)->orderBy('league_season.league_name_in_season', 'asc')->findAll();
        
        $skupiny = $this->array->implodeArray($skupiny, "league_name_in_season", "groupname", " - ", "league_name_with_group");
        
        
        $data['ligy'] = $this->array->insertArrayIntoAnotherArray($ligy, $skupiny, "id_league_season", "id_league_season", 'skupina');
       
        echo view('showSeason', $data);
    }
}
