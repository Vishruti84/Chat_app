<?php

   session_start();
    if(isset($_POST["action"]) && $_POST["action"] == 'fetch_chat')
    {
        require 'DB/PrivateChat.php';
        $private_chat_object = new PrivateChat;
        $private_chat_object->setFromUserId($_POST['to_user_id']);
        $private_chat_object->setToUserId($_POST['from_user_id']);
        $private_chat_object->change_chat_status();

        echo json_encode($private_chat_object->get_all_chat_data());

    }

       

       
 

?>