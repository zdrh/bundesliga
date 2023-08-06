<?php
$this->extend("layout/master");

$this->section("content");


echo heading("Správa skupin soutěže ".$ligaSezona->league_name_in_season." v sezóně ".$ligaSezona->start."-".$ligaSezona->finish, 1);
$sezona = $ligaSezona->start."-".$ligaSezona->finish;
echo $form = anchor('soutez/'.$ligaSezona->linkName.'/sezona/'.$sezona.'/pridat/skupina/'.$ligaSezona->id_league_season, $config['addValue'], $config['addClass']);

$table = new \CodeIgniter\View\Table();
$pole = array('Název skupiny', 'Změna');
$table->setHeading($pole);
foreach($skupina as $row) {
    
    $edit = anchor('soutez/'.$ligaSezona->linkName.'/sezona/'.$sezona.'/editovat/skupina/'.$row->id_league_season_group, $config['editValue'], $config['editClass']);
    
  
    $delete = form_open_rest('soutez/'.$ligaSezona->linkName.'/sezona/'.$sezona.'/skupina/smazat/'.$row->id_league_season_group, 'delete', "", 'bg-danger', $config['deleteValue']);
   $table->addRow($row->groupname, $edit." ".$delete);
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

