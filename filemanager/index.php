<?php
ob_start();
include 'functions.php';
include 'template\func-template.php';

$content = array();
$contents_directory = array();
$current_dir = (isset($_REQUEST['dir']))? $_REQUEST['dir']: NULL;


scanDirectory($contents_directory, $current_dir);
scanImageFiles($contents_directory);

showDir($contents_directory, $current_dir);
$content['dirs'] = ob_get_contents();
ob_clean();
showFiles($contents_directory, $current_dir);
$content['files'] = ob_get_contents();
ob_clean();
showImages($contents_directory);
$content['images'] = ob_get_contents();
ob_end_clean();



include 'template\header-html.php';
include 'template\content-html.php';
include 'template\footer-html.php';