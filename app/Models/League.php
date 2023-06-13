<?php
namespace App\Models;
use CodeIgniter\Model;

class League extends Model {
    //název tabulky, na kterou se model vztahuje    
    protected $table      = 'league';
// primární klíč tabulky, podle něj se vyhledává v metodě find
    protected $primaryKey = 'id_league';
// jestli se při vkládání používá autoinkrementace, pokud nebudeme používat vkládání, nemá to význam
    protected $useAutoIncrement = true;
// v jaké datové strutuře se budou vracet výsledky, object znamená, že se bude vracet pole objektů
    protected $returnType     = 'object';
//jestli se místo opravdového mazání bude pouze nastavovat hodnota ve sloupci označeném v proměnném deleted_at. To bude v případě true, v příapdě false se bude reálně mazat.
    protected $useSoftDeletes = true;
//sloupce v tabulce, se kterými budu dělat databázové operace (vkládání, mazání apod.). Ostatní sloupce měnit nepůjdou
    protected $allowedFields = ['name', 'id_association', 'level', 'active'];

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

    function getLeaguesWithAssociation() {
       
        $result = $this->select('league.id_league, league.name, league.active, league.level, league.id_association, association.general_name')
                       ->join('association', 'association.id_association=league.id_association', 'inner')
                       ->orderBy('league.level', 'asc')
                       ->orderBy('league.name', 'asc');
                       

        return $result;
    }

    function getLeagueWithAssociation() {
        $result = $this ->select('league.id_league, league.name, league.active, league.level, league.id_association, association.general_name')
                        ->join('association', 'association.id_association=league.id_association', 'inner');
        

        return $result;
    }

    function getLeaguesWithSeason($idSeason, $idAssociation) {
        $result = $this->select('league.name, league.id_league, league_season.id_assoc_season')
            ->join('league_season', 'league.id_league=league_season.id_league', 'left');
            //->join('association_season', 'association_season.id_assoc_season=league_season.id_assoc_season', 'i');

           // ->where('association_season.id_season', $idSeason);
            //->where('league.id_association', $idAssociation);
        
            return $result;
    }
} 