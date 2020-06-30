<?php 
    session_start();
    
    if(isset($_SESSION['cart'][$_POST['articleid']])){
        $_SESSION['cart'][$_POST['articleid']] = array(
            "quantity" => $_POST['amountInput'],
            "articleid" => $_POST['articleid'],
        );
    }

    if($_POST['amountInput'] == 0) {
        unset($_SESSION['cart'][$_POST['articleid']]);
    }

    header("Location: ../?pageid=cart");
    die();
?>