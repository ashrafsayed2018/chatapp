<?php 

require_once "include/connection.php";
if(!isset($_SESSION['email'])) {
    header('location:signin.php');
}
$username = $_SESSION['username'];
$email = $_SESSION['email'];



if(isset($_GET['user_name'])) {
    $output = '';
    $get_username = $_GET['user_name'];


    $get_username = trim($get_username,' ');

    $sql = "UPDATE users_chat SET msg_status = 'read'  WHERE (sender_username ='$username' OR  reciever_username = '$get_username')";
    $update_msg = mysqli_query($conn,$sql);

 //    select the all msg between the two users 

 $sel_msg = "SELECT * FROM users_chat  WHERE (sender_username ='$username' AND reciever_username = '$get_username') OR (reciever_username = '$username' AND sender_username = '$get_username') ORDER BY msg_id  ASC ";
 $run_msg = mysqli_query($conn,$sel_msg);

 $rows = mysqli_num_rows($run_msg);

 if(mysqli_num_rows($run_msg) > 0) {
    while($result = mysqli_fetch_assoc($run_msg)) {
        $sender_username = $result['sender_username'];
        $reciever_username = $result['reciever_username'];
        $msg_content =  $result['msg_content'];
        $msg_date   = $result['msg_date']; 

     


        $output .= '<ul>'
        ?>
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
         
       $output .=  '</ul>
       ';
      
    }

     $output .=  "</div>";

 

  


       
     }

     }
     


     /// make message 


     if(isset($_GET['get_username'])) { 
        $username = $_SESSION['username'];
        $get_username = $_GET['get_username'];
         $msg_content = $_GET['msg_content'];

      if(empty($msg_content)) {
          $msg =  "<div class='alert alert-danger empty-msg'>نص الرساله فارغ</div>";
      } else if(strlen($msg_content) > 100) {
          $msg =  "<div class='alert alert-danger big-msg'>نص الرساله يجب ان يكون اقل من 100 حرف </div>";   
      } else {
          $insert = "INSERT INTO users_chat (sender_username,reciever_username,msg_content,msg_status,msg_date)";
          $insert .= " VALUES ('$username','$get_username','$msg_content','unread','now()')";
          $run_insert = mysqli_query($conn,$insert);
          $sql = "UPDATE users SET login_status = 'online'  WHERE username ='$username'";
          $update_status = mysqli_query($conn,$sql);
          echo "<meta http-equiv='refresh' content='0'>";
         $msg_content = '';
          
    
      }
      
  }



 ?>


