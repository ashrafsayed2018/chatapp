<?php 


require_once "include/connection.php";
if(!isset($_SESSION['email'])) {
    header('location:signin.php');
} else {
    $user_email = $_SESSION['email'];
    $sql = "SELECT * FROM users WHERE email ='$user_email'";
    $run_sql = mysqli_query($conn,$sql);
    $result = mysqli_fetch_assoc($run_sql);
    $user_password = $result['password'];
    $username = $result['username'];

    $errors  = [];


    if(isset($_POST['change_pass'])) {
        $current = $_POST['current_pass'];
        $new = $_POST['new_pass'];
        $confirm = $_POST['confirm_pass'];

        if(!empty($current) && $current != $user_password) {
            $errors['current'] = "<div class='alert alert-danger'> the currrent passsword is not correct </div>";
        }
        if($new != $confirm) {
            $errors['notmatching'] = "<div class='alert alert-danger'> the tow passwords not matching  </div>";
        }

        if(empty($current)) {
            $errors['emptycurrent'] = "<div class='alert alert-danger'> the current  password  is required </div>";
        }
        if(empty($new)) {
            $errors['emptynew'] = "<div class='alert alert-danger'> the new password is required </div>";
        }
        if(empty($confirm)) {
            $errors['emptyconfirm'] = "<div class='alert alert-danger'> the confirm password  is required </div>";
        }

        if(!empty($new) && strlen($new) < 8) {
            $errors['chars'] = "<div class='alert alert-danger'> this feild should be greater than 8 chars </div>"; 
        }

        if($new == $current && $current == $user_password) {
            $errors['same'] = "<div class='alert alert-danger'> the new password is the same of the current password </div>"; 
        }


        // if empty errors 
          if(empty($errors)) {
            $update = "UPDATE users set password = '$new' WHERE email = '$user_email'";
            $run_update = mysqli_query($conn,$update);
            if($run_update) {
                $success = "<div class='alert alert-success'>Your password is updated successfully </div>"; 
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
           <div class="row">
                <div class="col-xs-2">
                 
                </div>
                <div class="col-xs-8">
                    <form action="" method="post" enctype="multipart/form-data">
                          <table class="table table-bordered table-hover" style="background:#f0f0f0">
                               <thead>
                                   <tr class="text-center">
                                       <th colspan="6" class="active">
                                           <h2 class="text-center">change your password</h2>
                                       </th>
                                   </tr>
                               </thead>
                               <tbody>
                                   <tr>
                                        <td style="font-weight:bold"> Current Password </td>
                                       <td>
                                           <input type="password" name="current_pass" class="form-control" placeholder="current password">
                                       </td>

                                       <?php
                                           if(isset($errors['current'] )) {
                                               echo $errors['current'];
                                           }
                                           if(isset($errors['emptycurrent'] )) {
                                            echo $errors['emptycurrent'];
                                        }
                                       ?>
                                   </tr>
                                   <tr>
                                       <td style="font-weight:bold"> New Password </td>
                                       <td>
                                           <input type="password1" name="new_pass" class="form-control" placeholder="new password" value="<?php echo isset($new) ? $new : '';?>">
                                       </td>
                                       <?php 
                                        if(isset($errors['emptynew'])) {
                                            echo $errors['emptynew'];
                                        }
                                        if(isset($errors['chars'])) {
                                            echo $errors['chars'];
                                        }
                                       ?>
                                   </tr>
                                   <tr>
                                       <td style="font-weight:bold"> Confirm Password </td>
                                       <td>
                                           <input type="password2" name="confirm_pass" class="form-control" placeholder="confirm password" value="<?php  echo isset($confirm) ? $confirm : '';?>">
                                       </td>
                                       <?php 
                                        if(isset($errors['notmatching'])) {
                                            echo $errors['notmatching'];
                                        }
                                        if(isset($errors['emptyconfirm'])) {
                                            echo $errors['emptyconfirm'];
                                        }
                                        if(isset($errors['same'])) {
                                            echo $errors['same'];
                                        }
                                       ?>
                                    </tr>
                                   <tr style="text-align:center">
                                       <td colspan="6">
                                           <input type="submit" name="change_pass"  value="change password" class="form-control btn btn-primary">
                                       </td>
                                   </tr>
                               </tbody>
                               <?php 
                                     if(isset( $success)) {
                                         echo  $success;
                                     }
                               ?>
                          </table>
                    </form>
                </div>
           </div>
        </div>
    </body>
</html>