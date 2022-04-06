<?php

    // session_start();
    // if(isset($_POST['action']))
    // {
    //     require('DB/ChatUser.php');

    //     $user_object = new ChatUser;

    //     $user_object->setUserId($_POST['user_id']);

    //     $user_object->setUserLoginStatus('Logout');

    //     if($user_object->update_user_login_data())
    //     {
    //         unset($_SESSION['user_name']);
    //         unset($_SESSION['user_email']);
    //         unset($_SESSION['user_pass']);

    //         session_destroy();
    //         header('location:index.php');

            
    //     }

    // }
   

        session_start();
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_pass']);
        unset($_SESSION['user_profile']);
        unset($_SESSION['user_status']);
        unset($_SESSION['user_created_on']);
        unset($_SESSION['user_verification_code']);
        unset($_SESSION['user_login_status']);
        session_destroy();

        header('location:index.php');

       
 

?>