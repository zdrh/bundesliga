<?php

$this->extend("layout/master");

$this->section("content");

echo heading('Přehled týmů', 1);

$form = anchor('tym/pridat', $config['addValue'], $config['addClass']);
echo $form.'&nbsp;';
$form2 = anchor('tym/importovat', $config['import'], $config['addClass']);
echo $form2;

$table = new \CodeIgniter\View\Table();
$pole = array('Název', 'Zkratka', 'Založení', 'Změna');
$table->setHeading($pole);
$rowsClass = array();
foreach($tymy as $key => $row) {
    
   
    $edit = anchor('tym/editovat/'.$row->id_team, $config['editValue'], $config['editClass']);
    
    $pole = array(
        'id_team' => $row->id_team
    );
    $delete = form_open_rest('tym/smazat/'.$row->id_team, 'delete', $pole, 'bg-danger', $config['deleteValue']);
    
    $tym = anchor('tym/zobrazit/'.$row->id_team, $row->general_name);
   
    $pole = array($tym, $row->short_name, $row->founded,  $edit.' '.$delete);
    
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
    'cell_start_class'   => '<td>', 
    );
    
$table->setTemplate($template);
echo $table->generate();

$this->endSection();

?>