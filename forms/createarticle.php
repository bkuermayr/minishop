
<?php 

    if(isset($_GET['pageid']) && $_GET['pageid'] == 'editarticle' && isset($_GET['articleid'])) {
        if(!isset($_SESSION['articledata'])) {
            $_SESSION['articledata'] = $articles[$_GET['articleid']-1];
        }

        if(isset($_GET['refresh'])){
            $articles = $db->getArticles();
            $_SESSION['articledata'] = $articles[$_GET['articleid']-1];
            header('Location: '.removeFromUrl('refresh'));
        }

        $articledata = $_SESSION['articledata'];
        $buttonText = 'Update product information';
        $mode = 'update';
        $link = 'editarticle';
    }else {
        $buttonText = 'Add new product';
        $mode = 'create';
        $link = 'createarticle';
        $_SESSION['articledata'] = array();
    }


    if(isset($_FILES['files'])) {
        uploadImages($_FILES['files']);
        foreach($_FILES['files']['name'] as $index => $value) {
            if(isset($value) && $value != '' && checkExtension($value)) {
                $_SESSION['articledata']['images'][] = $value;
            }
        }
    }


    if(isset($_GET['removeIndex'])) {
        unset($_SESSION['articledata']['images'][$_GET['removeIndex']]);
        unset($_GET['removeIndex']);
        header('Location: '.removeFromUrl('removeIndex'));
    }

    if(isset($_POST['update'])) {
        $_POST['images'] = $_SESSION['articledata']['images'];
        $updatedproduct = getProductdata($_POST);
        //update article method
        $updatedproduct['id_product'] = $_GET['articleid'];
        $db->updateProduct($updatedproduct);

        unset($_SESSION['articledata']);
        header('Location: ?pageid=article&articleid='.$_GET['articleid'].'&refresh=force');

    }else if(isset($_POST['create'])){
        $_POST['images'] = $_SESSION['articledata']['images'];
        $_POST['createdBy'] = isset($_SESSION['user']['id_user'])?$_SESSION['user']['id_user']:1;
        $newproduct = getProductdata($_POST);
        //create article method
        $newid = $db->createProduct($newproduct);
        unset($_SESSION['articledata']);
        header('Location: ?pageid=article&articleid='.$newid);

    }else if(isset($_POST['delete'])) {
        $db->removeProduct($_GET['articleid']);
        //remove article method
        unset($_SESSION['articledata']);
        header('Location: ?pageid=shop');
    } 

?>

<form class="text-left createArticleForm" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label for="producttitle">Product title
            <input class="form-control" id="producttitle" <?php if(isset($articledata['title'])){ echo 'value="'.$articledata['title'].'"'; } ?>  type="text" name="title" placeholder="Enter product title"/>
        </label>
    </div>
    <div class="form-group">
        <label for="productdescription_short">Product description_short
            <textarea class="form-control" id="productdescription_short" type="text" name="description_short" placeholder="Enter a short product summary"><?php if(isset($articledata)){ echo $articledata['description_short']; } ?></textarea>
        </label>
    </div>
    <div class="form-group">
        <label for="productdescription_long">Product description
            <textarea class="form-control" id="productdescription" type="text"  name="description_long" placeholder="Enter product description"><?php if(isset($articledata)){ echo $articledata['description_long']; } ?></textarea>
        </label>
    </div>
    <div class="form-group">
        <label for="productweight">Product weight
            <input class="form-control" id="productweight"  type="text" <?php if(isset($articledata['productweight'])){ echo 'value="'.$articledata['productweight'].'"'; } ?>  name="productweight" placeholder="Enter product weight"/>
        </label>
    </div>
    <div class="form-group">
        <label for="quantity">Quantity stored
            <input class="form-control" id="quantity"  type="text" <?php if(isset($articledata['quantity'])){ echo 'value="'.$articledata['quantity'].'"'; } ?>  name="quantity" placeholder="Enter stored quantity of product"/>
        </label>
    </div>
    <div class="form-group">
        <label for="unit">Unit
            <input class="form-control" id="unit"  type="text" <?php if(isset($articledata['unit'])){ echo 'value="'.$articledata['unit'].'"'; } ?> name="unit" placeholder="Enter unit to be displayed for product"/>
        </label>
    </div>
    <div class="form-group">
        <label for="unitprice">Price per unit
            <input class="form-control" id="unitprice"  type="text" <?php if(isset($articledata['unitprice'])){ echo 'value="'.$articledata['unitprice'].'"'; } ?> name="unitprice" placeholder="Enter price per unit"/>
        </label>
    </div>
    <div class="form-group">
        <?php 
        echo '<div class="row container py-3">';
        if(isset($articledata)){
            $images = $articledata['images']; 
            foreach($images as $key => $image):?>
            <div class="img-wrapper mr-2">
            <a href="<?php echo '?pageid='.$link.'&articleid='.$_GET['articleid'].'&removeIndex='.$key;?>" class="rmImg" name="removeIndex" id="rmimg<?php echo $key; ?>" value="<?php echo $key; ?>"><i class="fa fa-close"></i></a>
            <img src="<?php echo  UPLOAD_PATH.$image; ?>" class="cover"/>
            </div>
        <?php endforeach;} echo '</div>';?>
        <label for="productimages">Upload product images
            <small class="errorImg text-danger"><?php if(isset($status)){echo $status;}?></small>
            <input class="form-control" id="productimages" type="file" multiple accept=".jpg,.jpeg,.png" name="files[]"  placeholder="Choose product images"/>
        </label>
    </div>
    <button type="submit" name="<?php echo $mode; ?>" class="btn btn-primary"><?php echo $buttonText; ?></button>
    <?php if(isset($mode) && $mode == 'update'): ?><button type="submit" name="delete" class="btn btn-primary">Delete</button><?php endif;?>

</form>
