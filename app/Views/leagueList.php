<?php

$this->extend("layout/master");

$this->section("content");

echo heading('Přehled lig', 1);

$form = anchor('liga/pridat', $config['addValue'], $config['addClass']);
echo $form;

$table = new \CodeIgniter\View\Table2();
$pole = array('Název', 'Název svazu', 'Aktivní', 'Úroveň', 'Změna');
$table->setHeading($pole);
$rowsClass = array();
foreach($ligy as $key => $row) {
    
   
    $edit = anchor('liga/editovat/'.$row->id_league, $config['editValue'], $config['editClass']);
    
    $pole = array(
        'id_league' => $row->id_league
    );
    $delete = form_open_rest('liga/smazat/'.$row->id_league, 'delete', $pole, 'bg-danger', $config['deleteValue']);
    
    $liga = anchor('liga/zobrazit/'.$row->id_league, $row->name);
    $svaz = anchor('svaz/zobrazit/'.$row->id_association, $row->general_name);
    $pole = array($liga, $svaz, $row->active, $row->level,  $edit.' '.$delete);
    if(!$row->active) {
        $rowsClass[$key] = '<tr class="bg-light">';
    }
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
    'cell_start' => '<td class="align-middle">',
    'cell_end' => '</td>',
    'row_alt_start' => '<tr>',
    'row_alt_end' => '</tr>',
    'cell_alt_start' => '<td class="align-middle">',
    'cell_alt_end' => '</td>',
    'table_close' => '</table>',
    'row_start_class'    => $rowsClass,
    'cell_start_class'   => '<td>', 
    );
    $cellClass = array();
    $table->setTemplate($template, $rowsClass, $cellClass);
echo $table->generate();

$this->endSection();

?>