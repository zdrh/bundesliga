<?php

$this->extend("layout/master");

$this->section("content");

echo heading('Přehled svazů', 1);

$form = anchor('svaz/pridat', $config['addValue'], $config['addClass']);
echo $form;

$table = new \CodeIgniter\View\Table();
$pole = array('Název', 'Zkratka', 'Rok založení', 'Změna');
$table->setHeading($pole);

foreach($svazy as $row) {
    $edit = anchor('svaz/editovat/'.$row->id_association, $config['editValue'], $config['editClass']);
    
    $pole = array(
        'id_association' => $row->id_association
    );
    $delete = form_open_rest('svaz/smazat/'.$row->id_association, 'delete', $pole, 'bg-danger', $config['deleteValue']);
    
    $svaz = anchor('svaz/zobrazit/'.$row->id_association, $row->general_name);
    $pole = array($svaz, $row->short_name, $row->founded, $edit.' '.$delete);
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
    'table_close' => '</table>'
    );
    
    $table->setTemplate($template);

echo $table->generate();

$this->endSection();

?>