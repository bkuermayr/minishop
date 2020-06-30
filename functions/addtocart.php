<?php 
    session_start();
    if(isset($_SESSION['cart'][$_GET['articleid']])){
        $_SESSION['cart'][$_GET['articleid']] = array(
            "quantity" => $_SESSION['cart'][$_GET['articleid']]['quantity']+$_POST['quantityInput'],
            "articleid" => $_GET['articleid'],
        );
    }else {
        $_SESSION['cart'][$_GET['articleid']] = array(
            "quantity" => $_POST['quantityInput'],
            "articleid" => $_GET['articleid'],
        );
    }

    if(isset($_POST['checkout']) && $_POST['checkout'] == 'checkout') {
        header("Location: ../?pageid=checkout");
    }else {
        header("Location: ../?pageid=shop&newitem=".$_GET['articleid']);
    }
    die();
?>