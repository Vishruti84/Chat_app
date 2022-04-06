<?php

//private chat
session_start();
if(!isset($_SESSION['user_data']))
{
	header('location:index.php');
}
require('./DB/ChatUser.php');
require('./DB/ChatRooms.php');




?>
<!DOCTYPE html>
<html lang="en">
	<head>
    <title>Private ChatRoom</title>
	<link rel="icon" type="image/x-icon" href="chat.png">
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
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
                            $token = '';

                            foreach($_SESSION['user_data'] as $key => $value)
                            {
                                $login_user_id = $value['id'];
                                $token = $value['token'];

                            ?>
                            <input type="hidden" name="login_user_id" id="login_user_id" value="<?php echo $login_user_id; ?>" />
                            <input type="hidden" name="is_active_chat" id="is_active_chat" value="No" />
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
                            $user_object = new ChatUser;
                                $user_object->setUserId($login_user_id);
                                $user_data = $user_object->get_user_all_data_with_status_count();
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
                           <div class="list-group list-group" style="background:linear-gradient(75deg,#3498DB,#1136C7);max-height:100vh; margin-bottom:10px;-webkit-overflow-scrolling:touch;">
                                <?php
                               
                                foreach($user_data as $key => $user)
                                    {
                                        $icon = '<i class="fa fa-circle text-danger"></i>';

                                        if($user['user_login_status'] == 'Login')
                                        {
                                            $icon = '<i class="fa fa-circle text-success"></i>';
                                        }

                                        if($user['user_id'] != $login_user_id)
                                        {
                                            if($user['count_status'] > 0)
                                            {
                                                $total_unread_message = '<span class="badge badge-danger badge-pill">' .$user['count_status'].'</span>';
                                            }
                                            else{
                                                $total_unread_message = '';
                                            }
                                            echo " 
                                            <a class='list-group-item list-group-item-action select_user' style='cursor:pointer;background:linear-gradient(75deg,#3498DB,#1136C7);color:#fff;' data-userid = '".$user['user_id']."'>
                                                <img src = '".$user['user_profile']."' class='img-fluid rounded-circle' width='50' />
                                                <span class='ml-1'>
                                                <strong><span id='list_user_name_'" .$user["user_id"]. "'>" .$user['user_name']. "</span>
                                                <span id='userid_".$user['user_id']."'>".$total_unread_message."</span>
                                                </strong>
                                                </span>
                                               
                                                 <span class='mt-2 float-right' id='userstatus_".$user['user_id']."'>".$icon."</span>
                                            </a>
                                            ";
                                            // echo " 
                                            // <a class='list-group-item list-group-item-action select_user' style='cursor:pointer;background:linear-gradient(75deg,#3498DB,#1136C7);color:#fff;' data-userid = '".$user['user_id']."'>
                                            //     <img src = '".$user['user_profile']."' class='img-fluid rounded-circle' width='50' />
                                            //     <span class='ml-1'>
                                            //     <strong><span id='list_user_name_'" .$user["user_id"]. "'>" .$user['user_name']. "</span>
                                            //     <span id='userid_".$user['user_id']."'>".$total_unread_message."</span>
                                            //     </strong>
                                            //     </span>
                                               
                                            //      <span class='mt-2 float-right' id='userstatus_".$user['user_id']."'>".$icon."</span>
                                            // </a>
                                            // ";
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
                                        <a href="chatroom.php" class="btn btn-success btn-sm">Group Chat</a>
                                      
                                    </div>
                                    <!-- end card-header -->
                                    <!-- card body begin -->
                                    <div class="card-body" id="chat_area">
                                        <!-- <p>chatting area..........</p> -->
                                        <?php
                                            // foreach($chat_data as $chat)
                                            // {
                                            //     if(isset($_SESSION['user_data'][$chat['userid']]))
                                            //     {
                                            //         $from = 'Me';
                                            //         $row_class = 'row justify-content-end';
                                            //         $background_class = 'text-dark alert-light';
                                            //     }
                                            //     else
                                            //     {
                                            //         $from = $chat['user_name'];
                                            //         $row_class = 'row justify-content-start';
                                            //         $background_class = 'alert-success';
                                            //     }

                                            //     echo '
                                            //     <div class="'.$row_class.'">
                                            //         <div class="col-sm-10">
                                            //             <div class="shadow-sm alert '.$background_class.'">
                                            //                 <b>'.$from.'</b><br/>'.$chat["msg"].'
                                            //                 <br/>
                                            //                 <div class="text-right">
                                            //                     <small><i>'.$chat["created_on"].'</i></small>
                                            //                 </div>
                                            //             </div>
                                            //         </div>
                                            //     </div><br/>
                                            //     ';
                                            // }
                                            ?>
					                </div>
                                    <!-- end card-body -->
                                </div>
                                <!-- end card -->
                                <!-- Message input begin -->
                                <!-- <form method="post" id="chat_form" data-parsley-errors-container="#validation_error">
                                        <div class="input-group mb-3">
                                            <textarea class="form-control" id="chat_message" name="chat_message" placeholder="Type Message Here" data-parsley-maxlength="1000" data-parsley-pattern="/^[a-zA-Z0-9\s]+$/" required></textarea>
                                            <div class="input-group-append">
                                                <button type="submit" name="send" id="send" class="btn btn-primary"><i class="fa fa-paper-plane"></i></button>
                                            </div>
                                        </div>
                                        <div id="validation_error"></div>
                                 </form> -->
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
        var receiver_userid = '';

		var conn = new WebSocket('ws://localhost:8080?token=<?php echo $token; ?>  ');
		conn.onopen = function(e) {
		    console.log("Connection established!");
		};

		conn.onmessage = function(event)
		{
			var data = JSON.parse(event.data);

			if(data.status_type == 'Online')
			{
				$('#userstatus_'+data.user_id_status).html('<i class="fa fa-circle text-success"></i>');
			}
			else if(data.status_type == 'Offline')
			{
				$('#userstatus_'+data.user_id_status).html('<i class="fa fa-circle text-danger"></i>');
			}
			else
			{

				var row_class = '';
				var background_class = '';

				if(data.from == 'Me')
				{
					row_class = 'row justify-content-end';
					background_class = 'alert-light';
				}
				else
				{
					row_class = 'row justify-content-start';
					background_class = 'alert-success';
				}

				if(receiver_userid == data.userId || data.from == 'Me')
				{
					if($('#is_active_chat').val() == 'Yes')
					{
						var html_data = `
						<div class="`+row_class+`">
							<div class="col-sm-10">
								<div class="shadow-sm alert `+background_class+`">
									<b>`+data.from+` </b><br/>`+data.msg+`<br />
									<div class="text-right">
										<small><i>`+data.datetime+`</i></small>
									</div>
								</div>
							</div>
						</div><br />
						`;

						$('#messages_area').append(html_data);

						$('#messages_area').scrollTop($('#messages_area')[0].scrollHeight);

						$('#chat_message').val("");
					}
				}
                //if user is not online then display count of unread messages
				else
				{
					var count_chat = $('#userid'+data.userId).text();

					if(count_chat == '')
					{
						count_chat = 0;
					}

					count_chat++;

					$('#userid_'+data.userId).html('<span class="badge badge-danger badge-pill">'+count_chat+'</span>');
				}
			}
		};

		conn.onclose = function(event)
		{
			console.log('connection close');
		};

		function make_chat_area(user_name)
		{
			var html = `
			<div class="card">
				<div class="card-header">
					<div class="row">
						<div class="col col-sm-6">
							<b>Chat with <span class="text-danger" id="chat_user_name">`+user_name+`</span></b>
						</div>
						<div class="col col-sm-6 text-right">
							
							<button type="button" class="close" id="close_chat_area" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					</div>
				</div>
				<div class="card-body" id="messages_area">

				</div>
			</div>

			<form id="chat_form" method="POST" data-parsley-errors-container="#validation_error">
				<div class="input-group mb-3" style="height:7vh">
					<textarea class="form-control" id="chat_message" name="chat_message" placeholder="Type Message Here" data-parsley-maxlength="1000" data-parsley-pattern="/^[a-zA-Z0-9 ]+$/" required></textarea>
					<div class="input-group-append">
						<button type="submit" name="send" id="send" class="btn btn-primary"><i class="fa fa-paper-plane"></i></button>
					</div>
				</div>
				<div id="validation_error"></div>
				<br />
			</form>
			`;

			$('#chat_area').html(html);

			$('#chat_form').parsley();
		}

		$(document).on('click', '.select_user', function(){

			receiver_userid = $(this).data('userid');

			var from_user_id = $('#login_user_id').val();

			var receiver_user_name = $('#list_user_name_'+receiver_userid).text();

			$('.select_user.active').removeClass('active');

			$(this).addClass('active');

			make_chat_area(receiver_user_name);

			$('#is_active_chat').val('Yes');

			$.ajax({
				url:"action1.php",
				method:"POST",
				data:{action:'fetch_chat', to_user_id:receiver_userid, from_user_id:from_user_id},
				dataType:"JSON",
				success:function(data)
				{
					if(data.length > 0)
					{
						var html_data = '';

						for(var count = 0; count < data.length; count++)
						{
							var row_class= ''; 
							var background_class = '';
							var user_name = '';

							if(data[count].from_user_id == from_user_id)
							{
								row_class = 'row justify-content-end';

								background_class = 'alert-light';

								user_name = 'Me';
							}
							else
							{
								row_class = 'row justify-content-start';

								background_class = 'alert-success';

								user_name = data[count].from_user_name;
							}

							html_data += `
							<div class="`+row_class+`">
								<div class="col-sm-10">
									<div class="shadow alert `+background_class+`">
										<b>`+user_name+` - </b>
										`+data[count].chat_message+`<br />
										<div class="text-right">
											<small><i>`+data[count].timestamp+`</i></small>
										</div>
									</div>
								</div>
							</div><br/>
							`;
						}

						$('#userid_'+receiver_userid).html('');

						$('#messages_area').html(html_data);

						$('#messages_area').scrollTop($('#messages_area')[0].scrollHeight);
					}
				}
			})

		});

		$(document).on('click', '#close_chat_area', function(){

			$('#chat_area').html('');

			$('.select_user.active').removeClass('active');

			$('#is_active_chat').val('No');

			receiver_userid = '';

		});

		$(document).on('submit', '#chat_form', function(event){

			event.preventDefault();

			if($('#chat_form').parsley().isValid())
			{
				var user_id = parseInt($('#login_user_id').val());

				var message = $('#chat_message').val();

				var data = {
					userId: user_id,
					msg: message,
					receiver_userid:receiver_userid,
					command:'private'
				};

				conn.send(JSON.stringify(data));
			}

		});

	
		
		
		

	});
	
</script>
<script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js"></script>

</html>