<?php 

    if(isset($_SESSION['cart'])) {
        $cartdata = $_SESSION['cart']; 
    }else {
        $cartdata = null;
    }

    if(isset($articles)) {
        $articles = $articles;
    }else {
        echo 'Error: articles not set';
        die();
    }


    $total = 0;
    $totalQuantity = 0;
//echo var_dump($cartdata);
?>
<div class="text-center container cart-wrapper">
    <?php if($cartdata == null): ?>
        <h3>Your shopping cart is empty.</h3>
        <a href="?pageid=shop" class="btn btn-primary mt-3" >Continue shopping</a>
    <?php else: ?>
        <?php foreach($cartdata as $key => $cartitem): ?>
            <?php if($cartitem != null): ?>
            <?php   
            $totalitem = rtrim($articles[$cartitem['articleid']]['unitprice'],"€")*$cartitem['quantity'];
            $total = $total + $totalitem;
            $totalQuantity = $totalQuantity + $cartitem['quantity'];         
            ?>
            
            <div class="cart-item text-left row w-100">
                <div class="img-wrapper col-4">
                    <a href="?pageid=article&;articleid=<?php echo $cartitem['articleid']; ?>"><img class="img-fluid" src="<?php echo UPLOAD_PATH.$articles[$cartitem['articleid']]['images'][0]; ?>" alt="product image"/></a>
                </div>
                <div class="col-6">
                    <a class="text-decoration-none text-black" href="?pageid=article&;articleid=<?php echo $cartitem['articleid']; ?>"><h5><?php echo $articles[$cartitem['articleid']]['title']; ?></h5></a>
                    <?php if($articles[$cartitem['articleid']]['quantity'] < 15): ?>
                        <p class="quantity <?php if($articles[$cartitem['articleid']]['quantity'] < 10) { echo "low";}?>"><?php if($articles[$cartitem['articleid']]['quantity']  < 10) { echo "Only ";}?><?php echo $articles[$cartitem['articleid']]['quantity'] ;?> more products left</p>
                    <?php endif;?>
                    <form class="w-100" action="./functions/updatecartamount.php" method="POST">
                        <label for="amountInput<?php echo $key; ?>">Order amount:</label>
                        <select id="amountInput<?php echo $key; ?>" name="amountInput" onchange="this.form.submit()">
                            <?php 
                                for($j = 0; $j <= $articles[$cartitem['articleid']]['quantity'] && $j < 100; $j++) {
                                    if($j == $cartitem['quantity']) {
                                        echo '<option selected value="'.$j.'">'.$j.'</option>';
                                    }else if($j == 0){
                                        echo '<option value="'.$j.'">'.$j.' (Delete)</option>';
                                    } else {
                                        echo '<option value="'.$j.'">'.$j.'</option>';
                                    }
                                }
                            ?>
                        </select>
                        <input type="hidden" name="articleid" value="<?php echo $cartitem['articleid']; ?>"/>
                    </form>

                    <br/>
                    <form class="w-100 text-left" action="./functions/removefromcart.php?articleid=<?php echo $cartitem['articleid'];?>">
                        <button type="submit" name="articleid" value="<?php echo $cartitem['articleid'];?>" class="p-0 pt-2 text-left btn btn-link">Remove product</a>
                    </form>
                </div>
                <div class="col-2">
                    <p class="">Price: <?php echo $totalitem; ?>€</p>
                </div>
            </div>  
            <hr/>
            <?php endif;?>
        <?php endforeach; ?>
        <div class="text-right">
            <p>Total (<?php echo $totalQuantity; ?> Products): <?php echo $total; ?>€</p>
            <div>
                <a class="btn btn-primary mt-3 text-right" href="?pageid=shop">Continue shopping</a>
                <a class="btn btn-primary mt-3 text-right" href="?pageid=checkout">Proceed to checkout</a>
            </div>
        </div>
    <?php endif;?>
</div>