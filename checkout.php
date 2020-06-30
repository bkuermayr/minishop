<?php 
    $productdata = $_POST['cart'];
    if(!isset($_POST['cart']) && isset($_SESSION['user'])) {
        header('Location: ?pageid=cart');
    }

    if(isset($articles)) {
        $articles = $articles;
    }else {
        echo 'Error: articles not set';
        die();
    }

    $delivery = "5";
    $subtotal = 0;
    $user = $_SESSION['user'];
    $_POST['user'] = $user;
    
    $deliveryInfo = array(
        'name' => (isset($user['name']))?$user['name']:NULL,
        'addressline1' => (isset($user['addressline1']))?$user['addressline1']:NULL,
        'addressline2' => (isset($user['addressline2']))?$user['addressline2']:NULL,
        'city' => (isset($user['city']))?$user['city']:NULL,
        'state' => (isset($user['state']))?$user['state']:NULL,
        'zipcode' => (isset($user['zipcode']))?$user['zipcode']:NULL,
        'country' => (isset($user['country']))?$user['country']:NULL,
        'phone' => (isset($user['phone']))?$user['phone']:NULL,
        'deliveryinstructions' => (isset($user['deliveryinstructions']))?$user['deliveryinstructions']:NULL,
    );


    $_POST['deliveryInfo'] = $deliveryInfo;

?>

<div class="container row text-left">
    <div class="col-md-8">
        <h5 class="w-100 p-2 bg-primary text-light"><?php if($_GET['pageid']=='checkout'){echo 'Delivery Information';}else {echo'Process payment';}?></h5> 
        <div class="container pl-4 pt-2 ">
            <?php 
            if(isset($deliveryInfo['addressline1']) && isset($deliveryInfo['city']) && isset($deliveryInfo['name'])  
            && isset($deliveryInfo['state']) && isset($deliveryInfo['zipcode']) && isset($deliveryInfo['country']) && !isset($_GET['deliveryinfo']) && $_GET['pageid'] != 'payment'):
            ?>
                <ul class="list-unstyled">  
                    <li><h4><?php echo $deliveryInfo['name'] ?></h4></li>
                    <li><?php echo $deliveryInfo['addressline1'] ?></li>
                    <li><?php echo $deliveryInfo['addressline2'] ?></li>
                    <li><?php  echo $deliveryInfo['state'].', '.$deliveryInfo['city'].' '.$deliveryInfo['zipcode'];?></li>
                    <li><?php echo $deliveryInfo['country'] ?></li>
                    <li><?php if(isset($deliveryInfo['phone']) && $deliveryInfo['phone'] != NULL){ echo 'Phone: '.$deliveryInfo['phone']; }?></li>
                    <li><?php if(isset($deliveryInfo['deliveryinstructions']) && $deliveryInfo['deliveryinstructions'] != NULL){ echo '<br/><u>Delivery instructions:</u><br/> '.$deliveryInfo['deliveryinstructions']; }?></li>
                </ul>
                <a class="btn btn-primary" href="?pageid=checkout&deliveryinfo=edit">Edit</a><a class="btn btn-primary ml-3 text-right" href="?pageid=payment">Deliver to this address</a>
        <?php elseif($_GET['pageid'] != 'payment'): ?>
            <?php include('./forms/deliveryForm.php'); ?>
        <?php elseif($_GET['pageid'] == 'payment'): ?>
            <?php include('./payment.php'); ?>
        <?php endif;?>
        </div>
    </div>
    <div class="col-md-4">
        <h5 class="w-100 p-2 bg-primary text-light">Order summary</h5> 
        <div class="container">
        <?php foreach($productdata as $product): ?>
        <div class="product-item row  p-2">
            <div class="img-wrapper">
                <img class="cover" src="<?php echo UPLOAD_PATH.$articles[$product['articleid']-1]['images'][0]; ?>" alt="product image" />
            </div>
            <div class="product-content">
                <small><b><?php echo $articles[$product['articleid']-1]['title']; ?></b></small> <br/> 
                <small>Unit price: <?php echo $articles[$product['articleid']-1]['unitprice']; ?></small> <br/>
                <small>Quantity: <?php echo $product['quantity']; ?></small> 
            </div>
        </div>
        <?php 
            $subtotal = $subtotal +($product['quantity']*rtrim($articles[$product['articleid']-1]['unitprice'],"€"));
        ?>
        <?php endforeach; ?>
        </div>
        <hr/>
        <p class="pb-0">Subtotal: <?php echo $subtotal;?>€</p> 
        <p>Delivery: <?php echo $delivery; ?>€</p>
        <hr/>
        <p><b>Total: <?php echo $delivery+$subtotal; ?>€</b></p> <br/>
    </div>
</div>