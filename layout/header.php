<?php
/**
 * author: Benjamin Kuermayr
 * version: 2020-03-04
 * subject: Umsetzung eines Webshops mit PHP
 */
session_start();
$pageid = (isset($_GET['pageid']))?htmlentities($_GET['pageid']):"shop";
$articles = $db->getArticles();

require('./functions/functions.php');
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
    <?php 
    $headerText = "Shoppolini - ";
    switch($pageid){
        case 'shop':
            $headerText .= "Der Nudel-Shop";
            break;
        case 'login': 
            $headerText .= "Login";
            break;
        case 'register':
            $headerText .= "Register Account";
            break;
        case 'account':
            $headerText .= "My account";
            break;
        case 'cart':
            $headerText .= "Shopping cart";
            break;
        case 'createarticle':
            $headerText .= "Add new product";
            break;
        case 'editarticle':
            $headerText .= "Edit product";
            break;
        case 'checkout':
            $headerText .= "Checkout";
            break;
        case 'payment':
            $headerText .= 'Finish order';
            break;
        case 'article':
            $headerText .= $articles[$_GET['articleid']]['title'];
            break;
        default:
            $headerText .= "Error";
    }
    echo $headerText;

    
    ?>
    </title>
    <link rel="stylesheet" href="dependencies/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="page-id-<?php echo $pageid?>">
    <nav class="navbar nav navbar-expand-md navbar-light top bg-light" role="navigation">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="./">
                            <!--<img src="./img/tgm-720x405.png" height="50px" alt="tgm logo"/>-->
                            SHOPPOLINI
                        </a>
                    </li>
                    <li class="nav-item">
                        <form class="searchform mb-0" action="" method="GET"> 
                            <div class="form-group d-flex flex-row w-100 mb-0">
                                <input hidden value="shop" name="pageid"/>
                                <input type="search" class="form-control w-75" name="search" id="searchinput" value="<?php if(isset($_GET['search'])){echo $_GET['search'];}?>">
                                <label class="mb-0 w-25" for="searchinput"><button class="btn btn-primary">Search</button></label>
                            </div>
                        </form>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./?pageid=shop">Shop</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./?pageid=cart">
                            <i class="fa fa-shopping-cart"> 
                            <span class="badge">
                                    <?php echo getCartAmount();?>
                                </span>
                            </i>
                            <span class="text-wrap icon">
                                Shopping cart
                            </span>
                        </a>
                    </li>
                    <?php if(isset($_SESSION ['user'])): ?>

                    <li class="nav-item">
                        <a class="nav-link" href="./?pageid=account"><i class="fa fa-user"></i><span class="text-wrap icon">Account</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./?pageid=logout"><i class="fa fa-sign-out" aria-hidden="true"></i><span class="text-wrap icon">Logout</span></a>
                    </li>
                    <?php else : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="./?pageid=login"><i class="fa fa-sign-in"></i><span class="text-wrap icon">Sign in</span></a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
    </nav>
