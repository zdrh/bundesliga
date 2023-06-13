<?php

$this->extend("layout/master");

$this->section("content");

echo heading('Přehled sezón', 1);


$form = anchor('sezona/pridat', $config['addValue'], $config['addClass']);
echo $form;
$table = new \CodeIgniter\View\Table();
$pole = array('ID', 'Roky', 'Změna');
$table->setHeading($pole);

foreach($sezony as $row) {
    $edit = anchor('sezona/'.$row->id_season.'/edit', '<i class="fa-solid fa-pen text-warning"></i> Upravit');
    $delete = anchor('sezona/'.$row->id_season, '<i class="fa-solid fa-trash text-danger"></i> Smazat');

    
   
    $edit = anchor('sezona/editovat/'.$row->id_season, $config['editValue'], $config['editClass']);
    
    $pole = array(
        'id_league' => $row->id_season
    );
    $delete = form_open_rest('sezona/smazat/'.$row->id_season, 'delete', $pole, 'bg-danger', $config['deleteValue']);
    


    $rok = anchor('sezona/zobrazit/'.$row->start.'-'.$row->finish.'/'.$row->id_season, $row->start."/".$row->finish);
    $pole = array($row->id_season, $rok, $edit.$delete);
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

?>