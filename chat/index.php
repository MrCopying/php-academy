<?php
define('EMAIL','E-mail');
define('FIO','Фамилия Имя Очество');
define('MESSAGE','Сообщение');

include_once('function.php');

$isErrorsMessage = false;
$errorsMessage = '';
$arErrors = array();
$arFieldForm = array( 'email' => EMAIL,
                        'fio' => FIO,
                    'message' => MESSAGE);
$isUserSend = false;
$content = '';

if (!empty($_REQUEST)){

    $arErrors = validateForm($arFieldForm, $errorsMessage);
    if (!empty($arErrors)){
        $isErrorsMessage = true;
        //$errorsMessage = messageErrors($arErrors);
    }else{
        $isUserSend = true;
        //saveMessage($arFieldForm, 'test.txt', true);
        saveMessage($arFieldForm);
    }
}
//$content = loadContent('test.txt');
$content = loadContent();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Реализация коментариев на файловой системе</title>
    <link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="page">
    <div id="errors-message">
        <?php if($isErrorsMessage){
            echo '<p>' . $errorsMessage . '</p>';
        };
        ?>
    </div>
    <div id="content">
        <a href="index.php">Home</a><hr/>
        <?=$content; ?>
        <a href="index.php">Please form...</a>
    </div>
    <?php if (!$isUserSend) :?>
    <div id="form">
        <form action="index.php" method="post">
            <div class="f-input <?= errorClassAdd($arErrors['email']); ?>" >
                <label for="email">Введите e-mail:</label>
                <input type="email" name="email" placeholder="Введите ваш e-mail" required <?= oldValue('email');?>/>
            </div>
            <div class="f-input <?= errorClassAdd($arErrors['fio']); ?>">
                <label for="fio">Введите ваше ФИО:</label>
                <input type="text" name="fio" placeholder="Введите ваше ФИО" required <?= oldValue('fio');?>/>
            </div>
            <div class="f-input">
                <label for="message">Ваше сообщение:</label>
            </div>
            <div class="f-input <?=errorClassAdd($arErrors['message']); ?>">
                <textarea name="message"  placeholder="Оставте ваше сообщение" required ><?= oldValue('message', false); ?></textarea>
            </div>
            <div class="f-input">
                <input type="submit" value="Отправить" />
            </div>
            <div class="clear"></div>
        </form>
    </div>
    <?php endif; ?>
</div>
</body>
</html>
