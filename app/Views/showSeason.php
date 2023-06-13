<?php
$this->extend("layout/master");

$this->section("content");
$sezona2 = "Sezóna ".$sezona->start."-".$sezona->finish;
echo heading($sezona2, 1);
$table = new \CodeIgniter\View\Table();
$pole = array('Soutěž', 'Logo', 'Úroveň', 'Skupiny', 'Změnit soutěž', 'Správa skupin');
$table->setHeading($pole);

foreach($ligy as $row) {
    $img_properties = array(
        'src' => base_url($uploadPath)."/".$row->logo,
        'height' => 30
    );
    $logo = img($img_properties);
    $sezona = $row->start.'-'.$row->finish;
    $link = 'soutez/'.$row->linkName.'/sezona/'.$sezona.'/pridat/skupina/'.$row->id_league_season;
    $skupina = "";
    
    if($row->groups == 1){
        //když nemá skupiny
        $idSkupina = $row->skupina[0]->id_league_season_group;
        $skupina = anchor('soutez/'.$row->linkName.'/sezona/'.$sezona.'/'.$idSkupina, $row->league_name_in_season);
        $group = "Nemá skupiny";
    } else {
        //když má skupiny
        $group = anchor('soutez/'.$row->linkName.'/sezona/'.$sezona.'/sprava/skupin/'.$row->id_league_season, "Správa skupin");
       
        foreach($row->skupina as $key2 => $row2) {
            if($key2 != 0) {
                $skupina.= " ";
            }
            $idSkupina = $row2->id_league_season_group;
            $skupina.= anchor('soutez/'.$row->linkName.'/sezona/'.$sezona.'/'.$idSkupina, $row2->groupname);
        }
    }
    $editLeague = anchor('soutez/'.$row->linkName.'/sezona/'.$sezona.'/editovat/soutez/'.$row->id_league_season, $config['editValue'], $config['editClass']);
    $hidden = array();
    $deleteLeague = form_open_rest('soutez/'.$row->linkName.'/sezona/'.$sezona.'/smazat/soutez/'.$row->id_league_season, 'delete', $hidden, 'bg-danger', $config['deleteValue']);

    
    
    $pole = array($row->league_name_in_season, $logo, $row->level, $skupina, $editLeague." ".$deleteLeague, $group);
    $table->addRow($pole);
}

$template = array(
    'table_open'=> '<table class="table table-bordered mt-3">',
    'thead_open'=> '<thead>',
    'thead_close'=> '</thead>',
    'heading_row_start'=> '<tr>',
    'heading_row_end'=>' </tr>',
    'heading_cell_start'=> '<th>',
    'heading_cell_end' => '</th>',
    'tbody_open' => '<tbody>',
    'tbody_close' => '</tbody>',
    'row_start' => '<tr>',
    'row_end'  => '</tr>',
    'cell_start' => '<td>',
    'cell_end' => '</td>',
    'row_alt_start' => '<tr>',
    'row_alt_end' => '</tr>',
    'cell_alt_start' => '<td>',
    'cell_alt_end' => '</td>',
    'table_close' => '</table>'
    );
    
    $table->setTemplate($template);

echo $table->generate();


$this->endSection();
