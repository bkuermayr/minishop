<?php 
    $cartcount = 0;
    if(isset($_SESSION['cart'])){
        $cartdata = $_SESSION['cart'];
        foreach($cartdata as $cartitem) {
            $cartcount = $cartcount + $cartitem['quantity'];
        }
    }

    return $cartcount;
    die();
?>