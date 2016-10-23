<?php
/*
 * Functions for file manager
 */

function scanDirectory(&$contents_directory, $currentDir = null ){
    $currentDir = (isset($currentDir))? __DIR__ . $currentDir : __DIR__;
    $isScanCurrentDir = true;
    $dir = [];
    $files = array();
    $contents_directory = @scandir($currentDir);
    if (!$contents_directory){
        $currentDir = __DIR__;
        $isScanCurrentDir = false;
        $contents_directory = @scandir($currentDir);
        if(!$contents_directory){
            exit('FATAL ERROR: DON\'T READ ROOT DIRECTORY');
        }
    }
    foreach ($contents_directory as $value){
        if ($value !='.' && $value !='..'){
            if (is_dir($currentDir. '/' . $value)){
                $dir[$value] = (strlen($value)>15)? substr($value,0,14) . '~': $value;
            }else{
                if (strlen($value)>15) {
                    $shname = array();
                    preg_match('/^([0-9a-z-_\s]{0,10})[0-9a-z-_\s]*(\.[0-9a-z]+)$/i', $value, $shname);
                    $files[$value] = $shname[1] . '~' . $shname[2];
                }else{
                    $files[$value] = $value;
                }

            }
        }
    }
    $contents_directory = '';
    $contents_directory['dir'] = $dir;
    $contents_directory['files'] = $files;
    return $isScanCurrentDir;
}

function scanImageFiles(&$contents_directory, $mask = array('png','gif','jpg','jpeg','svg')){
    //$is_images = false;
    $images = array();
    $mask = implode('|', $mask);
    foreach($contents_directory['files'] as $key => $value){
        if (preg_match("/\.($mask)$/i",$value)){
            $images[$key] = $value;
        }
    }
    $contents_directory['images'] = $images;
}