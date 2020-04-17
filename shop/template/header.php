<html>
<head>
    <title><?php echo isset($data) && isset($data['title']) ? $data['title'] : 'Аэрокосмическая промышленность' ?></title>
    <meta charset="UTF-8">
    <meta name="keywords" content="<?php echo isset($data) && isset($data['meta_keywords']) ? $data['meta_keywords'] : '' ?>">
    <meta name="description" content="<?php echo isset($data) && isset($data['meta_description']) ? $data['meta_description'] : '' ?>">
    <link rel="shortcut icon" href="./img/favicon.png">
</head>

<style>
    .catalog {
        display: flex;
        flex-wrap: wrap;
        width: calc(100% + 20px);
        justify-content: center;
    }

    .good {
        display: flex;
        flex-wrap: wrap;
        width: calc(100% + 20px);
        border: 2px solid #dedede;
    }

    .good_item {
        width: calc((100% / 3) - 20px);
        flex: 0 0 auto;
        margin: 0 10px 20px 10px;
        padding-top: 10px;
    }

    .item {
        width: calc((100% / 3) - 20px);
        flex: 0 0 auto;
        margin: 0 10px 20px 10px;
        text-align: center;
        border: 2px solid #dedede;
        padding-top: 10px;
    }

    .buy_item
    {
        border: 2px solid #dedede;
        padding-left: 10px;
    }

    .nav {
        margin-bottom: 20px;
    }

    .cart_img {
        vertical-align: middle;
        cursor: pointer;
    }

    .current_page {
        margin: 0;
        margin-top: 10px;
        padding: 0 10px;
        color: #41c0fc;
    }

    .good_image {
        width: 100%;
        max-width: 500px;
    }
    /*
    .good_image:hover {
        width: 500px;
        position: absolute;
        transition: width 2s, height 2s, background-color 2s, transform 2s;
    }
    */

    .cart_data
    {
        float: right;
    }

    .submit_button
    {
        background-color: cornflowerblue;
        color: white;
        padding: 10px;
        border-radius: 10px;
        font-size: 28px;
    }
</style>
