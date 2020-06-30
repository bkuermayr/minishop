<?php 
$delivery = 5;
if(isset($_SESSION['user'])){
    $user = $_SESSION['user'];
?>
<div class="account-wrapper container row text-left d-flex flex-column ">
    <div class="col-md-6 mx-auto">
        <h2>User account:</h2>
        <p class="mb-1">Username: <?php echo $user['username'];?></p>
        <p class="mb-1">Name: <?php echo $user['name'];?></p>
        <p class="mb-1">Email: <?php echo $user['email'];?></p>
        <p class="mb-1">Gender: <?php echo $user['gender'];?></p>
        <p class="mb-1">Birthdate: <?php echo $user['birthdate'];?></p>
    </div>
    <div class="col-md-6 mx-auto pt-5" id="orders">
        <h2 class="pb-3">My orders:</h2>
        <?php if(isset($_SESSION['orders'])){
            foreach($_SESSION['orders'] as $key => $order) {
                if($order['user']['username'] == $_SESSION['user']['username']) {
                    $productdata = $order['cart'];
                    $ordersummary = '<div class="order-sum mb-2">
                    <h5 class="w-100 p-2 bg-primary text-light">Order'.$key.' summary</h5> 
                    <div class="container">';
                    
                    $subtotal = 0;
                    foreach($productdata as $product) {
                        $subtotal = $subtotal +($product['quantity']*rtrim($articles[$product['articleid']-1]['unitprice'],"€"));
                        $ordersummary.='<div class="product-item row  p-2">
                            <div class="img-wrapper">
                                <img class="cover" src="'.UPLOAD_PATH.$articles[$product['articleid']-1]['images'][0].'" alt="product image" />
                            </div>
                            <div class="product-content">
                                <small><b>'.$articles[$product['articleid']-1]['title'].'</b></small> <br/> 
                                <small>Unit price: '.$articles[$product['articleid']-1]['unitprice'].'</small> <br/>
                                <small>Quantity: '.$product['quantity'].'</small> 
                            </div>
                        </div>';
                    }    

                    $ordersummary.= '
                    </div>
                    <hr/>
                    <p class="pb-0">Subtotal: '.$subtotal.'€</p> 
                    <p>Delivery: '.$delivery.'€</p>
                    <hr/>
                    <p><b>Total: '.($delivery+$subtotal).'€</b></p> <br/>
                    </div>';

                    echo $ordersummary;
                }
            }
        }  
        ?>
    </div>
    <?php if(isset($_SESSION['user']) && $_SESSION['user']['role'] == 'admin'): ?>
    <div class="col-md-6 mx-auto pt-5">
        <h2 class="pb-3">Add products:</h2>
        <a href="?pageid=createarticle" class="btn btn-primary">Add new product</a>
    </div>
    <?php endif;?>
</div>
<?php }else {
        header('Location: ?pageid=login');
      }
?>