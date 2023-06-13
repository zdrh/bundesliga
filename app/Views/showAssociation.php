
<?php

$this->extend("layout/master");

$this->section("content");


echo heading($svaz->general_name, 1);

echo heading('Seznam sezón', 2);


$form = anchor('sezona/svaz/'.$svaz->id_association.'/pridat', $config['addValue'], $config['addClass']);
echo $form;
$table = new \CodeIgniter\View\Table();
$pole = array('Sezóna', 'Název svazu', 'Logo', 'Změnit');
$table->setHeading($pole);

    
    


foreach ($sezona as $row2) {
    $rokySezony = $row2->start."-".$row2->finish;
    $sezona = anchor('sezona/zobrazit/'.$rokySezony.'/'.$row2->id_season, $row2->start."-".$row2->finish);
    $svaz2 = anchor('svaz/zobrazit/'.$svaz->id_association, $row2->associationName.' ('.$svaz->short_name.')');
    $image = array(
        'src' => $uploadPath.$row2->logo,
        'height' => 30,
        'alt' => $row2->associationName
    );
    $logo = img($image);

    $edit = anchor('sezona/svaz/editovat/'.$row2->id_assoc_season, $config['editValue'], $config['editClass']);
    $del = array(
        'id_assoc_season' => $row2->id_assoc_season
    );
    $delete = form_open_rest('sezona/svaz/smazat/'.$row2->id_assoc_season, 'delete', $del, 'bg-danger', $config['deleteValue']);
    $new = anchor('sezona/liga/'.$row2->id_assoc_season.'/pridat', $config['addValue'].' ročník soutěže', $config['addClass']);

    $pole = array($sezona, $svaz2, $logo, $edit.$delete.$new);
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


echo heading('Seznam pořádaných lig', 2);

$table = new \CodeIgniter\View\Table();
$pole = array('Název', 'Úroveň');
$table->setHeading($pole);

foreach($liga as $row) {
   
    
    $liga = anchor('liga/zobrazit/'.$row->id_league, $row->name);
    $pole = array($liga, $row->level);
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