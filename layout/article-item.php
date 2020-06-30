<?php 
    $article = $_POST['article']; 
?>
<div class="article col-md-4 col-sm-12">
    <div class=" my-3 bg-light">
        <a class="link" href="?pageid=article&articleid=<?php echo $article['id_product'] ?>">
            <div class="img-wrapper">
                <img src="<?php echo UPLOAD_PATH.$article['images'][0];?>" class="img-fluid" alt="product image"/>
            </div>
        </a>
        <div class="p-4">
            <a class="link" href="?pageid=article&articleid=<?php echo $article['id_product'] ?>"><h3 class=""><?php echo $article['title']; ?></h3></a>
            <a class="link" href="?pageid=article&articleid=<?php echo $article['id_product'] ?>"><span class="price"><?php echo $article['unitprice'].DEFAULT_CURRENCY.' / '. $article['unit']; ?></span></a>
            <a class="link" href="?pageid=article&articleid=<?php echo $article['id_product'] ?>"><p><?php echo $article['description_short']; ?></p></a>
            <?php if(isset($_SESSION['user']) && $_SESSION['user']['role'] == 'admin'): ?><a class="btn btn-primary" href="?pageid=editarticle&articleid=<?php echo $article['id_product'] ?>&refresh=force">Edit</a><?php endif;?>
        </div>
    </div>
</div>
