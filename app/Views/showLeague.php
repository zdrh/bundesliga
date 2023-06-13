
<?= $this->extend('layout/master') ;?>

<?= $this->section('content') ;?>

<?php

echo heading($liga->name, 1);


?>
<div class="card col-4">
  <div class="card-header">
  <h3>Info o lize</h3>
  </div>
  <div class="card-body">
    
    <p class="card-text"><b>Úroveň: </b><?= $liga->level;?></p>
    <?php
        if($liga->active) {
            ?>
            <p class="text-bg-success">Aktivní soutěž</p>
            <?php
        }   
        else{
            ?>
            <p class="text-bg-danger">Neaktivní soutěž</p>
            <?php
        }
    ?>
    <p class="card-text"><b>Organizátor: </b><?= $liga->general_name;?></p>
    <p class="card-text"><b>První sezóna: </b><?= $sezony[0]->start."/".$sezony[0]->finish;?></p>
    <p class="card-text"><b>Poslední sezóna: </b><?= $sezony[$pocet_sezon-1]->start."/".$sezony[$pocet_sezon-1]->finish;?></p>
  </div>
</div>


<?= $this->endSection() ;?>