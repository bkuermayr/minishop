<?php 
require_once('index.php');

/**
 * Validates usernames against a given pattern
 * @param input the username to validate
 */
function validate_username($input,$pattern = '/^[A-Za-z0-9\_\.]+$/')
{
	return preg_match($pattern,$input);
}

/**
 * Validates names against a given pattern
 * @param input the name to validate
 */
function validate_name($input,$pattern = '/^[A-Za-z\bZäöüÄÖÜ ]+$/') 
{
	return preg_match($pattern,$input);
} 

/**
 * Validates passwords against a given pattern
 * @param input the password to validate
 */
function validate_password($input,$pattern = '/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/') 
{
	return preg_match($pattern,$input);
} 

/**
 * Validates email-addresses against a given pattern
 * @param input the email-address to validate
 */
function validate_email($input,$pattern = '/^([\w\!\#$\%\&\'\*\+\-\/\=\?\^\`{\|\}\~]+\.)*[\w\!\#$\%\&\'\*\+\-\/\=\?\^\`{\|\}\~]+@((((([a-z0-9]{1}[a-z0-9\-]{0,62}[a-z0-9]{1})|[a-z])\.)+[a-z]{2,6})|(\d{1,3}\.){3}\d{1,3}(\:\d{1,5})?)+$/') 
{
	return preg_match($pattern,$input);
} 

/**
 * Validates card expiration date against a given pattern
 * @param input the expiration date to validate
 */
function validate_expiration($input,$pattern = '/^((0[1-9])|(1[0-2]))[\/]*(2[0-9])$/') 
{
	return preg_match($pattern,$input);
} 

/**
 * Validates card number against a given pattern
 * @param input the card number to validate
 */
function validate_cardNumber($input,$pattern = '/^(?:4[0-9]{12}(?:[0-9]{3})?|(?:5[1-5][0-9]{2}|222[1-9]|22[3-9][0-9]|2[3-6][0-9]{2}|27[01][0-9]|2720)[0-9]{12}|3[47][0-9]{13}|3(?:0[0-5]|[68][0-9])[0-9]{11}|6(?:011|5[0-9]{2})[0-9]{12}|(?:2131|1800|35\d{3})\d{11})$/') 
{
	return preg_match($pattern,$input);
} 

/**
 * Validates cvv against a given pattern
 * @param input the cvv number to validate
 */
function validate_cvv($input,$pattern = '/^[0-9]{3,4}$/') 
{
	return preg_match($pattern,$input);
} 




/**
 * Returns number of items in cart
 * @return int the amount of items in the session cart 
 */
function getCartAmount(){
	$cartcount = 0;
    if(isset($_SESSION['cart'])){
        $cartdata = $_SESSION['cart'];
        foreach($cartdata as $cartitem) {
            $cartcount = $cartcount + $cartitem['quantity'];
        }
    }

    return $cartcount;
    die();
}

/**
 * uploads images to a given path 
 * @param images the file array containing the images \$images = \$_FILES['inputName']
 * @param $targetDir the directory where the file should be uploaded
 * @return true if upload was successfull, else returns false
 */
function uploadImages($images,$targetDir=UPLOAD_PATH){
    $files = array();
        
    //file upload path
    foreach($images["name"] as $index => $value) {
        //maximum number of files
        if($index > 10) {
            break;
        }

        $fileName = basename($images["name"][$index]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

        if(!empty($images["name"])) {
            $allowTypes = array('jpg','png','jpeg');
            if(in_array($fileType, $allowTypes)){
                //upload file to server
                if(move_uploaded_file($images["tmp_name"][$index], $targetFilePath)){
                    $statusMsg = "The file ".$fileName. " has been uploaded.";
                }else{
                    $statusMsg = "Sorry, there was an error uploading your file.";
                }
            }else{
                $statusMsg = 'Sorry, only JPG, JPEG, PNG files are allowed to upload.';
            }
        }else{
            $statusMsg = 'Please select a file to upload.';
        }

        if(isset($statusMsg)){
            return false;
        }else {
            return true;
        }
    }

    //var_dump($files);

}

function checkExtension($filename) {
    $file = pathinfo($filename);
    $file['extension'];
    $allowTypes = Array('jpg','png');
    
    if(in_array($file['extension'], $allowTypes)){
        return 1;  
    }else{
        return 0;
    }
    
}

function isImage($files) {
    $check = getimagesize($files);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    }
    else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
    return $uploadOk;
}

function getProductdata($productdata) {    
    $product= array(
        "title" => $productdata['title'],
        "description_long" => $productdata['description_long'],
        "description_short" => $productdata['description_short'],
        "unitprice" => $productdata['unitprice'],
        "unit" => $productdata['unit'],
        "productweight" => $productdata['productweight'],
        "quantity" => $productdata['quantity'],
        "images" => $productdata['images'],    
    );

    if(isset($productdata['createdBy'])){
        $product["createdBy"] = $productdata['createdBy'];
    }
    return $product;
}


function getCurrentURL() {

    if(!isset($_SERVER['REQUEST_URI'])) {
        $_SERVER['REQUEST_URI'] = $_SERVER['SCRIPT_NAME'];
        if($_SERVER['QUERY_STRING']) {
            $_SERVER['REQUEST_URI'] .= '?' . $_SERVER['QUERY_STRING'];
        }
    }
    return $_SERVER['REQUEST_URI'];
}

function removeFromUrl($varname) {
    $url = getCurrentURL();
    list($urlpart, $qspart) = array_pad(explode('?', $url), 2, '');
    parse_str($qspart, $qsvars);
    unset($qsvars[$varname]);
    $newqs = http_build_query($qsvars);
    return $urlpart . '?' . $newqs;
}

function registeredMail($name,$username,$email) {
    $subject = " - Successfully registered your new account ".$name;
	$mailBody = "
    <!DOCTYPE html>
    <html>
        <body style='background: rgba(9, 92, 9, 0.685);font-family:Open Sans;'><link href='https://fonts.googleapis.com/css?family=Finger+Paint|Open+Sans' rel='stylesheet' type='text/css'>
            <div style='width:100%;height:100%;position:relative;'>
                <div style='padding: 3em;position:absolute;left:50%;top:50%;transform: translate(-50% ,50%) !important;'>
                    <h1 style='font-family: Montserrat; color: #fff;font-size:24px;text-align:center;'>Dear <span style='color:rgb(134, 32, 32);'>".$name."!</span><br/> Your account <span style='color:rgb(134, 32, 32);'>&quot;".$username."&quot;</span> was successfully registered.</h1>
                    <hr style='width: 20%;border:none;height: 4px;background:rgb(134, 32, 32);margin:0 auto;'>
                    <p style='color:#fff;font-size:16px;text-align:center;'>We wish you happy pasta shopping.</p>
                    <br><br><br>
                    <a style='text-align:center;color:#fff;position: absolute;width:200px;left:50%;transform:translateX(-50%);' href='https://shoppolini.com/' target='blank_'>
                        <img style='position: absolute;width:80px;left:50%;transform:translateX(-50%);' width='100%' height='auto' src='https://upload.wikimedia.org/wikipedia/commons/thumb/0/03/Flag_of_Italy.svg/1280px-Flag_of_Italy.svg.png' alt='Logo'/><br/>
                        <br><br>Shoppolini - Pasta shop
                    </a>
                </div>
            </div>
        </body>
    </html>";

    $mailHeaders = "From: Shoppolini - Pasta shop <noreply@shoppolini.com>\r\nMIME-Version: 1.0\r\nContent-Type: text/html; charset=UTF-8\r\n";
    $mail = @mail($email,"Your account was successfully registered!",$mailBody,$mailHeaders);        

    return $mail;
}

function orderMail($email) {
    $productdata = $_SESSION['cart'];
    $articles = $_SESSION['articles'];
    $delivery = '5';
    $subtotal = 0;

    $mailBody = "<body style='background: rgba(9, 92, 9, 0.685);font-family:Open Sans;'><link href='https://fonts.googleapis.com/css?family=Finger+Paint|Open+Sans' rel='stylesheet' type='text/css'>
    <div style='width:100%;height:100%;position:relative;'>
        <div style='padding: 3em;position:absolute;left:50%;top:50%;transform: translate(-50% ,-50%) !important;'>
            <h1 style='font-family: Montserrat; color: #fff;font-size:24px;text-align:center;'>Dear <span style='color:rgb(134, 32, 32);'>".$_SESSION['user']['name']."!</span><br/> Your order was successfully sent.</h1>
            <hr style='width: 20%;border:none;height: 4px;background:rgb(134, 32, 32);margin:0 auto;'>
            <div class='col-md-4' style='color: #fff;'>
                <h3 class='w-100 p-2 bg-primary text-light'>Order summary</h3> 
                <div class='container'>";

            foreach($productdata as $product) {
                $mailBody.="
                <div class='product-item row  p-2' style='display: flex; flex-flow: row; padding: 0.2rem; color: #fff;'>
                    <div class='img-wrapper' style='width: 50px; height: 50px; overflow:hidden; position: relative; padding-top: 0.4rem; margin-right: 0.5rem;'>
                        <img class='cover' style='    
                        position: absolute;
                        left:-10000%; right: -10000%; 
                        top: -10000%; bottom: -10000%;
                        margin: auto auto;
                        min-width: 1000%;
                        min-height: 1000%;
                        -webkit-transform:scale(0.1);
                        transform: scale(0.1);' src='".$articles[$product['articleid']]['images'][0]."' alt='product image' />
                    </div>
                    <div class='product-content'>
                        <small><b>".$articles[$product['articleid']]['title']."</b></small> <br/> 
                        <small>Unit price: ".$articles[$product['articleid']]['priceperunit']."</small> <br/>
                        <small>Quantity: ".$product['quantity']."</small> 
                    </div>
                </div>
                ";

                $subtotal = $subtotal +($product['quantity']*rtrim($articles[$product['articleid']]['priceperunit'],"€"));
            }


            $mailBody.="     
                        </div>
                        <hr/>
                        <p>Subtotal: ".$subtotal."€</p> 
                        <p>Delivery: ".$delivery."€</p>
                        <hr/>
                        <p><b>Total: ".($delivery+$subtotal)."€</b></p> <br/>
                    </div>
                    <p style='color:#fff;font-size:16px;text-align:center;'>Happy pasta shopping.</p>
                    <br><br><br>
                    <a style='text-align:center;color:#fff;position: relative;width:100%; display: block; margin: 0 auto;' href='https://shoppolini.com/' target='blank_'>
                        <img style='position: absolute;width:80px;left:50%;transform:translateX(-50%);' width='100%' height='auto' src='https://upload.wikimedia.org/wikipedia/commons/thumb/0/03/Flag_of_Italy.svg/1280px-Flag_of_Italy.svg.png' alt='Logo'/><br/>
                        <br><br>Shoppolini - Pasta shop
                    </a>
                </div>
            </div>
        </body>";

        $mailHeaders = "From: Shoppolini - Pasta shop <noreply@shoppolini.com>\r\nMIME-Version: 1.0\r\nContent-Type: text/html; charset=UTF-8\r\n";
        $mail = @mail($email,"Your order was successfully sent",$mailBody,$mailHeaders);        
        return $mail;
}

function displayWeight($weight) {
    if($weight >= 1000) {
        return ($weight/1000)."kg";
    }
    return $weight."g";
}







?>