
<?php
//validate
$check= false;
 if(isset($_POST['email']) && isset($_POST['password']) && isset($_POST['captcha'])) {
    //input
    $emailOrUsername = $_POST['email'];
    $password = $_POST['password'];
    $captcha = $_POST['captcha'];

    if (isset($_SESSION['captcha'])) {
        // Case sensitive Matching
        if ($captcha == $_SESSION['captcha']) {
            $check = true;
        }
        unset($_SESSION['captcha']);
        $check = true;
    }

    if($check) {
        //retrieve users 
        $users = $_SESSION['users'];
        foreach($users as $key => $user) {
            if($user['email'] == $emailOrUsername) {
                $userkey = $key;
                break;
            }
            if($user['username'] == $emailOrUsername) {
                $userkey = $key;
                break;
            }
        }

        if(isset($userkey)) {
            if(password_verify($password,$users[$userkey]['password'])) {
                //logged in set user
                $_SESSION['user'] = $users[$userkey]; 

                //redirects
                if(isset($_GET['ref']) && $_GET['ref'] == 'checkout'){
                    header('Location: ./?pageid=checkout');
                }else {
                    header('Location: ./?pageid=shop');
                }
            }else {
                $error = 'Pasword does not match user.';
            }
        }else {
            $error = 'There is no user for the input username or email.';
        }
    }
    else {
        $error = 'Captcha is incorrect.';
    }
 }

?>
<form class="text-left loginForm" action="" method="POST">
    <div class="form-group">
        <label for="emailInput">Email or username
            <input class="form-control" id="emailInput" required type="text" name="email" placeholder="Enter your email"/>
        </label>
        <?php if(isset($error)){ echo '<small class="text-danger">'.$error.'</small>'; }?>
    </div>
    <div class="form-group">
        <label for="passwordInput">Password
            <input  class="form-control" id="passwordInput" required type="password" name="password" placeholder="Enter your password"/>
        </label>
    </div>
    <div class="form-group">
        <label for="captcha">Captcha
            <input  class="form-control w-50" required type="text" name="captcha" id="captcha" placeholder="Enter string" />
            <img class="pt-2" src="./functions/captcha.php" alt="Captcha Image">
        </label>
    </div>
    <button type="submit" class="btn btn-primary w-100">Sign in</button>
    <a class="btn btn-outline-primary w-100 mt-3" href="./?pageid=register<?php if(isset($_GET['ref']) && $_GET['ref'] == 'checkout'){echo "&ref=checkout";}?>">
        Don't have an Account yet?<br/>
        <i class="fa fa-user-plus"></i><span class="text-wrap icon">Create account</span>
    </a>
</form>

