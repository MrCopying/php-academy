<?php

function showDir(&$contents_directory, $current_dir){
    if(isset($current_dir)):
        $match =array();
        ?>
<div id="updir" class="dirs">
    <a></a>
</div>
<?php
    endif;
    foreach ($contents_directory['dir'] as $key => $val):?>
<div class="dirs">
    <a href="?dir=<?php echo urldecode($current_dir . '\\' . $key);?>" title="<?php echo $key;?>"><?php echo $val;?></a>
</div>
<?php
    endforeach;
}
function showFiles(&$contents_directory, $current_dir){
    foreach ( $contents_directory['files'] as $key => $val):?>
<div class="files">
    <a href="?dir=<?php
    echo urldecode($current_dir);?>&file=<?php
    echo urldecode($key);?>" title="<?php
    echo $key;?>"><?php
    echo $val;?></a>
</div>
<?php
    endforeach;
}
function showImages(&$contents_directory){

};