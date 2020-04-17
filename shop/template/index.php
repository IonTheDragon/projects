<?php require_once('header.php') ?>
<body>

<div class="nav">
<?php
    if(!empty($data['parents']))
    {
        $parents = $data['parents'];

        foreach ($parents as $parent) {
            echo '<a href="'.$_SERVER["PHP_SELF"].'?section='.$parent['section_name'].'">'.$parent['title'].'</a>/';
        }
    }
?>
<?php echo isset($data) && isset($data['parents']) && isset($data['section_name']) ? '<span>'.$data['section_name'].'</span>' : '<a href="'.$_SERVER["PHP_SELF"].'?section=main">Главная</a>' ?>

    <span class="cart_data">
        <span id="cart_count">Товаров всего: <?php echo isset($cart_count) ? $cart_count : '0' ?>,</span>
        <span id="cart_sum">Сумма: <?php echo isset($cart_sum) ? $cart_sum : '0' ?> руб</span>
        <a href="<?php echo $_SERVER['PHP_SELF']; ?>?cart"><img class="cart_img" width="25" src="./img/cart.png"></a>
    </span>
</div>

<?php
if (isset($is_buy) && $is_buy) {
    ?>
    <h2 style="text-align: center;">Оформление заказа</h2>
    <div>
        <?php
        if (empty($data)) {
            ?>
            <h2 style="text-align: center;">В настоящий момент корзина пуста<br><img width="150"
                                                                                   src="./img/satellite.png"></h2>
            <?php
        } else {
            if (!empty($data['items'])) {
                $items = $data['items'];

                foreach ($items as $item) {
                    ?>
                    <div class="buy_item">
                        <h4><?php echo $item['row']['title'] ?></h4>
                        <p>Цена: <?php echo $item['row']['price'] . ' ' . $item['row']['unit'] ?></p>
                        <p>Количество: <?php echo $item['count'] ?></p>
                    </div>
                    <?php
                }
                ?>
                <h3>Общая сумма <?php echo $cart_sum ?> руб.</h3>

                <form style="text-align: center;" action="./buy.php" method="post">

                    <p>ФИО</p>
                    <input type="text" name="name" style="width: 300px;" required>
                    <p>Телефон</p>
                    <input type="text" name="phone" data-inputmask="'mask': '+7 999 999 99 99'" style="width: 300px;" required>
                    <p>Email</p>
                    <input type="text" id="email" data-inputmask="'alias': 'email'" name="email" style="width: 300px;" required>
                    <p>Адрес доставки</p>
                    <input type="text" name="address" style="width: 300px;" required>
                    <p>Дата и время доставки</p>
                    <input type="text" id="datetimepicker" name="datetime" style="width: 300px;" required>

                    <br><br>
                    <input class="submit_button" type="submit" value="Отправить заказ">

                    <script src="./lib/Inputmask-5.x/dist/inputmask.js"></script>
                    <link rel="stylesheet" type="text/css" href="./lib/datetimepicker-master/jquery.datetimepicker.css"/>
                    <script src="./lib/datetimepicker-master/jquery.js"></script>
                    <script src="./lib/datetimepicker-master/jquery.datetimepicker.js"></script>
                    <script src="./lib/moment-with-locales.js"></script>
                    <script>
                        Inputmask().mask(document.querySelectorAll("input"));
                        $.datetimepicker.setDateFormatter('moment');
                        $('#datetimepicker').datetimepicker(
                            {
                                format:'YYYY-MM-DD HH:mm',
                            });
                    </script>
                </form>

                <?php
            } else {
                ?>
                <h2 style="text-align: center;">В настоящий момент корзина пуста<br><img width="150"
                                                                                       src="./img/satellite.png"></h2>
                <?php
            }
        }

        ?>
    </div>
    <?php
}
elseif (isset($is_cart) && $is_cart) {
    ?>
    <h2 style="text-align: center;margin-left: 20px;">Корзина</h2>
    <div class="catalog">
        <?php
        if (empty($data)) {
            ?>
            <h2 style="text-align: center;">В настоящий момент здесь пусто<br><img width="150"
                                                                                   src="./img/satellite.png"></h2>
            <?php
        } else {
            if (!empty($data['items'])) {
                $items = $data['items'];

                foreach ($items as $item) {
                        ?>
                        <div class="item" id="item_<?php echo $item['row']['id'] ?>">
                            <a href="<?php echo $_SERVER["PHP_SELF"] ?>?good=<?php echo $item['row']['id'] ?>">
                                <img width="150" onerror="this.src='./img/satellite.png';"
                                     src="<?php echo $item['row']['image'] ?>">
                            </a>
                            <h4><?php echo $item['row']['title'] ?></h4>
                            <p><?php echo $item['row']['price'] . ' ' . $item['row']['unit'] ?> <img onClick="add_to_cart(<?php echo $item['row']['id'].','.$item['row']['price'] ?>)" class="cart_img"
                                                                                                     width="20"
                                                                                                     src="./img/cart.png">
                                <img onClick="delete_from_cart(<?php echo $item['row']['id'] ?>)" class="cart_img" width="20" height="20" src="./img/delete.png">
                            </p>
                            <form>
                                <input type="number" value="<?php echo $item['count'] ?>" min="1" id="count_<?php echo $item['row']['id'] ?>" name="count">
                            </form>

                        </div>
                        <?php
                }
            } else {
                ?>
                <h2 style="text-align: center;">В настоящий момент здесь пусто<br><img width="150"
                                                                                       src="./img/satellite.png"></h2>
                <?php
            }
        }

        ?>
    </div>

    <div style="
    display: flex;
    justify-content: center;
    margin-left: 20px;
">

        <!--//Предыдущая страница-->
        <?php
        $query = $_GET;
        $prev_page = isset($query['page']) ? $query['page'] - 1 : 0;
        // Заменяем параметр страницы
        $query['page'] = $prev_page;
        // Получаем запрос для следующей страницы раздела
        $query_result = http_build_query($query);
        ?>

        <?php if ($prev_page) { ?>
            <a href="<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo $query_result; ?>"><img width="50"
                                                                                            src="./img/prev.png"></a>
        <?php } else { ?>
            <img width="50" height="50" src="./img/prev.png">
        <?php } ?>

        <?php
        $query = $_GET;
        $page = isset($query['page']) ? $query['page'] : 1;
        ?>
        <h2 class="current_page"><?php echo $page ?></h2>

        <!--Следующая страница-->
        <?php
        $query = $_GET;
        $next_page = isset($query['page']) ? $query['page'] + 1 : 2;
        // Заменяем параметр страницы
        $query['page'] = $next_page;
        // Получаем запрос для следующей страницы раздела
        $query_result = http_build_query($query);
        ?>

        <?php if (!empty($data) && !empty($data['items'])) { ?>
            <a href="<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo $query_result; ?>"><img width="50"
                                                                                            src="./img/next.png"></a>
        <?php } else { ?>
            <img width="50" height="50" src="./img/next.png">
        <?php } ?>

    </div>

    <?php
}
elseif (isset($is_section) && $is_section) {
    ?>
    <div class="catalog">
        <?php
        if (empty($data)) {
            ?>
            <h2 style="text-align: center;">В настоящий момент здесь пусто<br><img width="150"
                                                                                   src="./img/satellite.png"></h2>
            <?php
        } else {
            if (!empty($data['items'])) {
                $items = $data['items'];

                foreach ($items as $item) {
                    if ($item['type'] == 'section') {
                        ?>
                        <div class="item">
                            <a href="<?php echo $_SERVER["PHP_SELF"] ?>?section=<?php echo $item['row']['section_name'] ?>">
                                <img width="150" onerror="this.src='./img/satellite.png';"
                                     src="<?php echo $item['row']['image'] ?>">
                            </a>
                            <h4><?php echo $item['row']['title'] ?></h4>
                            <p><?php echo $item['row']['description'] ?></p>
                        </div>
                        <?php
                    } elseif ($item['type'] == 'good') {
                        ?>
                        <div class="item">
                            <a href="<?php echo $_SERVER["PHP_SELF"] ?>?good=<?php echo $item['row']['id'] ?>">
                                <img width="150" onerror="this.src='./img/satellite.png';"
                                     src="<?php echo $item['row']['image'] ?>">
                            </a>
                            <h4><?php echo $item['row']['title'] ?></h4>
                            <p><?php echo $item['row']['price'] . ' ' . $item['row']['unit'] ?> <img onClick="add_to_cart(<?php echo $item['row']['id'].','.$item['row']['price'] ?>)" class="cart_img"
                                                                                                     width="20"
                                                                                                     src="./img/cart.png">
                            </p>
                        </div>
                        <?php
                    }
                }
            } else {
                ?>
                <h2 style="text-align: center;">В настоящий момент здесь пусто<br><img width="150"
                                                                                       src="./img/satellite.png"></h2>
                <?php
            }
        }

        ?>
    </div>

    <div style="
    display: flex;
    justify-content: center;
    margin-left: 20px;
">

        <!--//Предыдущая страница-->
        <?php
        $query = $_GET;
        $prev_page = isset($query['page']) ? $query['page'] - 1 : 0;
        // Заменяем параметр страницы
        $query['page'] = $prev_page;
        // Получаем запрос для следующей страницы раздела
        $query_result = http_build_query($query);
        ?>

        <?php if ($prev_page) { ?>
            <a href="<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo $query_result; ?>"><img width="50"
                                                                                            src="./img/prev.png"></a>
        <?php } else { ?>
            <img width="50" height="50" src="./img/prev.png">
        <?php } ?>

        <?php
        $query = $_GET;
        $page = isset($query['page']) ? $query['page'] : 1;
        ?>
        <h2 class="current_page"><?php echo $page ?></h2>

        <!--Следующая страница-->
        <?php
        $query = $_GET;
        $next_page = isset($query['page']) ? $query['page'] + 1 : 2;
        // Заменяем параметр страницы
        $query['page'] = $next_page;
        // Получаем запрос для следующей страницы раздела
        $query_result = http_build_query($query);
        ?>

        <?php if (!empty($data) && !empty($data['items'])) { ?>
            <a href="<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo $query_result; ?>"><img width="50"
                                                                                            src="./img/next.png"></a>
        <?php } else { ?>
            <img width="50" height="50" src="./img/next.png">
        <?php } ?>

    </div>

    <?php
}
else
{
    ?>
    <div class="good">
        <?php
        if (empty($data)) {
            ?>
            <h2 style="text-align: center;">В настоящий момент здесь пусто<br><img width="150" src="./img/satellite.png"></h2>
            <?php
        } else {
            if (!empty($data['item'])) {
                $item = $data['item'];

                ?>
                <div class="good_item">
                    <img class="good_image" onerror="this.src='./img/satellite.png';" src="<?php echo $item['image'] ?>">
                </div>
                <div class="good_item">
                    <h4><?php echo $item['title'] ?></h4>
                    <p><?php echo $item['description'] ?></p>
                    <p><?php echo $item['price'] . ' ' . $item['unit'] ?> <img onClick="add_to_cart(<?php echo $item['id'].','.$item['price'] ?>)" class="cart_img"
                                                                                                     width="20"
                                                                                                     src="./img/cart.png">
                    </p>
                    <form>
                        <input type="number" value="1" min="1" id="count" name="count">
                    </form>
                </div>
                <?php
            } else {
                ?>
                <h2 style="text-align: center;">В настоящий момент здесь пусто<br><img width="150" src="./img/satellite.png"></h2>
                <?php
            }
        }

        ?>
    </div>
    <?php
}
?>

<?php
if (isset($is_cart) && $is_cart) {
?>
    <div style="
        text-align: center;
        margin-top: 20px;
        margin-left: 20px;
    ">
        <a href="<?php echo $_SERVER['PHP_SELF']; ?>?buy"><img src="./img/buy.png"></a>
    </div>
<?php
}
?>

<?php require_once('footer.php') ?>
