<?php 
    if(isset($_POST['submit']))  {
        //Validate 
        $isValid = true;
        $postdata = array(
            'name' => (isset($_POST['name']))?$_POST['name']:NULL,
            'addressline1' => (isset($_POST['addressline1']))?$_POST['addressline1']:NULL,
            'addressline2' => (isset($_POST['addressline2']))?$_POST['addressline2']:NULL,
            'city' => (isset($_POST['city']))?$_POST['city']:NULL,
            'state' => (isset($_POST['state']))?$_POST['state']:NULL,
            'zipcode' => (isset($_POST['zipcode']))?$_POST['zipcode']:NULL,
            'country' => (isset($_POST['country']))?$_POST['country']:NULL, 
            'deliveryinstructions' => (isset($_POST['deliveryinstructions']))?$_POST['deliveryinstructions']:NULL, 
            'phone' => (isset($_POST['phone']))?$_POST['phone']:NULL,
        );

        if(validate_name($postdata['name'])) {
            $errorName = 'Please input a real name';
        }

        if($isValid) {
            //update user data
            foreach($postdata as $key => $item) {
                $_SESSION['user'][$key] = $item;
                $_SESSION['users'][array_keys($_SESSION['user'])[0]][$key] = $item;
            }

            unset($_GET['deliveryinfo']);

            header('Location: ?pageid=checkout',false);
        }
    }

    if(isset($_POST['deliveryInfo'])){
        $deliveryInfo = $_POST['deliveryInfo'];        
    }
?>
<form class="text-left deliveryForm w-100 d-flex flex-column mr-right" method="POST">
    <div class="form-group">
        <label for="nameInput">Name<br/>
            <?php if(isset($errorName)){ echo '<small class="text-danger">'.$errorName.'</small>'; }?>
            <input class="form-control" required id="nameInput" type="text" name="name" <?php if(isset($deliveryInfo)){ echo 'value="'.$deliveryInfo['name'].'"'; } ?> placeholder="Enter your full name"/>
        </label>
    </div>
    <div class="form-group">
        <label for="addressline1">Address line 1<br/>
            <?php if(isset($errorAddr1)){ echo '<small class="text-danger">'.$errorAddr1.'</small>'; }?>
            <input class="form-control" required id="addressline1" type="text" name="addressline1" <?php if(isset($deliveryInfo)){ echo 'value="'.$deliveryInfo['addressline1'].'"'; } ?> placeholder="Street address, P.O. box, company name, c/o"/>
        </label>
    </div>
    <div class="form-group">
        <label for="addressline2">Address line 2 (optional)<br/>
            <?php if(isset($errorAddr2)){ echo '<small class="text-danger">'.$errorAddr2.'</small>'; }?>
            <input class="form-control" id="addressline2" type="text" name="addressline2" <?php if(isset($deliveryInfo)){ echo 'value="'.$deliveryInfo['addressline2'].'"'; } ?> placeholder="Apartment, suite, unit, building, floor, etc. "/>
        </label>
    </div>
    <div class="form-group">
        <label for="city">City<br/>
            <?php if(isset($errorCity)){ echo '<small class="text-danger">'.$errorCity.'</small>'; }?>
            <input class="form-control" required id="city" type="text" name="city" <?php if(isset($deliveryInfo)){ echo 'value="'.$deliveryInfo['city'].'"'; } ?> placeholder=""/>
        </label>
    </div>
    <div class="form-group">
        <label for="state">State/Province/Region<br/>
            <?php if(isset($errorState)){ echo '<small class="text-danger">'.$errorState.'</small>'; }?>
            <input class="form-control" required id="state" type="text" name="state" <?php if(isset($deliveryInfo)){ echo 'value="'.$deliveryInfo['state'].'"'; } ?> placeholder=""/>
        </label>
    </div>
    <div class="form-group">
        <label for="zipcode">Zip<br/>
            <?php if(isset($errorZip)){ echo '<small class="text-danger">'.$errorZip.'</small>'; }?>
            <input class="form-control" required id="zipcode" type="text" name="zipcode" <?php if(isset($deliveryInfo)){ echo 'value="'.$deliveryInfo['zipcode'].'"'; } ?> placeholder=""/>
        </label>
    </div>
    <div class="form-group">
        <label for="country">Country/Region<br/>
            <?php if(isset($errorCountry)){ echo '<small class="text-danger">'.$errorCountry.'</small>'; }?>
            <input class="form-control" required id="country" type="text" name="country" <?php if(isset($deliveryInfo)){ echo 'value="'.$deliveryInfo['country'].'"'; } ?> placeholder=""/>
        </label>
    </div>
    <div class="form-group">
        <label for="phone">Phone (optional)<br/>
            <?php if(isset($errorCountry)){ echo '<small class="text-danger">'.$errorCountry.'</small>'; }?>
            <input class="form-control" id="phone" type="text" name="phone" <?php if(isset($deliveryInfo)){ echo 'value="'.$deliveryInfo['phone'].'"'; } ?> placeholder=""/>
        </label>
    </div>
    <div class="form-group">
        <label for="deliveryinstructions">Add delivery instructions (optional)<br/>
            <?php if(isset($errordeliveryInstructions)){ echo '<small class="text-danger">'.$errordeliveryInstructions.'</small>'; }?>
            <input class="form-control" id="deliveryinstructions" type="text" <?php if(isset($deliveryInfo)){ echo 'value="'.$deliveryInfo['deliveryinstructions'].'"'; } ?> name="deliveryinstructions" placeholder="Provide details such as building description, a nearby landmark, or other navigation instructions. Do we need a security code or a call box number to access this building? "/>
        </label>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary" name="submit">Save delivery information</button>
        <?php if(isset($_GET['deliveryinfo'])): ?><a class="btn btn-primary ml-2" href="?pageid=checkout">Cancel</a><?php endif;?>
    </div>
</form>
