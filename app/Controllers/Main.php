<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Menu as MenuModel;

class Main extends BaseController
{
    var $menu;
    function __construct()
    {
        //load menu
        $model = new MenuModel();
        $this->menu = $model->orderBy('priority', 'desc')->findAll();
        
    }

    function page1() {
        $data["menu"] = $this->menu;
        $data["title"] = "Titulek 1";
        
        echo view('page-1', $data);
    }

    function page2() {
        $data["menu"] = $this->menu;
        $data["title"] = "Titulek 2";
        
        echo view('page-2', $data);
    }

    function page3() {
        $data["menu"] = $this->menu;
        $data["title"] = "Titulek 3";
        
        echo view('page-3', $data);
    }

    function page4() {
        $data["menu"] = $this->menu;
        $data["title"] = "Titulek 4";
        
        echo view('page-4', $data);

    }
}