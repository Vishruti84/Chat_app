<?php

    session_start();
    if(!isset($_SESSION['user_data']))
    {
	header('location:index.php');
    }

    require('DB/ChatUser.php');
    $user_object = new ChatUser;

    $user_id = '';
    foreach($_SESSION['user_data'] as $key => $value)
    {
        $user_id = $value['id'];
    }
    $user_object->setUserId($user_id);

    $user_data = $user_object->get_user_data_by_id();

    $message = '';

    if(isset($_POST['edit']))
    {
        $user_profile = $_POST['hidden_user_profile'];

        if($_FILES['user_profile']['name'] != '')
        {
            $user_profile = $user_object->upload_image($_FILES['user_profile']);

            $_SESSION['user_data'][$user_id]['profile'] = $user_profile;
        }
        $user_object->setUserName($_POST['user_name']);

        $user_object->setUserEmail($_POST['user_email']);

        $user_object->setUserPass($_POST['user_pass']);

        $user_object->setUserProfile($user_profile);

        $user_object->setUserId($user_id);

        if($user_object->update_data())
        {
            $message = ' <div class="alert alert-success alert-dismissible fade show" role="alert">Profile Updated Successfully</div>';
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link rel="icon" type="image/x-icon" href="chat.png">

    <link href="css/bootstrap.min.css" rel="stylesheet">

<!-- <link href="vendor-front/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css"> -->

    <link rel="stylesheet" type="text/css" href=""/>
</head>
<body>
<div class="containter">
        <br />
        <br />
        <h1 class="text-center"></h1>
        <br />
        <br />
        <?php echo $message; ?>
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">Profile</div>
                    <div class="col-md-6 text-right"><a href="chatroom.php">Back To ChatRoom</a></div>
                </div>
            </div>
            <div class="card-body">
                <form method="post" id="profile_form" enctype="multipart/form-data">
                <div class="form-group">
                    <label>UserName</label>
                <input type="text" name="user_name" id="user_name" class="form-control rounded-pill form-control-lg" 
                data-parsley-pattern="/^[a-zA-Z\s]+$/" required value="<?php echo $user_data['user_name'];?>"/>
            </div>
            <div class="form-group">
            <label>UserEmail</label>
                <input type="email" name="user_email" id="user_email" class="form-control rounded-pill form-control-lg" 
                data-parsley-type="email" required value="<?php echo $user_data['user_email'];?>"/>
            </div>
            <div class="form-group">
            <label>UserPassword</label>
                <input type="password" name="user_pass" id="user_pass" class="form-control rounded-pill form-control-lg"  required 
                data-parsley-pattern="/^[a-zA-Z]+$" value="<?php echo $user_data['user_pass'];?>"/>
            </div>
            <div class="form-group">
            <label>Profile</label>
                <input type="file" name="user_profile" id="user_profile"/>
                <img src="<?php echo $user_data['user_profile'];?>" class="img-fluid img-thumbnail mt-3" width="100" height="100"/>
                <input type="hidden" name="hidden_user_profile" value="<?php echo $user_data['user_profile'];?>"/>
            </div>
            <button type="submit" name="edit" id="" class="btn btn-custom btn-block mt-5 rounded-pill btn-lg">Edit Profile</button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>  
</body>
</html>