<?php
require_once('config.php');

require_once "./SendMailSmtpClass/SendMailSmtpClass.php";

if(empty($_POST['name']) || empty($_POST['phone']) || empty($_POST['email']) || empty($_POST['address']) || empty($_POST['datetime']))
{
    header('Location: ./error.php');
    return;
}

if (!empty($_COOKIE['cart']))
{
    $goods = [];
    $cart_sum = 0;
    foreach($_COOKIE['cart'] as $good_id => $cookie_cart)
    {
        $cart = json_decode($cookie_cart);
        $cart_count = $cart[0];
        $goods[] = [$good_id, $cart_count];
        $cart_sum += $cart[0]*$cart[1];
    }
}
else {
    header('Location: ./error.php');
    return;
}

$db = mysqli_connect($GLOBALS['host'], $GLOBALS['login'], $GLOBALS['password'], $GLOBALS['database']);

if ($db == false){
    header('Location: ./error.php');
    return;
}
else {
    mysqli_set_charset($db, "utf8");
    $name = mysqli_real_escape_string($db,$_POST['name']);
    $phone = mysqli_real_escape_string($db,$_POST['phone']);
    $email = mysqli_real_escape_string($db,$_POST['email']);
    $address = mysqli_real_escape_string($db,$_POST['address']);
    $datetime = mysqli_real_escape_string($db,$_POST['datetime']);

    $order_id = hash('ripemd160', time().$email);

    $message = 'Имя: '.$name."<br/>";
    $message .= 'Телефон: '.$phone."<br/>";
    $message .= 'Email: '.$email."<br/>";
    $message .= 'Адрес доставки: '.$address."<br/>";
    $message .= 'Дата и время доставки: '.$datetime."<br/>";

    foreach($goods as $good) {

        $good_id = $good[0];
        $count = $good[1];
        $good_id = mysqli_real_escape_string($db, $good_id);
        $query_good = 'SELECT * FROM `goods` WHERE `id` = ' . $good_id;
        $result_good = mysqli_query($db, $query_good);

        $row_good = mysqli_fetch_array($result_good);
        $message .= $row_good['title'] . "<br/>" . 'Цена: ' . $row_good['price'] . $row_good['unit'] . "<br/>" . 'Количество: ' . $count . "<br/><br/>";

        $query_insert = 'INSERT INTO `orders`(`id`, `order_id`, `name`, `phone`, `email`, `address`, `datetime`, `good_id`, `count`) VALUES (0,"'.$order_id.'","'.$name.'","'.$phone.'","'.$email.'","'.$address.'","'.$datetime.'","'.$good_id.'",'.$count.')';

        mysqli_query($db, $query_insert);
    }

    $to      = $GLOBALS['mail_to'];
    $subject = 'Оформление заказа от '.$email;
    $message .= 'Общая сумма: '.$cart_sum.' руб';

    // заголовок письма
    $headers= "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=utf-8\r\n"; // кодировка письма
    $headers .= "From: ".$GLOBALS['mail_config']["from"]." <".$GLOBALS['mail_config']["login"].">\r\n"; // от кого письмо

    $mailSMTP = new SendMailSmtpClass($GLOBALS['mail_config']["login"], $GLOBALS['mail_config']["password"], $GLOBALS['mail_config']["mailbox"], $GLOBALS['mail_config']["from"], 465);

    $mailSMTP->send($to, $subject, $message, $headers);

    //unset($_COOKIE['cart']);
    //setcookie('cart', null);

    header('Location: ./success.php?order_id='.$order_id);
    return;
}