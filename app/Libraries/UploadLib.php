<?php
namespace App\Libraries;

class UploadLib {

    

    function uploadFile($image, $path, $newName) {
        
        if ($image->isValid() && ! $image->hasMoved()) {

           
            
            $image->move($path, $newName);
            
        }

        
    }
}