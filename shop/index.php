<?php
require_once('config.php');

if (isset($_GET['buy']))
{
    $data = buy_form();
    $is_buy = 1;
}
elseif (isset($_GET['cart']))
{
    $data = show_cart();
    $is_cart = 1;
}
elseif (isset($_GET['good']))
{
    $good = $_GET['good'];
    $data = show_good($good);
}
elseif (isset($_GET['section']))
{
    $section = $_GET['section'];
    $data = show_sections($section);
    $is_section = 1;
}
else {
    $section = 'main';
    $data = show_sections($section);
    $is_section = 1;
}

if (!empty($_COOKIE['cart']))
{
    $cart_count = 0;
    $cart_sum = 0;
    foreach($_COOKIE['cart'] as $good_id => $cookie_cart)
    {
        $cart = json_decode($cookie_cart);
        $cart_count += $cart[0];
        $cart_sum += $cart[0]*$cart[1];
    }
}

require_once('./template/index.php');

function show_sections($section)
{
    $db = mysqli_connect($GLOBALS['host'], $GLOBALS['login'], $GLOBALS['password'], $GLOBALS['database']);

    if ($db == false){
        print("Ошибка: Невозможно подключиться к MySQL " . mysqli_connect_error());
    }
    else {
        mysqli_set_charset($db, "utf8");

        //Получаем секцию по названию
        $section = mysqli_real_escape_string($db,$section);
        $query = 'SELECT * FROM `catalog` WHERE `section_name` = "'. $section.'"';
        $result = mysqli_query($db, $query);
        if(empty($result)) return;
        $row = mysqli_fetch_array($result);
        $section = $row['id'];

        $meta_description = $row['meta_description'];
        $meta_keywords = $row['meta_keywords'];
        $section_name = $row['title'];
        $title = $GLOBALS['project_name'].'|'.$row['title'];

        //Вычисляем уровень раздела
        //$query_level = 'SELECT COUNT(*) AS level FROM `treepath` WHERE `descendant` = '. $section;
        $query_level = 'SELECT level FROM `treepath` WHERE `descendant` = '. $section;
        $result_level = mysqli_query($db, $query_level);
        if(empty($result_level)) return;
        $row_level = mysqli_fetch_array($result_level);
        $top_level = $row_level['level'];

        //Подразделы
        $level = $top_level + 1;
        $query = 'SELECT * FROM `treepath` LEFT JOIN `catalog` on `catalog`.`id` = `treepath`.`descendant` AND `treepath`.`ancestor` = '.$section.' AND `treepath`.`level` = '.$level.' WHERE `catalog`.`id` IS NOT NULL ORDER BY `title` ASC';
        $result = mysqli_query($db, $query);
        if(empty($result)) return;

        $items = [];
        while ($row = mysqli_fetch_array($result)) {
            //Вычисляем уровень подраздела
            //Сделал колонку уровней в таблице дерева, чтобы не делать лишних запросов к бд
            /*
            $query_level = 'SELECT COUNT(*) AS level FROM `treepath` WHERE `descendant` = '. $row['descendant'];
            $result_level = mysqli_query($db, $query_level);
            $row_level = mysqli_fetch_array($result_level);
            $level = $row_level['level'];
            */
            $items[] = ['row' => $row, 'type' => 'section'];
        }
        //Ищем товары, соответствующие текущему разделу
        $query_good = 'SELECT * FROM `goods` WHERE `catalog_id` = '. $section.' ORDER BY `title` ASC';
        $result_good = mysqli_query($db, $query_good);

        while ($row_good = mysqli_fetch_array($result_good)) {
            //print($row_good['id']. "<br>");
            $items[] = ['row' => $row_good, 'type' => 'good'];
        }

        //pagination
        $page = 1;
        if (isset($_GET['page'])) $page = $_GET['page'];

        $pagination = 12;
        $items_paginated = [];
        for ($i = ($page-1)*$pagination; $i < $page*$pagination; $i++)
        {
            if(!empty($items[$i])) $items_paginated[] = $items[$i];
        }

        //Родительские разделы
        $query = 'SELECT * FROM `treepath` LEFT JOIN `catalog` on `catalog`.`id` = `treepath`.`ancestor` AND `treepath`.`descendant` = '.$section.' WHERE `catalog`.`id` IS NOT NULL';
        $result = mysqli_query($db, $query);
        if(empty($result)) return;

        $parents = [];
        while ($row = mysqli_fetch_array($result)) {
            if($section != $row['id']) $parents[] = ['title' => $row['title'], 'section_name' => $row['section_name']];
        }

        mysqli_close($db);

        return ['items' => $items_paginated, 'meta_description' => $meta_description, 'meta_keywords' => $meta_keywords, 'title' => $title, 'parents' => $parents, 'section_name' => $section_name];
    }

}


function show_good($good)
{
    $db = mysqli_connect($GLOBALS['host'], $GLOBALS['login'], $GLOBALS['password'], $GLOBALS['database']);

    if ($db == false) {
        print("Ошибка: Невозможно подключиться к MySQL " . mysqli_connect_error());
    } else {
        mysqli_set_charset($db, "utf8");

        //Получаем секцию по названию
        $good = mysqli_real_escape_string($db, $good);
        $query = 'SELECT * FROM `goods` WHERE `id` = "' . $good . '"';
        $result = mysqli_query($db, $query);
        if (empty($result)) return;
        $row = mysqli_fetch_array($result);

        $meta_description = $row['meta_description'];
        $meta_keywords = $row['meta_keywords'];
        $section_name = $row['title'];
        $title = $GLOBALS['project_name'] . '|' . $row['title'];

        $item = $row;

        //Родительские разделы
        $query = 'SELECT * FROM `treepath` LEFT JOIN `catalog` on `catalog`.`id` = `treepath`.`ancestor` AND `treepath`.`descendant` = '.$row['catalog_id'].' WHERE `catalog`.`id` IS NOT NULL';
        $result = mysqli_query($db, $query);
        if(empty($result)) return;

        $parents = [];
        while ($row = mysqli_fetch_array($result)) {
            $parents[] = ['title' => $row['title'], 'section_name' => $row['section_name']];
        }

        mysqli_close($db);

        return ['item' => $item, 'meta_description' => $meta_description, 'meta_keywords' => $meta_keywords, 'title' => $title, 'parents' => $parents, 'section_name' => $section_name];
    }
}

function show_cart()
{

    if (!empty($_COOKIE['cart']))
    {
        $goods = [];
        foreach($_COOKIE['cart'] as $good_id => $cookie_cart)
        {
            $cart = json_decode($cookie_cart);
            $cart_count = $cart[0];
            $goods[] = [$good_id, $cart_count];
        }
    }
    else return;

    $db = mysqli_connect($GLOBALS['host'], $GLOBALS['login'], $GLOBALS['password'], $GLOBALS['database']);

    if ($db == false){
        print("Ошибка: Невозможно подключиться к MySQL " . mysqli_connect_error());
    }
    else {
        mysqli_set_charset($db, "utf8");

        $title = $GLOBALS['project_name'].'|Корзина';

        //Ищем товары для корзины
        foreach($goods as $good) {
            $good_id = $good[0];
            $count = $good[1];
            $good_id = mysqli_real_escape_string($db, $good_id);
            $query_good = 'SELECT * FROM `goods` WHERE `id` = ' . $good_id;
            $result_good = mysqli_query($db, $query_good);

            $row_good = mysqli_fetch_array($result_good);
            $items[] = ['row' => $row_good, 'type' => 'good', 'count' => $count];

        }

        //pagination
        $page = 1;
        if (isset($_GET['page'])) $page = $_GET['page'];

        $pagination = 12;
        $items_paginated = [];
        for ($i = ($page-1)*$pagination; $i < $page*$pagination; $i++)
        {
            if(!empty($items[$i])) $items_paginated[] = $items[$i];
        }

        mysqli_close($db);

        return ['items' => $items_paginated, 'title' => $title];
    }
}

function buy_form()
{
    if (!empty($_COOKIE['cart']))
    {
        $goods = [];
        foreach($_COOKIE['cart'] as $good_id => $cookie_cart)
        {
            $cart = json_decode($cookie_cart);
            $cart_count = $cart[0];
            $goods[] = [$good_id, $cart_count];
        }
    }
    else return;

    $db = mysqli_connect($GLOBALS['host'], $GLOBALS['login'], $GLOBALS['password'], $GLOBALS['database']);

    if ($db == false){
        print("Ошибка: Невозможно подключиться к MySQL " . mysqli_connect_error());
    }
    else {
        mysqli_set_charset($db, "utf8");

        $title = $GLOBALS['project_name'].'|Оформление заказа';

        //Ищем товары для корзины
        foreach($goods as $good) {
            $good_id = $good[0];
            $count = $good[1];
            $good_id = mysqli_real_escape_string($db, $good_id);
            $query_good = 'SELECT * FROM `goods` WHERE `id` = ' . $good_id;
            $result_good = mysqli_query($db, $query_good);

            $row_good = mysqli_fetch_array($result_good);
            $items[] = ['row' => $row_good, 'type' => 'good', 'count' => $count];

        }

        mysqli_close($db);

        return ['items' => $items, 'title' => $title];
    }
}