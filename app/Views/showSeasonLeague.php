<?php
$this->extend("layout/master");

$this->section("content");



$nadpis = $sezonaLiga->league_name_in_season." ".$sezonaLiga->start."-".$sezonaLiga->finish;
echo heading($nadpis, 1);

echo heading('Přehled týmů',2);
$link = "soutez/".$sezonaLiga->linkName."/sezona/".$sezonaLiga->start."-".$sezonaLiga->finish."/".$sezonaLiga->id_league_season."/pridat";
echo $form = anchor($link, $config['addValue'], $config['addClass']);

$table = new \CodeIgniter\View\Table();
$pole = array('Název týmu', 'Odebrat');
$table->setHeading($pole);

/*foreach($tymyLiga as $row) {
    $link = "soutez/".$sezonaLiga->linkName."/sezona/".$sezonaLiga->start."-".$sezonaLiga->finish."/".$sezonaLiga->id_league_season."/smazat/".$row->id_team_league_season;
    $delete = form_open_rest($link, 'delete', $pole, 'bg-danger', $config['deleteValue']);
    $table->addrow($row->general_name, $delete);
    
}*/

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