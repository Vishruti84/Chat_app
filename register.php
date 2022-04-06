<?php

    //include phpMailer library
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;           //Mail Transfer Protocol
    use PHPMailer\PHPMailer\Exception;

    // require '.\includes\Exception.php';
	// 		require '.\includes\PHPMailer.php';
	// 		require '.\includes\SMTP.php';

    //to use phpmailer library
    require 'vendor/autoload.php';
    // require 'PHPMailerAutoload.php';

$error = '';

$success_message = '';

if(isset($_POST["register"]))
{
    session_start();

    if(isset($_SESSION['user_data']))
    {
        header('location:chatroom.php');
    }

    require_once('./DB/ChatUser.php');

    $user_object = new ChatUser;

    $user_object->setUserName($_POST['user_name']);

    $user_object->setUserEmail($_POST['user_email']);

    $user_object->setUserPassword($_POST['user_password']);

    $user_object->setUserProfile($user_object->make_avatar(strtoupper($_POST['user_name'][0])));

    $user_object->setUserStatus('Disabled');

    $user_object->setUserCreatedOn(date('Y-m-d H:i:s'));

    $user_object->setUserVerificationCode(md5(uniqid()));

    $user_data = $user_object->get_user_data_by_email();

    if(is_array($user_data) && count($user_data) > 0)
    {
        $error = 'This Email Already Register';
    }
    else
    {
        if($user_object->save_data())
        {
            // //Server settings
            // $mail = new PHPMailer(true);
            // $mail->isSMTP();
            // $mail->SMTPDebug = 4;
            // $mail->Host = gethostbyname('smtp.gmail.com');           //'smtpout.secureserver.net';     to setup server
            //  $mail->SMTPAuth = true;
            // // $mail->SMTPAuth = false;
            //  $mail->SMTPAutoTLS = false;
            //  $mail->SMTPSecure = 'tls';  //PHPMailer::ENCRYPTION_STARTTLS
            //  $mail->Port = 587;
            //  $mail->Username = '81288@gmail.com';     //from where u want to send email
            // $mail->Password = '9913515884';                  
           
           

            // $mail->setFrom('81288vishu@gmail.com', 'ChatRoom');

            // //receiver email address
            // $mail->addAddress($user_object->getUserEmail());       //when user registers his mail that mail comes here
           
            //  $mail->isHTML(true);           //to set a format of mail

            // $mail->Subject = 'Registeration verification for ChatRoom';
            // $mail->Body = '
            //     <p> Thankyou for registering into ChatRoom.</p>
            //     <p>This is the verification email, please click below to verify your email address.</p>
                //  <p><a href="http://localhost:4040/Chat_app/verify.php?code='.$user_object->getUserVerificationCode().'">Click Here</a></p>
            //     <p>Thankyou....</p>  
            // ';//everytime new code is generated for new email

            // $mail->send();
            
            // <p><a href="./Chat_app/verify.php?code='.$user_object->getUserVerificationCode().'">Click Here</a></p>
            // $success_message = 'Registeration Successfull. Login To The ChatRoom';
            
            $success_message = 'Registeration Successfull.';
            // $success_message = 'Verification Email sent to ' . $user_object->getUserEmail();
        }
        else
        {
            $error = 'Something went wrong try again';
        }
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

    <title>Register</title>
    <link rel="icon" type="image/x-icon" href="chat.png">

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- <link href="vendor-front/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css"> -->

    <link rel="stylesheet" type="text/css" href="css/style.css"/>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" 
    integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" 
    integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</head>

<body>

<div class="container">
                <?php
                if($error != '')
                {
                    echo '
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                      '.$error.'
                   
                    </div>
                    ';
                }

                if($success_message != '')
                {
                    // echo '
                    // <div class="alert alert-success">
                    // '.$success_message.'
                    // </div>
                    // <script>alert("Registeration Successfull");</script>
                    // ';
                    echo '
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                      '.$success_message.'
                      <a href="index.php">Click To Login</a>
                    </div>
                    ';
                }
                ?>
        <div class="mycard">
            <div class="row">
                <div class="col-md-6">
                    <div class="left-lay">
                        <form  method="post" id="register_form">
                            <h1 class="left-h1 text-center mb-3">REGISTER</h1>
                            <div class="form-group mt-5">
                                <input type="text" class="form-control rounded-pill form-control-md" name="user_name" id="user_name" data-parsley-pattern="/^[a-zA-Z\s]+$/" required placeholder="Username">
                            </div>
                            <div class="form-group mt-4">
                                <input type="password" class="form-control rounded-pill form-control-md"  name="user_password" id="user_password" data-parsley-pattern="/^[a-zA-Z]+$" data-parsley-minlength="8" data-parsley-maxlength="12"  required placeholder="Password">
                            </div>
                            <div class="form-group mt-4">
                                <input type="email" class="form-control rounded-pill form-control-md" name="user_email" id="user_email"   data-parsley-type="email" placeholder="Email">
                            </div>
                           
                            <button type="submit" name="register" class="btn mt-5 btn-s rounded-pill btn-md">Register</button>
                        </form>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="right-lay">
                        <div class="box">
                        <h2 class="box-text mt-4">WELCOME TO CHATROOM</h2>
                        <p class="box-p text-justify mt-3 mb-4">Register in ChatRoom  and enjoy one to one chatting with your friends by inviting them into the chatroom.
                        </p>
                        <button class="btn btn-custom  rounder-pill btn-md">READ MORE</button>
                    </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</body>

</html>

<script>

$(document).ready(function(){

    $('#register_form').parsley();

});

</script>