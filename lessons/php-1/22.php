<?php

    define(COUNTRY_UKRAINE, 'Ukraine');
    define(COUNTRY_GERMANY, 'Germany');
    define(COUNTRY_FRANCE, 'France');

    $arCountry = array(COUNTRY_UKRAINE, COUNTRY_FRANCE, COUNTRY_GERMANY);

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>22. Константы</title>
    <link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
    <h1>22. Константы</h1>
    <div id="content">
        <p class="task">Определить константы, которые соответствуют названиям нескольких стран мира. Используя эти константы, сформировать массив из соответствующих значений.</p>
        <?php
            echo '<p>Результат значений массива $arCounrty:';
            foreach ($arCountry as $value){
                echo '<br/>' . $value;
            }
            echo '</p>';
        ?>
    </div>
</body>
</html>
