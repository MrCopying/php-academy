<?php

function validateForm (&$arFieldForm , &$errorsMessage){
    $arErrors = array();
    $errorsMessage = '';
    foreach ($arFieldForm as $field => $val) {
        if (empty($_REQUEST[$field])) {
            $arErrors[$field] = 1; // not send parameter
            $errorsMessage.= 'Поле <i>' . $val .'</i> пустое, введите информацию <br/>';
        } elseif (!validate($field, $_REQUEST[$field])) {
            $arErrors[$field] = 2; // not validate value
            $errorsMessage.= 'Поле <i>' . $val .'</i> не правильно заполнено, исправьте информацию <br/>';
        }
    }
    return $arErrors;
}

function validate($field, $value){
    $value= trim($value);
    if (empty($field) || empty($value) || strlen($value)<6){
        return false;
    }else{
        switch ($field){
            case 'email':{
                if (!preg_match('/^[a-z0-9_\-\.]+@[a-z0-9_\-\.]+\.[a-z0-9]+$/i',$value)) {
                    return false;
                }
                break;
            }
            case 'fio':{
                if (!preg_match('/^([a-z\.\-])+(\s*[a-z]*){1,2}$/i',$value)) {
                    return false;
                }
                break;
            }
            case 'message':{
                break;
            }
            default: {
                return false;
            }
        }
    }
    return true;
}
/*
function messageErrors(&$arErrors){
    $message = '';
    foreach( $arErrors as $field => $val){
        switch($val){
            case 'email': break;
        }
    }
    return $message;
}
*/

/**
 * @param $codeError
 * @return string
 */
function errorClassAdd($codeError){
    switch($codeError):
        case 1: return 'er-emp';
        case 2: return 'er-valid';
        default: return '';
    endswitch;
}

/**
 * @param $field
 * @param bool $isVal
 * @return string
 */
function oldValue($field, $isVal = true){
    return ($isVal)? 'value="' . $_REQUEST[$field] . '"' : $_REQUEST[$field];
}

/**
 * @param $arFieldForm
 * @param string $fileName
 * @param bool $rewrite
 * @return int
 */
function saveMessage(&$arFieldForm, $fileName = 'content.txt', $rewrite = false){
    $fn = array_keys($arFieldForm);
    $rewrite = ($rewrite)? 0 : FILE_APPEND;
    $data = '
<div class="bl-message">
    <div class="user-name">
        ' . $_REQUEST[$fn[1]] .'
    </div>
    <div class="user-email">
        ' . $_REQUEST[$fn[0]] .'
    </div>
    <div class="user-message">
        ' . $_REQUEST[$fn[2]] .'
    </div>
</div>';
    return file_put_contents($fileName, $data, $rewrite | LOCK_EX);
}

function loadContent($fileName = 'content.txt'){
    return file_get_contents($fileName, false);
}