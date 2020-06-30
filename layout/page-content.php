<?php 
//Article data

$users = array();
$users[] = array(
    "username" => "bkuermayr",
    "name" => "Benjamin Kürmayr",
    "gender" => "male",
    "role" => "admin",
    "birthdate" => "2003-02-04",
    "email" => "test@test.com",
    'password' => '$2y$10$Exq.dF62ug4019awvXOmGePH0fHyhJU1NcXukdoVywDO4q5F.4rJC',
    'newsletter' => 'false',
    'addressline1' => 'Mustergasse 1',
    'addressline2' => 'Tür 1',
    'phone' => '0676 190409',
    'city' => 'Wien',
    'state' => 'Wien',
    'country' => 'Austria',
    'deliveryinstructions' => 'Lorem ipsum..',
);

if(!isset($_SESSION['users'])) {
    $_SESSION['users'] = $users;
}

if(!isset($_SESSION['orders'])) {
    $_SESSION['orders'] = array();
}

if(!isset($_SESSION['captcha'])) {
    $_SESSION['captcha'] = '';
}
?>


<?php $pageid = (isset($_GET['pageid']))?$_GET['pageid']:"shop"; ?>


<div class="container-fluid d-flex justify-content-center align-items-center bg-primary" id="banner">
    <div class="slider-content">
        <h1 class=""><?php 
    
        echo $headerText;
        
        ?></h1>
    </div>

</div>
<div class="container-fluid pb-5" id="page-content">
    <div class="container text-center py-5">
        <?php 
            switch($pageid) {
                case 'register':
                    if(!isset($_SESSION['user'])) {
                        require('./forms/registration.php'); 
                    }else {
                        header("Location: ./?pageid=shop");
                    }
                    break;
                case 'shop':
                    require('./shop.php');
                    break;
                case 'cart':
                    require('./cart.php'); 
                    break;
                case 'account':
                    if(isset($_SESSION['user'])) {
                        require('./account.php'); 
                    }else {
                        header("Location: ./?pageid=login");
                    }
                    break;
                case 'createarticle':
                    if(isset($_SESSION['user']) && $_SESSION['user']['role'] == 'admin') {
                        require('./forms/createarticle.php'); 
                    }else {
                        header("Location: ./?pageid=login");
                    }
                    break;
                case 'editarticle':
                    if(isset($_SESSION['user']) && $_SESSION['user']['role'] == 'admin') {
                        require('./forms/createarticle.php'); 
                    }else {
                        header("Location: ./?pageid=login");
                    }
                    break;
                case 'logout':
                    session_destroy();
                    header("Location: ./?pageid=login");

                case 'login':
                    if(!isset($_SESSION['user'])) {
                        require('./forms/login.php'); 
                    }else {
                        header("Location: ./?pageid=shop");
                    }
                    break;
                case 'payment':
                    if(isset($_SESSION['user'])) {
                        $_POST['cart'] = $_SESSION['cart'];
                        require('./checkout.php'); 
                    }else {
                        header("Location: ./?pageid=login");
                    }
                    break;
                case 'article':
                    require('./layout/article.php');        
                    break;
                case 'checkout':
                    if(isset($_SESSION['user'])) {
                        $_POST['cart'] = $_SESSION['cart'];
                        require('./checkout.php'); 
                    }else {
                        header("Location: ./?pageid=login&ref=checkout");
                    }
                    break;
                default:
                    require('./error.php');
            }
        ?>
    </div>
</div>