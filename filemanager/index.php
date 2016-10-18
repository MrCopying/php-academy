<?php
$contents_directory = array();

function scanDirectory(&$contents_directory, $currentDir = null ){
    $currentDir = (isset($currentDir))? $currentDir : __DIR__;
    $dir = [];
    $files = array();
    $contents_directory = scandir($currentDir);
    foreach ($contents_directory as $value){
//        echo ' ' . $value . ' ' . preg_match('/^([0-9a-z-_\s]{0,10})[0-9a-z-_\s]*(\.[0-9a-z]+)$/i', $value, $files) . '<br><pre>';
//        var_dump($files);echo '</pre><br>';
        if ($value !='.' && $value !='..'){
            if (is_dir($currentDir. '/' . $value)){
                $dir[$value] = (strlen($value)>=13)? substr($value,0,12) . '~': $value;
            }else{
                if (strlen($value)>=13) {
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
    echo '<pre>';
    var_dump($contents_directory);
}
function showDir(){

}
function showFiles(){

}
scanDirectory($contents_directory);