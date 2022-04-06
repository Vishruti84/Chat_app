<?php
    session_start();
    if(!isset($_SESSION['user_data']))
{
	header('location:index.php');
}

    require('DB/ChatUser.php');

    require('DB/ChatRooms.php');

    $chat_object = new ChatRooms;

     $chat_data = $chat_object->get_all_chat_data();

    $user_object = new ChatUser; 

     $user_data = $user_object->get_user_all_data();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
    <title>CHATROOM</title>
	<link rel="icon" type="image/x-icon" href="chat.png">
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="Admin template that can be used to build dashboards for CRM, CMS, etc." />
    <meta name="author" content="Potenza Global Solutions" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <!-- plugin stylesheets -->
    <link rel="stylesheet" type="text/css" href="assets/css/vendors.css" />
    <!-- app style -->
    <link rel="stylesheet" type="text/css" href="assets/css/style.css" />
     <!-- plugins -->
    <script src="assets/js/vendors.js"></script>

    <!-- custom app -->
    <script src="assets/js/app.js"></script>
    <script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js"></script>
    <style type="text/css">
		
		#messages {
			height: 200px;
			background: whitesmoke;
			overflow: auto;
		}
		
		#messages_area
		{
			height: 650px;
			overflow-y: auto;
			background-color:#e6e6e6;
		}

	</style>
	</head>

<body>
    <!-- begin app -->
    <div class="app">
        <!-- begin app-wrap -->
        <div class="app-wrap">
            <!-- begin app-header -->
            <header class="app-header top-bar">
                <!-- begin navbar -->
                <nav class="navbar navbar-expand-md">

                    <!-- begin navbar-header -->
                    <div class="navbar-header d-flex align-items-center" style="background:linear-gradient(85deg,#3498DB,#1136C7);">
                        <a href="javascript:void:(0)" class="mobile-toggle"><i class="ti ti-align-right"></i></a>
                        <a class="navbar-brand navbar-light" >
                           <!-- <h3 class="text-white">CHATROOM</h3> -->
						   <!-- <img src="chat.png" style="height:50px;width:50px;"/> -->
                        </a>
                    </div>
                   
                    <!-- end navbar-header -->
                    <!-- begin navigation -->
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <div class="navigation d-flex">
                            <ul class="navbar-nav nav-left">
                           
                                <li class="nav-item full-screen d-none d-lg-block" id="btnFullscreen">
                                    <a href="javascript:void(0)" class="nav-link expand">
                                        <i class="icon-size-fullscreen"></i>
                                    </a>
                                </li>
                            </ul>
                            <ul class="navbar-nav nav-right ml-auto">
                            <?php

                            $login_user_id = '';

                            foreach($_SESSION['user_data'] as $key => $value)
                            {
                                $login_user_id = $value['id'];

                            ?>
                            <input type="hidden" name="login_user_id" id="login_user_id" value="<?php echo $login_user_id; ?>" />
                               
                                <li class="nav-item dropdown user-profile">
                                    <a href="javascript:void(0)" class="nav-link dropdown-toggle " id="navbarDropdown4" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <img src="<?php echo $value['profile']; ?>" alt="avtar-img">
                                        <span class="bg-success user-status"></span>
                                    </a>
                                    <div class="dropdown-menu animated fadeIn" aria-labelledby="navbarDropdown">
                                        <div class="bg-gradient px-4 py-3">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="mr-1">
                                                    <h4 class="text-white mb-0"><?php echo $value['name']; ?></h4>
                                                    <small class="text-white"></small>
                                                </div>
                                                <a href="action.php" class="text-white font-20 tooltip-wrapper" data-toggle="tooltip" data-placement="top" title="" data-original-title="Logout"> <i
                                                                class="zmdi zmdi-power"></i></a>
                                            </div>
                                        </div>
                                        <div class="p-4">
                                            <a class="dropdown-item d-flex nav-link" href="profile.php">
                                                <i class="fa fa-user pr-2 text-success"></i>Edit Profile</a>
                                                <div class="row mt-2">
                                               
                                                </div>
                                        </div>
                                    </div>
                                </li>
                            </ul><?php
							}
							?>
                        </div>
                    </div>
                    <!-- end navigation -->
                </nav>
                <!-- end navbar -->
                
            </header>
            <!-- end app-header -->
            <!-- begin app-container -->
            <div class="app-container">
                <!-- begin app-nabar -->
                <aside class="app-navbar">
                    <!-- begin sidebar-nav -->
                    <div class="sidebar-nav scrollbar scroll_light" style="background:linear-gradient(75deg,#3498DB,#1136C7);color:#fff;">
                        <ul class="metismenu " id="sidebarNav">
                           <li class="nav-static-title" style="color:#fff;">Online Users</li>  
                           <div class="list-group list-group-flush" style="background:linear-gradient(75deg,#3498DB,#1136C7);">
                                <?php
                                if(count($user_data) > 0)
                                {
                                    foreach($user_data as $key => $user)
                                    {
                                        $icon = '<i class="fa fa-circle text-danger"></i>';

                                        if($user['user_login_status'] == 'Login')
                                        {
                                            $icon = '<i class="fa fa-circle text-success"></i>';
                                        }

                                        if($user['user_id'] != $login_user_id)
                                        {
                                            echo ' 
                                            <a class="list-group-item list-group-item-action" style="background:linear-gradient(75deg,#3498DB,#1136C7);color:#fff;"">
                                                <img src="'.$user["user_profile"].'" class="img-fluid rounded-circle " width="50" />
                                                <span class="ml-1"><strong>'.$user["user_name"].'</strong></span>
                                                <span class="mt-2 float-right">'.$icon.'</span>
                                            </a>
                                            ';
                                        }

                                    }
                                }
                                ?>
						    </div>
                        </ul>
                      
					    <!-- <div class="card-body" id="user_list" style="background:linear-gradient(75deg,#3498DB,#1136C7);"> -->
						   
					    <!-- </div> -->
				
                    </div>
                    <!-- end sidebar-nav -->
                </aside>
                <!-- end app-navbar -->
                <!-- begin app-main -->
                <div class="app-main" id="main">
                    <!-- begin container-fluid -->
                    <div class="container-fluid">
                       
                        <!-- begin row -->
                        <div class="row">
                            <div class="col-xxl-12 m-b-30">
                                <div class="card card-statistics h-100 mb-0 apexchart-tool-force-top">
                                    <div class="card-header d-flex justify-content-between">
                                        <div class="card-heading">
                                            <h4 class="card-title">Chat Room</h4>
                                     
                                        </div>
                                        <a href="privatechat.php"  class="btn btn-success btn-sm">Private Chat</a>
                                    </div>
                                    <!-- end card-header -->
                                    <!-- card body begin -->
                                    <div class="card-body" id="messages_area">
                                        <!-- <p>chatting area..........</p> -->
                                        <?php
                                            foreach($chat_data as $chat)
                                            {
                                                if(isset($_SESSION['user_data'][$chat['userid']]))
                                                {
                                                    $from = 'Me';
                                                    $row_class = 'row justify-content-end';
                                                    $background_class = 'text-dark alert-light';
                                                }
                                                else
                                                {
                                                    $from = $chat['user_name'];
                                                    $row_class = 'row justify-content-start';
                                                    $background_class = 'alert-success';
                                                }

                                                echo '
                                                <div class="'.$row_class.'">
                                                    <div class="col-sm-10">
                                                        <div class="shadow-sm alert '.$background_class.'">
                                                            <b>'.$from.'</b><br/>'.$chat["msg"].'
                                                            <br/>
                                                            <div class="text-right">
                                                                <small><i>'.$chat["created_on"].'</i></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><br/>
                                                ';
                                            }
                                            ?>
					                </div>
                                    <!-- end card-body -->
                                </div>
                                <!-- end card -->
                                <!-- Message input begin -->
                                <form method="post" id="chat_form" data-parsley-errors-container="#validation_error">
                                        <div class="input-group mb-3">
                                            <textarea class="form-control" id="chat_message" name="chat_message" placeholder="Type Message Here" data-parsley-maxlength="1000" data-parsley-pattern="/^[a-zA-Z0-9\s]+$/" required></textarea>
                                            <div class="input-group-append">
                                                <button type="submit" name="send" id="send" class="btn btn-primary"><i class="fa fa-paper-plane"></i></button>
                                            </div>
                                        </div>
                                        <div id="validation_error"></div>
                                 </form>
                                <!-- end message input -->
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row --> 
                    </div>
                    <!-- end container-fluid -->
                </div>
                <!-- end app-main -->
            </div>
            <!-- end app-container -->
        </div>
        <!-- end app-wrap -->
    </div>
    <!-- end app -->

    <!-- plugins -->
    <!-- <script src="assets/js/vendors.js"></script> -->

    <!-- custom app -->
    <!-- <script src="assets/js/app.js"></script> -->
    
	
</body>
<script>
	
	$(document).ready(function(){

		var conn = new WebSocket('ws://localhost:8080');
		conn.onopen = function(e) {
		    console.log("Connection established!");
		};

		conn.onmessage = function(e) {
		    console.log(e.data);

		    var data = JSON.parse(e.data);

		    var row_class = '';

		    var background_class = '';

		    if(data.from == 'Me')
		    {
		    	row_class = 'row justify-content-end';
		    	background_class = 'text-dark alert-light';
		    }
		    else
		    {
		    	row_class = 'row justify-content-start';
		    	background_class = 'alert-success';
		    }

		    var html_data = "<div class='"+row_class+"'><div class='col-sm-10'><div class='shadow-sm alert "+background_class+"'><b>"+data.from+" </b><br/>"+data.msg+"<br /><div class='text-right'><small><i>"+data.dt+"</i></small></div></div></div></div><br/>";

		    $('#messages_area').append(html_data);

		    $("#chat_message").val("");
		};

		$('#chat_form').parsley();

		$('#messages_area').scrollTop($('#messages_area')[0].scrollHeight);

		$('#chat_form').on('submit', function(event){

			event.preventDefault();

			if($('#chat_form').parsley().isValid())
			{

				var user_id = $('#login_user_id').val();

				var message = $('#chat_message').val();

				var data = {
					userId : user_id,
					msg : message
				};

				conn.send(JSON.stringify(data));

				$('#messages_area').scrollTop($('#messages_area')[0].scrollHeight);

			}

		});
		
		
		

	});
	
</script>

</html>