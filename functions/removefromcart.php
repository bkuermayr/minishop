<?php 
    session_start();

    unset($_SESSION['cart'][$_GET['articleid']]);

    header("Location: ../?pageid=cart");
    die();
?>