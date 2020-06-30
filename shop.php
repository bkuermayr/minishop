
<?php 
if(isset($_GET['newitem'])):?>
<div class="container row py-3">
    <div class="mx-auto addedtocart row  bg-light p-3 d-flex flex-row-reverse justify-content-center align-items-center ">
        <a class="btn btn-primary mt-0 text-right" href="?pageid=checkout">Checkout</a>
        <a class="btn btn-primary mt-0 ml-3 mr-3 text-right" href="?pageid=cart">Cart</a>
        <h5 class="m-0 pl-3 text-success font-weight-bold">Successfully added to cart.</h5>
        <div class="cart img-wrapper border border-success">
            <a href="?pageid=article&articleid=<?php echo $_GET['newitem']; ?>"><img class="cover " src="<?php echo UPLOAD_PATH.$articles[$_GET['newitem']]['images'][0]; ?>" alt="product image" /></a>
        </div>
    </div>
</div>
<?php endif; ?>
<div class="container row py-3">
<?php 
    if(isset($_GET['search'])){
        $search = strtolower($_GET['search']);

        foreach($articles as $key => $article) {
            preg_match('/'.$search.'/',strtolower($article['title']),$matches);
            if(count($matches) > 0) {
                $_POST['article'] = $article;
                include("./layout/article-item.php");
            }
        }
    } else {
        foreach($articles as $key => $article) {
            $_POST['article'] = $article;
            include("./layout/article-item.php");
        }
    }

?>
</div>
