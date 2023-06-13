<?php

namespace App\Models;
use CodeIgniter\Model;

class TeamLeagueSeason extends Model {
    //název tabulky, na kterou se model vztahuje    
    protected $table      = 'team_league_season';
// primární klíč tabulky, podle něj se vyhledává v metodě find
    protected $primaryKey = 'id_team_league_season';
// jestli se při vkládání používá autoinkrementace, pokud nebudeme používat vkládání, nemá to význam
    protected $useAutoIncrement = true;
// v jaké datové strutuře se budou vracet výsledky, object znamená, že se bude vracet pole objektů
    protected $returnType     = 'object';
//jestli se místo opravdového mazání bude pouze nastavovat hodnota ve sloupci označeném v proměnném deleted_at. To bude v případě true, v příapdě false se bude reálně mazat.
    protected $useSoftDeletes = true;
//sloupce v tabulce, se kterými budu dělat databázové operace (vkládání, mazání apod.). Ostatní sloupce měnit nepůjdou
    protected $allowedFields = ['id_season', 'team_name_in_season', 'logo', 'id_league_season'];

// do sloupců s datem vytvoření záznamu, editace nebo smazání se budou vkládat timestampy (true) nebo jiný formát data psecifikovaný v proměnné $DateFormat
    protected $useTimestamps = true;
    protected $dateFormat = 'int';
//název sloupce, kde bude uloženo datum vytvoření záznamu
    protected $createdField  = 'created_at';
// název sloupce s datem poslední editace záznamu
    protected $updatedField  = 'updated_at';
//název sloupce s datem smazání záznamu (pouze pokud $useSoftDeletes je true)
    protected $deletedField  = 'deleted_at';
//validační pravidla sloupců
    protected $validationRules    = [];
//validační hlášky pro jednotlivá pravidla
    protected $validationMessages = [];
// jestli se má přeskočit validace při insertech a updatech
    protected $skipValidation     = true;


 function teamsWithoutSeason($idLeagueSeason) {
   $result =  $this ->select('team2.*')
                    ->join('team', 'team.id_team=team_league_season.id_team', 'inner')
                    ->join('team as team2', 'team.id_team=team2.id_team', 'right')
                    ->where('team_league_season.id_league_season', $idLeagueSeason)
                    ->orderBy('team2.general_name', 'asc');

    return $result;
 }  

}
