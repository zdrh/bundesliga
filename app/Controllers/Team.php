<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Config\Config;
use App\Libraries\ArrayLib;


use App\Models\Menu as Menumodel;
use App\Models\Team as tModel;

class Team extends BaseController {

    var $menu;
    var $tModel;
    var $config;
    var $arrayLib;

    function __construct() {
        
        $model = new Menumodel();
        $this->menu = $model->orderBy('priority', 'desc')->findAll();
        $this->config = new Config();
        $this->arrayLib = new ArrayLib();
        $this->tModel = new tModel();
    }
    

    function index() {
        
        $data["title"] = "Přidat sezónu";
        $data['menu'] = $this->menu;
        $data['config'] = $this->config->crudForm;
        $data['uploadPath'] = $this->config->uploadPath;
        $data['tymy'] = $this->tModel->orderBy('general_name', 'asc')->findAll();
        echo view('teamsList', $data);
       
    }

    function new() {
        $data["title"] = "Přidat sezónu";
        $data['menu'] = $this->menu;
        $data['year'] = $this->config->year;
        $tymy = $this->tModel->orderBy('general_name', 'asc')->findAll();
        $data['tymy'] = $this->arrayLib->dataForDropdown($tymy, 'id_team', 'general_name');
        echo view('addTeam', $data);
    }
    /**
     * zatím hotovo pouze pro jeden tým
     */
    function create() {
        $name = $this->request->getPost('name');
        $short_name = $this->request->getPost('short_name');
        $founded = $this->request->getPost('founded');
        $dissolve = $this->request->getPost('dissolve');
        $follower = $this->request->getPost('follower');
       /* var_dump($name);
        var_dump($short_name);
        var_dump($founded);
        var_dump($dissolve);
        var_dump($follower);*/
        if($short_name == '') {
            $short_name = NULL;
        }
        if($dissolve == '') {
            $dissolve = NULL;
        }
        $data = array(
            'founded' => $founded,
            'general_name' => $name,
            'short_name' => $short_name,
            'dissolve' => $dissolve
        );
        $this->tModel->save($data);

        return redirect()->to('seznam-tymu');
    }

    function import() {
        $data["title"] = "Přidat sezónu";
        $data['menu'] = $this->menu;
        $data['config'] = $this->config->crudForm;
        echo view('importTeam', $data);
    }

    function createImport() {
        $logo = $this->request->getFile('import_teams');
        $string = fopen($logo->getTempName(), "r");
        while (($data = fgetcsv($string, 1000, ";")) !== FALSE) 
        {        
            $array[] = $data; 
        }
        
        fclose($string);

        $result = $this->arrayLib->testArray($array, 4);
        var_dump($result);
        foreach($array as $row) {
            $short_name = $row[2];
            $dissolve = $row[3];
            ($short_name == "" ? $short_name = NULL : "");
            ($dissolve == "" ? $dissolve = NULL : "");
            $data = array(
                'founded' => $row[0],
                'general_name' => $row[1],
                'short_name' => $short_name,
                'dissolve' => $dissolve
            );
           // $this->tModel->save($data);
        }
       // return redirect()->to('seznam-tymu');
    }


}