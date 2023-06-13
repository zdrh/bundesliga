
<?php

$this->extend("layout/master");

$this->section("content");
 ?>

 <?php   
    echo heading('Přidat sezonu svazu', 1);
   
    echo form_open_multipart('sezona/svaz/create');
    $data = array(
        'name' => 'name',
        'id' => 'name',
        'required' => 'required'
    );
    
    echo form_input_bs($data, 'mb-3 mt-3 col-4', 'Název svazu v sezóně', 'name');
    $data = array(
        'id' => 'general_button',
        'type' => 'button',
        'class' => 'btn btn-primary',
        'content' => 'Použít tento název'
    );

    $button = form_button($data);
    echo '<div class="btn" id="general_name_div">'.$svaz->general_name.'</div>'.$button."\n";

    $data = array(
        'name' => 'general_name',
        'id' => 'general_name',
        'value' => $svaz->general_name,
        'disabled' => 'disabled'
    );
   
    echo form_input_bs($data, 'mb-3 mt-3 col-4', 'Obecný název svazu', 'general_name');
    
    $data = array(
        'name' => 'logo',
        'id' => 'logo',
        'required' => 'required',
        'accept' => '.jpg, .png'
    );

    echo form_upload_bs($data, 'mb-3 mt-3 col-4', 'Logo svazu', 'logo');
    
    $data = array(
        'id' => 'id_season',
        'required' => 'required'
    );
   
    echo form_dropdown_bs('id_season', $sezony, 'mb-3 mt-3 col-4', 'Sezona','id_season','', $sezonySvazu , $data);
    
    $data = array(
        'name' => 'send',
        'id' => 'send',
        'type' => 'submit',
        'class' => 'btn btn-primary',
        'content' => 'Odeslat'
    );
    echo form_button($data);
    echo form_hidden('id_association', $svaz->id_association);
    echo form_close();
?>
<script>
    const btn = document.getElementById('general_button');
    
    document.getElementById('general_button').addEventListener('click', function(){
            let source = 'general_name_div';
            let destination = 'name';
            useThis(source, destination);
            });
</script>
<?php
$this->endSection();

?>
