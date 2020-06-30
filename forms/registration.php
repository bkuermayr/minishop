
<?php 
$newuser = null;
$check= false;
    if(isset($_POST['register'])) {
        $users = $_SESSION['users'];
        $captcha = $_POST['captcha'];

        if (isset($_SESSION['captcha'])) {
            // Case sensitive Matching
            if ($captcha == $_SESSION['captcha']) {
                $check = true;
            }
            unset($_SESSION['captcha']);
        }

        if($check) {
            //validate on submit 
            if(isset($_POST['newsletter']) && $_POST['newsletter'] == 'true') {
                $newsletter = true;
            }else {
                $newsletter = false;
            }

            if(isset($_POST['gender'])) {
                if($_POST['gender'] == 'male' || $_POST['gender'] == 'female' || $_POST['gender'] == 'other') {
                    $gender = $_POST['gender'];
                }else {
                    $gender = null;
                    $errorBirthdate = 'Please select gender';
                }
            }

            if(isset($_POST['birthday'])) {            
                $age = floor((time() - strtotime($_POST['birthday'])) / 31556926);
                if($age >= 16) {
                    $birthdate = $_POST['birthday'];
                }else {
                    $birthdate = null;
                    $errorBirthdate = 'You must be at least 16 years old to register';
                }
            }

            if(isset($_POST['username'])) {
                $username = $_POST['username'];

                if (!validate_username($username)){
                    $username = null;
                    $errorUserName = 'Username must only contain letters and numbers.';
                }

                foreach($users as $userid => $user) {
                    if($user['username'] == $_POST['username']) {
                        $username = null;
                        $errorUserName = 'Username already taken.';
                    }
                }
            }

            if(isset($_POST['name'])) {
                $name = $_POST['name'];
                if(!validate_name($_POST['name'])){ 
                    $name = null;
                    $errorName = 'Name must only contain letters and backspace.';
                }
            }

            
            if(isset($_POST['email'])) {
                $email = $_POST['email'];
                if(!validate_email($_POST['email'])){ 
                    $email = null;
                    $errorEmail = 'Email-Address is invalid. Please correct typos or use alternative Email.';
                }

                foreach($users as $userid => $user) {
                    if($user['email'] == $_POST['email']) {
                        $eamil = null;
                        $errorEmail = 'Another account with this Email-Address already exists.';
                    }
                }
            }

            if(isset($_POST['password'])) {            
                if(validate_password($_POST['password'])) {
                    $password = $_POST['password'];
                    $options = array(
                        'cost' => 12,
                    );
                    $password_hash = password_hash($password, PASSWORD_DEFAULT, $options);
                }else {
                    $password_hash = null;
                    $errorPasswd = 'Password must contain uppercase and lowercase letters, aswell as numbers.<br/> A minimum length of 8 characters is required';
                }
            }

            $newuser = array(
                'username' => $username,
                'email' => $email,
                'name' => $name,
                'gender' => $gender,
                'birthdate' => $birthdate,
                'newsletter' => $newsletter,
                'password' => $password_hash,
                'role' => 'user',
            );

            foreach($newuser as $key => $userdata) {
                if(!isset($userdata)) {
                    $invaliduser = true;
                    echo $key;
                }
            }


            if(!isset($invaliduser)) {
                //add user to db
                $_SESSION['users'][] = $newuser;

                //save auth user in session
                $_SESSION['user'] = $newuser;

                //send email
                $name = $_SESSION['user']['name'];
                $email = $_SESSION['user']['email'];
                $username = $_SESSION['user']['username'];
                registeredMail($name,$username,$email);

                header('Location: ?pageid=shop');
            }
        }
        else {
            $errorCaptcha = 'Captcha is incorrect.';
        }
    }
?>
<form class="text-left registrationForm" method="POST">
    <div class="form-group">
        <label for="nameInput">Name<br/>
            <?php if(isset($errorName)){ echo '<small class="text-danger">'.$errorName.'</small>'; }?>
            <input class="form-control" required id="nameInput" <?php echo 'value="'.$newuser['name'].'"';?> type="text" name="name" placeholder="Enter your full name"/>
        </label>
    </div>
    <div class="form-group">
        <label for="userInput">Username<br/>
            <?php if(isset($errorUserName)){ echo '<small class="text-danger">'.$errorUserName.'</small>'; }?>
            <input class="form-control" required id="userInput" <?php echo 'value="'.$newuser['username'].'"';?> type="text" name="username" placeholder="Enter your username"/>
        </label>
    </div>
    <div class="form-group">
        <label>Gender<br/>
        <?php if(isset($errorGender)){ echo '<small class="text-danger">'.$errorGender.'</small>'; }?>
        </label>
        <label class="d-flex">
            <input class="form-control mr-1" required type="radio" name="gender" <?php  if($newuser['gender'] == 'male'){ echo 'checked'; }?> value="male"/>
            Male
        </label>
        <label class="d-flex">
            <input class="form-control mr-1" required  type="radio" <?php  if($newuser['gender'] == 'female'){ echo 'checked'; }?> name="gender" value="female"/>
            Female
        </label>
        <label class="d-flex">
            <input class="form-control mr-1" required  <?php if($newuser['gender'] == 'other'){ echo 'checked'; }?> type="radio" name="gender" value="other"/>
            Other
        </label>
    </div>
    <div class="form-group">
        <label for="birthdayInput">Birthday:<br/>
        <?php if(isset($errorBirthdate)){ echo '<small class="text-danger">'.$errorBirthdate.'</small>'; }?>
        <input type="date" <?php echo 'value="'.$newuser['birthdate'].'"';?>  id="birthdayInput" required name="birthday">
        </label>


    </div>
    <div class="form-group">
        <label for="emailInput">Email<br/>
            <?php if(isset($errorEmail)){ echo '<small class="text-danger">'.$errorEmail.'</small>'; }?>
            <input class="form-control" id="emailInput" required type="text" <?php echo 'value="'.$newuser['email'].'"';?> name="email" placeholder="Enter your email"/>
        </label>
    </div>
    <div class="form-group">
        <label for="passwordInput">Password<br/>
            <?php if(isset($errorPasswd)){ echo '<small class="text-danger">'.$errorPasswd.'</small>'; }?>
            <input  class="form-control" id="passwordInput" required  type="password" name="password" placeholder="Enter your password"/>
        </label>
    </div>
    <div class="form-group">
        <label for="captcha">Captcha
            <?php if(isset($errorCaptcha)){ echo '<small class="text-danger">'.$errorCaptcha.'</small>'; }?>
            <input  class="form-control w-50" required type="text" name="captcha" id="captcha" placeholder="Enter string" />
            <img class="pt-2" src="./functions/captcha.php" alt="Captcha Image">
        </label>
    </div>
    <div class="form-group">
        <label for="newsletter">
        <input class="form-control" id="newsletter" type="checkbox" <?php if($newuser['newsletter'] == true) {echo 'checked';}?>  name="newsletter" value="true"/>    
        Sign me up to the Newsletter
        </label>
    </div>    
    <button type="submit" class="btn btn-primary w-100" name="register" value="register">Create account</button>
    <a class="btn btn-outline-primary w-100 mt-3" href="./?pageid=login<?php if(isset($_GET['ref']) && $_GET['ref'] == 'checkout'){echo "&ref=checkout";}?>">
        Already have an Account?<br/>
        <i class="fa fa-sign-in"></i><span class="text-wrap icon">Sign in</span>
    </a>
</form>
