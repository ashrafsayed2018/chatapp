<?php 

require_once "include/connection.php";
if(!isset($_SESSION['email'])) {
    header('location:signin.php');
}
$username = $_SESSION['username'];
$email = $_SESSION['email'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>chat room </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container main-section">
    <div class="row">
        <!-- start left sidebar col  -->
        <div class="col-xs-12 col-md-3 left-sidebar">
            <div class="input-group-btn">
                <div class="input-group searchbox">
                    <center>
                        <a href="include/find_friends.php">
                            <button class="btn btn-default search-icon" name="search_user" type="submit"> اضافة مستخدم جديد </button>
                        </a> 
                    </center>
                </div>
            </div>
            <div class="left-chat">
                <ul>
                    <?php  require_once ('include/get_users_data.php ');?>
                </ul>
            </div>
        </div>
        <!-- end left sidebar col -->
        <!-- start room col  -->
        <div class="col-xs-12 col-sm-9 col-md-9">
            <!-- start first row  -->
            <div class="row">
                <!-- getting the user datat in whick the user click -->
                <?php 
                $total_message = '';
                 if(isset($_GET['user_name'])) {
                        $get_username = $_GET['user_name'];

                        // make sql to get the user data 

                        $sql = "SELECT * FROM users WHERE username = '$get_username'";
                        $run_user = mysqli_query($conn,$sql);
                        $result = mysqli_fetch_assoc($run_user);

                        $username = $result['username'];
                        $profile_image = $result['picture'];

                        if($profile_image == '') {
                            if($result['gender'] == 'male') {
                                $profile_image = "images/male.png";
                            } else {
                                $profile_image = "images/female.png";
                            }
                            
                        } else {
                            $profile_image = 'users_image/' . $profile_image;
                        }
                    

              
                 //(sender_username ='$username' and reciever_username = '$get_username' ) OR (reciever_username = '$username' AND sender_username = '$get_username')
                 $username = $_SESSION['username'];
                 
                 $messges_sql= "SELECT * FROM users_chat  WHERE (sender_username ='$username' AND reciever_username = '$get_username') OR (reciever_username = '$username' AND sender_username = '$get_username' ) ";
                 $run_messages = mysqli_query($conn,$messges_sql);
                 $total_message = mysqli_num_rows($run_messages);
                } else {

                    $sql = "SELECT * FROM users WHERE username = '$username'";
                    $run_user = mysqli_query($conn,$sql);
                    $result = mysqli_fetch_assoc($run_user);
                    $profile_image = $result['picture'];

                        if($profile_image == '') {
                            if($result['gender'] == 'male') {
                                $profile_image = "images/male.png";
                            } else {
                                $profile_image = "images/female.png";
                            }
                            
                        } else {
                            $profile_image = 'users_image/' . $profile_image;
                        }

                }
                ?>
                <!-- start right header  -->
                <div class="col-md-12 right-header">
                    <!-- start right header image  -->
                    <div class="right-header-img">
                        <?php 
                         if(!isset($get_username)) {
                            $picture  = $_SESSION['picture'];
                           echo "<img src='$profile_image' alt='' style='width=30px;height:30px'>";  
                         } else {
                          echo " <img src='$profile_image' alt='' style='width=30px;height:30px'>";
                         }
                        ?>
                       
                    </div>
                    <!-- end right header image  -->
                    <!-- start right header detail  -->
                    <div class="right-header-detail">
                        <form action="" method="post">
                            <p>
                                <?php 
                                if(!isset($get_username)) {
                                    echo "انت ";
                                } else {
                                    echo $get_username;
                                }
                               
                                 ?>
                          </p>
                            <span> رسائل   <?php echo $total_message ?>  </span>
                            <button name="logout" class="btn btn-danger">خروج</button>

                            <?php 
                            
                         if(isset($_POST['logout'])) {
                             $email = $_SESSION['email'];
                             $username = $_SESSION['username'];
                            $sql = "UPDATE users SET login_status = 'offline' WHERE username = '$username' AND email = '$email'";
                            $logout =  mysqli_query($conn,$sql);
                            session_unset();
                            session_destroy();
                            header("Location:signin.php");
                            exit();
                         }
                            ?>
                        </form>
                    </div>
                    <!-- end right header detail  -->
                </div>
                <!-- end right header  -->
            </div>
            <!-- end first row  -->
            <!-- start second row -->
            <div class="col-md-12 right-header-content-chat" id="scrolling_to_bottom">
                <?php 
                if(isset($_GET['user_name'])) {
                   $get_username = $_GET['user_name'];

                   $get_username = trim($get_username,' ');
            
                   $sql = "UPDATE users_chat SET msg_status = 'read'  WHERE (sender_username ='$username' OR  reciever_username = '$get_username')";
                   $update_msg = mysqli_query($conn,$sql);

                //    select the all msg between the two users 

                $sel_msg= "SELECT * FROM users_chat  WHERE (sender_username ='$username' AND reciever_username = '$get_username') OR (reciever_username = '$username' AND sender_username = '$get_username') ORDER BY msg_id  ASC ";
                $run_msg = mysqli_query($conn,$sel_msg);
                    if(mysqli_num_rows($run_msg) > 0) {
                    while($result = mysqli_fetch_assoc($run_msg)) {
                        $sender_username = $result['sender_username'];
                        $reciever_username = $result['reciever_username'];
                        $msg_content =  $result['msg_content'];
                        $msg_date   = $result['msg_date']; ?>

                        <ul>
                            <?php 
                             if($username == $sender_username && $get_username == $reciever_username) {
                                 echo "
                                 <li> 
                                 <div class='rightside-chat'>
                                 <span>$username<small>$msg_date</small></span>
                                 <p class='msg-content'>$msg_content</p>
                                </div>
                                  </li>
                                 ";
                             }
                             if($username == $reciever_username && $get_username == $sender_username) {
                                echo "
                                <li> 
                                <div class='leftside-chat'>
                                <span>$get_username<small>$msg_date</small></span>
                                <p class='msg-content'>$msg_content</p>
                               </div>
                                 </li>
                                ";
                            }
                            ?> 
                        </ul>
                       
                    <?php }
                    } else {
                        echo " <div class='alert alert-danger text-right no-chat-msg'><strong>$get_username</strong> لا توجد محادثات حتي الان  بينك وبين </div>";
                    }
                    }
                ?>
            </div>
            <!-- end second row  -->
            <!-- start third row -->
            <div class="row">
                <div class="col-md-12 right-chat-textbox">
                    <form action="" method="post">
                        <input type="text" name="msg-content" class="form-control" autocomplete="off" placehoder="write you message"
                        <?php
                        if(isset($_GET['user_name']) && $_GET['user_name'] == $_SESSION['username'])  {
                            echo "disabled ";
                        } else if(!isset($_GET['user_name'])) {
                            echo "disabled ";
                        }
                        ?>> 
                        <button class="btn" name="send_msg" id="send_msg"><i class="fa fa-telegram"></i></button>
                    </form>
                </div>
            </div>
            <!-- end third row -->
        </div>
    </div>
</div>
<?php 
if(isset($_POST['send_msg'])) {
   
    $msg_content = htmlentities(mysqli_real_escape_string($conn,$_POST['msg-content']));
    echo $msg_content;
    if(empty($msg_content)) {
        echo "<div class='alert alert-danger empty-msg'>نص الرساله فارغ</div>";
    } else if(strlen($msg_content) > 100) {
        echo "<div class='alert alert-danger big-msg'>نص الرساله يجب ان يكون اقل من 100 حرف </div>";   
    } else {
        $insert = "INSERT INTO users_chat (sender_username,reciever_username,msg_content,msg_status,msg_date)";
        $insert .= " VALUES ('$username','$get_username','$msg_content','unread','now()')";
        $run_insert = mysqli_query($conn,$insert);
        $sql = "UPDATE users SET login_status = 'online'  WHERE username ='$username'";
        $update_status = mysqli_query($conn,$sql);
        echo "<meta http-equiv='refresh' content='0'>";
    }
    
}
?>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
    <script>
      $('#scrolling_to_bottom').animate({
          scrollTop: $('#scrolling_to_bottom').get(0).scrollHeight
      },1000);
      $('.right-chat-textbox input').focus();ئ
    </script>
</body>
</html>