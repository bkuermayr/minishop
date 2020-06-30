<?php 
    if(isset($_GET['articleid'])){
        $articleid = $_GET['articleid'];
        //get specific article data
        $articledata = $db->getArticle($articleid);
    }else {
        header("Location: ?pageid=shop");
    }
?>
<?php if(isset($articledata)): ?>
<div class="row container">
    <div class="col-md-6 col-sm-12">

        <div id="carouselExampleIndicators" class="carousel slide" >
           
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100" src="<?php echo UPLOAD_PATH.$articledata['images'][0];?>" alt="no product image">
                </div>
                <?php 
                    foreach($articledata['images'] as $key => $imgsrc) {
                        if($key != 0) {
                            echo '
                            <div class="carousel-item">
                            <img class="d-block w-100" src="'.(UPLOAD_PATH.$imgsrc).'" alt="slide '.$key.'">
                            </div>
                            ';                                      
                        }
                    }
                ?>
            </div>

            <ol class="carousel-indicators row">
                <?php 
                 
                    if(count($articledata['images']) > 1){
                        echo '
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active col-12"><div class="img-wrap"><img src="'.UPLOAD_PATH.$articledata['images'][0].'"/></div></li>
                        ';  
                    }
                    foreach($articledata['images'] as $key => $imgsrc) {
                        if($key != 0) {
                            echo '
                            <li data-target="#carouselExampleIndicators" data-slide-to="'.$key.'" class="col-12"><div class="img-wrap"><img src="'.UPLOAD_PATH.$articledata['images'][$key].'" /></div></li>
                            ';                                      
                        }
                    }
                ?>
            </ol>
        </div>

    </div>
    <div class="col-md-6 col-sm-12 text-left">
        <div class="">
            <h1><?php echo $articledata['title'];?></h1>
            <p class="price"><?php echo $articledata['unitprice'] .' / '. $articledata['unit']; ?></p>
            <p><?php echo $articledata['description_long'];?></p>
            <p>Weight: <?php echo displayWeight($articledata['productweight']);?></p>
            <form action="./functions/addtocart.php?articleid=<?php echo $_GET['articleid']; ?>" class="text-left w-100" method="POST">
                <label for="quantityInput">Quantity:</label>
                <select id="quantityInput" name="quantityInput">
                    <?php 
                        for($j = 1; $j <= $articledata['quantity'] && $j < 100; $j++) {
                            echo '<option value="'.$j.'">'.$j.'</option>';
                        }
                    ?>
                </select><br/<br/><br/>
                <button type="submit" class="btn btn-primary mr-2" name="addtocart" value="addtocart">Add to cart</button>
                <button type="submit" class="btn btn-primary" name="checkout" value="checkout">Buy now</button>
            </form>
            <?php if(isset($_SESSION['user']) && $_SESSION['user']['role'] == 'admin'): ?><a class="btn btn-primary" href="?pageid=editarticle&articleid=<?php echo $_GET['articleid'] ?>&refresh=force">Edit</a><?php endif;?>
        </div>
        <div class="align-end">
            <?php if($articledata['quantity'] < 15): ?>
                <p class="quantity <?php if($articledata['quantity'] < 10) { echo "low";}?>"><?php if($articledata['quantity'] < 10) { echo "Only ";}?><?php echo $articledata['quantity'];?> more products left</p>
            <?php endif;?>
        </div>
    </div>
</div>
<?php endif; ?>