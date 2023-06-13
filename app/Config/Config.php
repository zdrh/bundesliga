<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Config extends BaseConfig {

    public $uploadPath = 'assets/upload/';

    //formuláře
    public $crudForm = array(
        'addValue'  =>  '<i class="fa-solid fa-circle-plus fa-xs"></i> Nový',
        'import'    =>  '<i class="fa-solid fa-circle-plus fa-xs"></i> Importovat z csv',
        'editValue' =>  '<i class="fa-solid fa-pen fa-2xs"></i> Upravit',
        'deleteValue'   =>  '<i class="fa-solid fa-trash fa-2xs"></i> Smazat',
        'addClass'  =>  array('class' => 'btn btn-primary'),
        'editClass' =>  array('class' => 'btn btn-warning'),
        'deleteClass'   =>  array('class' => 'btn btn-danger'
)
    );
    //roky
    public $year = array(
        'assoc_foundation_min' => 1895,
        'assoc_foundation_max' => 2001,
        'league_season_min' => 1945,
        'league_season_max' => 2025,
        'team_foundation_min' => 1850,
        'team_foundation_max' => 2015,
        'team_dissolve_min' => 1950,
        'team_dissolve_max' => 2025
    );
  
}