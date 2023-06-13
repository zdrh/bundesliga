<!DOCTYPE html>
<html>
    <head> 
        <title><?= $title; ?></title>
        <?= $this->include("layout/assets-top");?> 
    </head> 
    <body>
    <?= $this->include("layout/navbar");?>
    <div class="container">
 
         <!--Dynamický obsah -->
         <?= $this->renderSection("content"); ?> 
    </div>
         <?= $this->include("layout/assets-bottom");?> 
    </body>
</html>