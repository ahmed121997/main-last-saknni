<?php

namespace App\Traits;

trait SaveImages{

    function saveMultipleImages($request,$nameFile){
        if($request->hasfile($nameFile))
        {
            $i = 0;$data = [];
            foreach($request->file($nameFile) as $image)
            {
                $name=  time().'_'.$i.'.'.$image->getClientOriginalExtension();
                $image->move(public_path().'/images/', $name);
                $data[] = $name;$i++;
            }
            return $data;
        }
    }
}
