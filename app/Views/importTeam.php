<?php

$this->extend("layout/master");

$this->section("content");

echo heading('Import týmů', 1);

echo "<p>přidává data do tabulky týmů. CSV musí mít celkem 4 sloupce v pořadí - rok založení, název týmu, zkratka týmu, rok rozpuštění klubu.";

echo form_open_multipart('tym/createImport');

$data = array(
    'name' => 'import_teams',
    'id' => 'import_teams',
    'required' => 'required',
    'accept' => '.csv .txt'
);


echo form_upload_bs($data, 'mb-3 mt-3 col-6', 'Importovat týmy', 'import_teams');


$data = array(
    'name' => 'send',
    'id' => 'send',
    'type' => 'submit',
    'class' => 'btn btn-primary',
    'content' => 'Odeslat'
);
echo form_button($data);
echo form_close();


$this->endSection();