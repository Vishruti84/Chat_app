<?php

session_start();

$error = '';

// if(isset($_SESSION['user_data']))
// {
//     header('location:DB/ChatRoom.php');
// }

if(isset($_POST['login']))
{
    require_once('DB/ChatUser.php');

    $user_object = new ChatUser;

    $user_object->setUserEmail($_POST['user_email']);

    $user_data = $user_object->get_user_data_by_email();


     $user_object->setUserStatus('Enable');
    if(is_array($user_data) && count($user_data) > 0)
    {
        //  $user_data = $user_object->enable_user_account();
    
        if($user_object->enable_user_account())
        {
            if($user_data['user_password'] == $_POST['user_password'])
            {
                $user_object->setUserId($user_data['user_id']);
                $user_object->setUserLoginStatus('Login');

                $user_token = md5(uniqid());
                $user_object->setUserToken($user_token);

                if($user_object->update_user_login_data());
                {
                    $_SESSION['user_data'][$user_data['user_id']] = [
                        'id'    =>  $user_data['user_id'],
                        'name'  =>  $user_data['user_name'],
                        'profile'   =>  $user_data['user_profile'],
                        'token' => $user_token
                       
                    ];

                    header('location:chatroom.php');

                }
            }
            else
            {
                $error = 'Wrong Password';
            }
        }
        else
        {
            $error = 'Please Verify Your Email Address';
        }
    }
    else
    {
        $error = 'Verify Your Email Address';
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login</title>
    <link rel="icon" type="image/x-icon" href="chat.png">

    <!-- Bootstrap core CSS -->
    <!-- <link href="vendor-front/bootstrap/bootstrap.min.css" rel="stylesheet"> -->

    <!-- <link href="vendor-front/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css"> -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="css/style1.css"/>


    <!-- Bootstrap core JavaScript -->
    <!-- <script src="vendor-front/jquery/jquery.min.js"></script>
    <script src="vendor-front/bootstrap/js/bootstrap.bundle.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" 
    integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" 
    integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

    <!-- Core plugin JavaScript-->
    <!-- <script src="vendor-front/jquery-easing/jquery.easing.min.js"></script>

    <script type="text/javascript" src="vendor-front/parsley/dist/parsley.min.js"></script> -->
</head>

<body>
               
                <!-- //login -->
                <div class="login-container d-flex align-items-center justify-content-center">
                
        <form  class="login-form text-center" method="post" id="login_form">
        <?php
               if(isset($_SESSION['success_message']))
               {
                    echo '
                    <div class="alert alert-success">
                    '.$_SESSION["success_message"] .'
                    </div>
                    ';
                    unset($_SESSION['success_message']);
               } 

               if($error != '')
               {
                    echo '
                    <div class="alert alert-danger">
                    '.$error.'
                    </div>
                    ';
               }
               ?> 
            <h1 class="text-center mb-5">SIGN IN</h1>
            <div class="form-group">
                <input type="email" name="user_email" id="user_email" class="form-control rounded-pill form-control-lg" data-parsley-type="email" required placeholder="Email">
            </div>
            <div class="form-group">
                <input type="password" name="user_password" id="user_password" class="form-control rounded-pill form-control-lg"  required placeholder="Password">
            </div>
            <!-- <div class="forgot-link d-flex align-items-center justify-content-between">
                <div class="form-check">
                    <input type="checkbox" name="" class="form-check-input" id="remember">
                    <label for="remember">Remember Password</label>
                </div>
                <a href="#">Forgot Password?</a>
            </div> -->
            <button type="submit" name="login" id="login" class="btn btn-custom btn-block mt-5 rounded-pill btn-lg">SignIn</button>
            <hr>
            <a href="register.php">New to this ChatRoom ? Register Now.</a>
        </form>
    </div>
</body>

</html>

<script>

$(document).ready(function(){
    
    $('#login_form').parsley();
    
});

</script>
