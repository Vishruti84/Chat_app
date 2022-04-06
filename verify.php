<?php

$error = '';
session_start();
//  if(isset($_GET['email']))
//  {
    require_once('DB/ChatUser.php');
    $user_object = new ChatUser;

        //set unique code for new user
    //  $user_object->setUserEmail($_GET['email']);

    // if($user_object->is_valid_email_verification_code())
    // {
        $user_object->setUserStatus('Enable');
        

        if($user_object->enable_user_account())
        {
            $_SESSION['success_message'] = ' Email Verification Successfull, Login To The ChatRoom.';

            header('location:index.php');
        }
        else{
            $error = 'Something went wrong !!!! Try Again.';
        }
    // }
    // else
    // {
    //     $error = 'Something went wrong !!!! Try Again.';
    // }
//  }


?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Email Verification</title>
    <link rel="icon" type="image/x-icon" href="chat.png">

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap core JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</head>

<body>

    <div class="containter">
        <br />
        <br />
        <h1 class="text-center">Verify</h1>
        
        <div class="row justify-content-md-center">
            <div class="col col-md-4 mt-5">
            	<div class="alert alert-danger">
            		<h2><?php echo $error; ?></h2>
            	</div>
            </div>
        </div>
    </div>
</body>

</html>