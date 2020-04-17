<?php require_once('./template/header.php') ?>
<body>
    <div style="text-align: center;padding: 200px;">
        <h2>Заказ оформлен</h2>
        <p>Ваш идентификатор заказа</p>
        <p><?php echo isset($_GET['order_id']) ? $_GET['order_id'] : '' ?></p>
        <a href="./index.php">Вернуться на главную</a>
    </div>

<?php require_once('./template/footer.php') ?>