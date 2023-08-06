
<?php

$this->extend("layout/master");

$this->section("content");
 ?>

 <?php   
    echo heading('Editovat sezonu svazu', 1);
    echo "<div class='row'>";
    echo form_open_multipart('sezona/svaz/update');
    $data = array(
        'name' => 'name',
        'id' => 'name',
        'value' => $aktualniSezona->associationName,
        'required' => 'required'
    );
    
    echo form_input_bs($data, 'mb-3 mt-3 col-12 col-lg-3', 'Název svazu v sezóně', 'name');

    $button = '<button id=\'general_button\' type=\'button\' class=\'btn btn-primary\'>Použít tento název</button>';
    echo '<div class="btn" id="general_name_div">'.$aktualniSezona->general_name.'</div>'.$button."\n";

    $data = array(
        'name' => 'general_name',
        'id' => 'general_name',
    );
    $extra = array(
        'disabled' => 'disabled'
    );
    echo form_input_bs($data, 'mb-3 mt-3 col-12 col-lg-3', 'Obecný název svazu', 'general_name', $aktualniSezona->general_name, $extra);
    
    $data = array(
        'name' => 'logo',
        'id' => 'logo'
    );

    $extra = array('accept' => '.jpg, .png');
    echo form_upload_bs($data, 'mb-3 mt-3 col-12 col-lg-3', 'Logo svazu', 'logo', 'file', $extra);
    $data = array(
        'class' => 'mb-3 mt-3 col-4'
    );
    $imgprop = array(
        'src' => base_url($uploadPath.$aktualniSezona->logo),
        'width' => 150
    );
    $img = img($imgprop);
    echo div($aktualniSezona->logo."<br>".$img, $data);
    $data = array(
        'id' => 'id_season',
        'required' => 'required'
    );

    $selected = array($aktualniSezona->id_season);
   
    echo form_dropdown_bs('id_season', $sezony, 'mb-3 mt-3 col-12 col-lg-3', 'Sezona','id_season',$selected, $sezonySvazu , $data);
    
    $data = array(
        'name' => 'send',
        'id' => 'send',
        'type' => 'submit',
        'class' => 'btn btn-primary',
        'content' => 'Odeslat'
    );
    echo form_button($data);
    echo form_hidden('_method', 'PUT');
    echo form_hidden('id_assoc_season', $aktualniSezona->id_assoc_season);
    echo form_hidden('id_association', $aktualniSezona->id_association);
    echo form_close();
    echo "</div>";
?>
<script>
    const btn = document.getElementById('general_button');
    
    document.getElementById('general_button').addEventListener('click', function(){
                nameAssociation = document.getElementById('general_name_div').innerHTML;
                
                addValue(nameAssociation, 'name');
            });

            function addValue(value, elementId) {
    const elem = document.getElementById(elementId);
    elem.setAttribute("value", value);
   
    
}
</script>
<?php
$this->endSection();

?>
