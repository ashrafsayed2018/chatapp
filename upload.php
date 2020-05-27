<?php

require_once "include/connection.php";
if(!isset($_SESSION['email'])) {
    header('location:signin.php');
} else {
    $user_email = $_SESSION['email'];
    $sql = "SELECT * FROM users WHERE email ='$user_email'";
    $run_sql = mysqli_query($conn,$sql);
    $result = mysqli_fetch_assoc($run_sql);
    $username = $result['username'];
    $user_picture = $result['picture'];
    if($user_picture == '') {
        if($result['gender'] == 'male') {
            $user_picture = "images/male.png";
        } else {
            $user_picture = "images/female.png";
        }
        
    } else {
        $user_picture = 'users_image/' . $user_picture;
    }

    $errors = array();
    
    // check if the update button is clicked

    if(isset($_POST['update'])) {
        $image = $_FILES['u_image'];
        $image_name = $image['name'];
        $image_tmp  = $image['tmp_name'];
        $directory = 'users_image/';

        $allowed_extensions = ['jpeg','jpg','png','gif'];

        if(!empty($image_name) ) {
            // get the extension of the image 
            $ext = explode('.',$image_name)[1];
            if(!in_array($ext,$allowed_extensions)) {
                $errors['ext'] = "<div class='alert alert-danger'> the image extension is not allowed </div>";
            }
        }
      

      if(empty($image_name)) {
        $errors['empty'] = "<div class='alert alert-danger'> there is no image uploaded </div>";
      }

      // if there is no errors 

      if(empty($errors)) {
          move_uploaded_file($image_tmp,$directory . $image_name);

          $update = "UPDATE users SET picture = '$image_name' WHERE email = '$user_email'";
          $run_update = mysqli_query($conn,$update);

          if($run_update) {
            $upload_success = "<div class='alert alert-success'> your profile image is successfully uploaded </div>";
          } else {
              echo "not running";
          }

         
      }

    }
}
 ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> upload profile image   </title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" href="css/find_friends.css">
       
    </head>
    <body>
    <div class="container-fluid">
        <div class="row">
                <div class="col-xs-12">
                    <nav class="navbar navbar-inverse">
                        <a href="chatroom.php?user_name=<?php echo $username; ?>" class="navbar-brand">
                            My Chat
                        </a>
                        <ul>
                            <li class="nav navbar-nav">
                                <a href="account_settings.php" style="color:white;text-decoration:none;font-size:20px;position: relative;top: 10px;">
                                    <i class="fa fa-gear"></i>
                                Settings</a>
                            </li>
                        </ul>
                    </nav>
                </div>
        </div>
        <div class='card'>
            <img src='<?php echo $user_picture;?>' alt=''>
            <h1><?php echo $username?></h1>
                
            <form action='' method='post' enctype="multipart/form-data">
                 <label for="update_image" id="update_profile_image" class="btn btn-primary">Update your profile image 
                    <i class="fa fa-circle-o"></i>
                    <input type="file" name="u_image" id="update_image" style="display:none">
                </label>
                <button name='update' id='btn_profile'>
                                &nbsp;&nbsp;&nbsp;
                   <i class="fa fa-heart"></i>
                     update profile image 
                </button>
            </form>

            <?php 
                 if(isset($errors['ext'])) {
                     echo $errors['ext'];
                 }
                 if(isset($errors['empty'])) {
                    echo $errors['empty'];
                }
                if(isset($upload_success)) {
                    echo $upload_success;
                }
            ?>
        </div>
    </div>
      
    </body>
</html>