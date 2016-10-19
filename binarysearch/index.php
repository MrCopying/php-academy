<?php
/*
 * input data
 *      (0,0) - top left position - позиция начала координат
 *      ($dx,$dy) array for search - поля для поиска мины
 *      $N - count - количество попыток поиска
 *      ($x,$y) - координаты старта в масиве
 */
define('MAX_ROW',10000);
define('MAX_COL',10000);

function inst( $stepCount = false, $arField = array(), $arStart = array(), $arBomb = array()){
    global $max_x, $max_y, $N, $x, $y, $bomb;
    if(!$stepCount){
        $N = rand(10,20);
    }else{
        $N = $stepCount;
    }
    if(empty($arField)){
        $max_x = rand(0, MAX_ROW);
        $max_y = rand(0, MAX_COL);
    }else{
        $max_x = $arField[0];
        $max_y = $arField[1];
    }
    if(empty($arStart)){
        $x = rand(0,$max_x);
        $y = rand(0,$max_y);
    }else{
        $x = $arStart[0];
        $y = $arStart[1];
    }
    if(empty($arBomb)){
        $bomb = array(rand(0,$max_x), rand(0,$max_y));
    }else{
        $bomb = $arBomb;
    }

    //$move = moving(array($x, $y));
}

function moving($cord){
    global $bomb, $max_x, $max_y;
    $res= false;
    if (is_array($cord) AND (count($cord) == 2)){
        if( ($cord[0] >= 0) && ($cord[0] <= $max_x) &&
            ($cord[1] >= 0) && ($cord[1] <= $max_y)){
            $res='';
            if($dy = $bomb[1]-$cord[1]){
                ($dy > 0)? $res.= 'D' : $res.= 'U';
            }
            if($dx = $bomb[0]-$cord[0]){
                ($dx > 0)? $res.= 'R' : $res.= 'L';
            }
            if (empty($res)){
                $res = true;
            }
        }
    }
    return $res;
}

function show_inst(){
    global $max_x, $max_y, $N, $x, $y, $bomb;
    echo '<div><h3>Входные данные игры:</h3>'.
        '<p>Параметры поля поиска (x,y): (' . $max_x . ',' . $max_y . ')</p>'.
        '<p>Бетман стартует на позиции: (' . $x . ',' . $y .')</p>'.
        '<p>Бомба заложена по координатам: (' . $bomb[0] . ',' . $bomb[1] .')</p>'.
        '<p>Попыток для поиска данно: ' . $N . '</p>'.
        '</div>';
}

function game_play(){
    global $max_x, $max_y, $N, $x, $y, $bomb;

    $cord = array($x, $y);
    $res = array();
    $i = 0;
    $arSearch = array(array(0, 0), array($max_x, $max_y));
    while(true){
        // UL, U, UR , R, DR, D, DL, L
        $move = moving($cord);

        //$cord = answerd($move, $cord, $arSearch);
        $cord = answerd2($move, $cord, $arSearch);

        if(($move === true)||($i>100)){
            break;
        }
        $res[] = array('move' => $move, 'cord' => $cord);
        // echo $cord[0] . ' ' . $cord[1];
        $i++;
    }
    return $res;
}

function answerd($move, $oldCord, &$arSearch){
    $res = array();
    switch ($move[0]){
        case 'U' : {
            $arSearch[1][1] = $oldCord[1];
            $res[1] = $arSearch[0][1] + round(($arSearch[1][1] - $arSearch[0][1]) / 2);
            $move = substr($move,1);
            break;
        }
        case 'D' : {
            $arSearch[0][1] = $oldCord[1];
            $res[1] = $arSearch[0][1] + round(($arSearch[1][1] - $arSearch[0][1]) / 2);
            $move = substr($move,1);
            break;
        }
        default : {
            $res[1] = $oldCord[1];
        }
    }

    switch ($move){
        case 'R' : {
            $arSearch[0][0] = $oldCord[0];
            $res[0] = $arSearch[0][0] + round(($arSearch[1][0] - $arSearch[0][0]) / 2);
            break;
        }
        case "L" : {
            $arSearch[1][0] = $oldCord[0];
            $res[0] = $arSearch[0][0] + round(($arSearch[1][0] - $arSearch[0][0]) / 2);
            break;
        }
        default : {
            $res[0] = $oldCord[0];
        }
    }
    return $res;
}

function answerd2($move, $oldCord, &$arSearch){
    $res = array();

    $fl = substr($move,0,1);
    if(($fl == 'D') || ($fl == 'U')){
        $k = ($fl == 'U')? 1 : 0;
        $arSearch[$k][1] = $oldCord[1];
        $res[1] = $arSearch[0][1] + round(($arSearch[1][1] - $arSearch[0][1]) / 2);
        $fl = substr($move,1);
    }else{
        $res[1] = $oldCord[1];
    }

    if(($fl == 'R') || ($fl == 'L')){
        $k = ($fl == 'R')? 0 : 1;
        $arSearch[$k][0] = $oldCord[0];
        $res[0] = $arSearch[0][0] + round(($arSearch[1][0] - $arSearch[0][0]) / 2);
    }else{
        $res[0] = $oldCord[0];
    }
    return $res;
}
function show_game(&$arRes){
    echo '<div><ul>';
    foreach ($arRes as $val){
        echo '<li>Направление: ' . $val['move'] . ' - новые координаты: (' . $val['cord'][0] . ', ' . $val['cord'][1] . ')</li>';
    }
    echo '</ul><p>Всего ходов: '. count($arRes).'</p></div>';
}

inst();
//inst(17,array(9761,4061),array(2022,27),array(9231,631));
//inst(false,array(0,1300));
//inst(false,array(8500,0));
//inst(false, array(2500,0),array(),array(2500,0));
//inst(false, array(2500,0),array(0,0),array(2500,0));

show_inst();
$res = game_play();
show_game($res);

/* //для коректной работы на сайте с заданием, не используем массивы и функции.
$maxX = $W-1; $maxY = $H-1;
$minX = 0;    $minY = 0;
$x = $X0;     $y = $Y0;

// game loop
while (TRUE)
{
    fscanf(STDIN, "%s",
        $bombDir // the direction of the bombs from batman's current location (U, UR, R, DR, D, DL, L or UL)
    );
switch($bombDir){
    case 'U': {
        $maxY = $y;
        $y = $y - (int)round(($y - $minY)/2);
        break;
    }
    case 'UR': {
        $maxY = $y; $minX = $x;
        $y = $y - (int)round(($y - $minY)/2);
        $x = $x + (int)round(($maxX - $x)/2);
        break;
    }
    case 'UL':{
        $maxY = $y; $maxX = $x;
        $y = $y - (int)round(($y - $minY)/2);
        $x = $x - (int)round(($x - $minX)/2);
        break;
    }
    case 'D':{
        $minY = $y;
        $y = $y + (int)round(($maxY - $y)/2);
        break;
    }
    case 'DR':{
        $minY = $y; $minX = $x;
        $y = $y + (int)round(($maxY - $y)/2);
        $x = $x + (int)round(($maxX - $x)/2);
        break;
    }
    case 'DL':{
        $minY = $y; $maxX = $x;
        $y = $y + (int)round(($maxY - $y)/2);
        $x = $x - (int)round(($x - $minX)/2);
        break;
    }
    case 'L':{
        $maxX = $x;
        $x = $x - (int)round(($x - $minX)/2);
        break;
    }
    case 'R':{
        $minX = $x;
        $x = $x + (int)round(($maxX - $x)/2);
        break;
    }
}

    // the location of the next window Batman should jump to.
    echo("$x $y\n");
}
*/