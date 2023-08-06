<?php

$this->extend("layout/master");

$this->section("content");

$sezona = $ligaSezona->start."-".$ligaSezona->finish;
echo heading("Přidat novou skupinu soutěže ".$ligaSezona->league_name_in_season." v sezóně ".$sezona, 1);
echo form_open('soutez/sezona/skupina/create');

$data_group = array(
    'name' => 'group_name[]',
    'id' => 'name',
    'required' => 'required'
);
$attr = array(
    'id' => 'groups_form'
);


$groups = array(
    0 => '--- Vyber ---',
    1 => 'základní',
    2 => 'doplněk'
);
$data = array(
    'id' => 'type',
    'required' => 'required'
);
$disabled = array(
    0
);

echo div(form_input_bs($data_group, 'mb-3 mt-3 col-4', 'Název skupiny', 'name').form_dropdown_bs('type', $groups, 'mb-3 mt-3 col-4', 'Typ skupiny?','type','', $disabled, $data),$attr);


$data_button_add = array(
    'name' => 'add_group',
    'id' => 'add_group',
    'type' => 'button',
    'class' => 'btn btn-primary me-3',
    'content' => 'Přidat další skupinu'
);
echo form_button($data_button_add);


$data = array(
    'name' => 'send',
    'id' => 'send',
    'type' => 'submit',
    'class' => 'btn btn-primary',
    'content' => 'Odeslat'
);
echo form_button($data);
echo form_hidden('id_league_season', $ligaSezona->id_league_season);
echo form_close();

?>
<script>
 document.getElementById('add_group').addEventListener('click', function(){
            value = "<?php echo form_input_bs($data_group,'mb-3 mt-3 col-6', 'Název skupiny', 'group_name[]','text', false).form_dropdown_bs('type', $groups, '', 'Typ skupiny?','type','', $disabled, $data); ?>";
            newdiv = document.createElement('div');
            newdiv.innerHTML = value;
            document.getElementById('groups_form').appendChild(newdiv);
            newdiv.setAttribute('id', 'newdiv');
 });
</script>
<?php
$this->endSection();