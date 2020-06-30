<?php 
    if(isset($_POST['submit'])) {
        $credit = array(
            'owner' => null,
            'expiration' => null,
            'cardNumber' => null,
            'cvv' => null
        );

        if(validate_name($_POST['owner'])) {
            $credit['owner'] = $_POST['owner'];
        }else {
            $ownerError = 'Names must only contain alphabetic letters and backspace.';
        }

        if(validate_expiration($_POST['month'].'/'.$_POST['year'])) {
            $credit['expiration'] = $_POST['month'].'/'.$_POST['year'];
        }else {
            $expirationError = 'Month must be a numeric value from 1 to 12. Year must be numeric value.';
        }

        if(validate_cardNumber($_POST['number'])) {
            $credit['cardNumber'] = $_POST['number'];
        }else {
            $cardNumberError = 'Cardnumber does not match pattern.';
        }

        if(validate_cvv($_POST['cvv'])) {
            $credit['cvv'] = $_POST['cvv'];
        }else {
            $cvvError = 'CVV does not match pattern.';
        }

        $valid = true;

        foreach($credit as $item) {
            if($item == null) {
                $valid = false;
            }
        }

        if($valid) {
            //save order
            $cart = $_POST['cart'];
            $order = array();
            $order['user'] = $_SESSION['user'];
            $order['payment'] = $credit;
            $order['cart'] = $cart;
            $order['timestamp'] = time();

            //empty cart
            unset($_SESSION['cart']);
    
            $_SESSION['orders'][] = $order;

            header('Location: ?pageid=account');
        }



    }
?>
<form class="text-left" method="POST">
    <div class="form-group form-row">
        <div class="col-9">
            <label for="owner">Owner<br/>
                <?php if(isset($ownerError)){ echo '<small class="text-danger">'.$ownerError.'</small>'; }?>
                <input  class="form-control" id="owner" required type="text" name="owner" placeholder="Enter owner's name"/>
            </label>
        </div>
        <div class="col">
            <label for="cvv">CVV<br/>
                <?php if(isset($cvvError)){ echo '<small class="text-danger">'.$cvvError.'</small>'; }?>
                <input  class="form-control" id="cvv" required type="text" name="cvv" placeholder="Enter CVV"/>
            </label>
        </div>
    </div>
    <div class="form-group">
        <label for="cardNumber">Card Number<br/>
                <?php if(isset($cardNumberError)){ echo '<small class="text-danger">'.$cardNumberError.'</small>'; }?>
                <input  class="form-control" id="cardNumber" required type="text" name="number" placeholder="Enter card's number"/>
                <p>e.g. 5100000000000008</p>
        </label>
    </div>
    <label>Expiration Date<br/>
        <?php if(isset($expirationError)){ echo '<small class="text-danger">'.$expirationError.'</small>'; }?>
        <div class="form-group form-row">
            <div class="col-2">
                <select name="month" id="month" class="form-control p-0">
                    <option selected disabled>MM</option>
                    <option>01</option>
                    <option>02</option>
                    <option>03</option>
                    <option>04</option>
                    <option>05</option>
                    <option>06</option>
                    <option>07</option>
                    <option>08</option>
                    <option>09</option>
                    <option>10</option>
                    <option>11</option>
                    <option>12</option>
                </select>
            </div>
            <div class="col-2">
                <select name="year" id="year text-left" class="form-control p-0">
                    <option selected disabled>YY</option>
                    <option>20</option>
                    <option>21</option>
                    <option>22</option>
                    <option>23</option>
                    <option>24</option>
                    <option>25</option>
                    <option>26</option>
                </select>
            </div>
            <div class="col-7 offset-1">
                <img src="./img/creditcard.png" alt="Logos" class="w-100">
            </div>
        </div>
    </label>
    
    <button type="submit" name="submit" class="btn btn-primary w-100">Confirm</button>
</form>