<?php 


require_once "include/connection.php";
if(!isset($_SESSION['email'])) {
    header('location:signin.php');
} else {
    $user_email = $_SESSION['email'];
    $sql = "SELECT * FROM users WHERE email ='$user_email'";
    $run_sql = mysqli_query($conn,$sql);
    $result = mysqli_fetch_assoc($run_sql);
    $user_id = $result['id'];
    $username = $result['username'];
    $user_password = $result['password'];
    $user_country = $result['country'];
    $user_gender = $result['gender'];
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

    // query to select all the counties 
    $country_sql = "SELECT country FROM users";
    $run_country_sql = mysqli_query($conn,$country_sql);
 
  if(isset($_POST['sub'])) {
      $best_freind = htmlentities(mysqli_real_escape_string($conn,$_POST['best_friend']));
     if($best_freind == '') {
         $msg = "<div class='alert alert-danger'>Please Enter your best friend name </dib";
     } 
     else {
         $update = "UPDATE users set forgotten_answer = '$best_freind' WHERE email = '$user_email'";
         $run_update = mysqli_query($conn,$update);
         if($run_update) {
            $msg = "<div class='alert alert-success'>Your are Update your best friend name to $best_freind </dib";
         } else {
            $msg = "<div class='alert alert-danger'>not Updated your best friend name </dib";
         }
     }
  }

//    if isset post update information 
if(isset($_POST['update'])) {
        $username = htmlentities(mysqli_real_escape_string($conn,$_POST['u-name']));
        $email    = htmlentities(mysqli_real_escape_string($conn,$_POST['u-email']));
        $country  = htmlentities(mysqli_real_escape_string($conn,$_POST['u-country']));
        $gender   = htmlentities(mysqli_real_escape_string($conn,$_POST['u-gender']));



        $update = "UPDATE users SET username = '$username' , email ='$email' , country = '$country' , gender = '$gender' WHERE email= '$user_email'";

        $run_update = mysqli_query($conn,$update);

        if($run_update) {
            $msg = "<div class='alert alert-success'>Your are Update your information </dib";
        }


 }

}


?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> Account Setting Page   </title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
       
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-2">
                           <button class="btn btn-defaolt"><?php echo $username; ?></button>
                           <a href="chatroom.php" class="btn btn-primary"> Chat Room</a>
                
                </div>
                <div class="col-xs-8">
                    <form action="" method="post" enctype="multipart/form-data">
                        <table class="table table-bordered table-hover">
                            <tr class="text-center">
                                <th colspan="6" class="active">
                                     <h1>change account settings </h1>
                                </th>
                            </tr>
                            <tr>
                                <td style="font-weight:bold"> change your username </td>
                                <td>
                                    <input type="text" name="u-name" class="form-control" value="<?php echo $username ;?>">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <img src="<?php echo $user_picture; ?>" alt="" width="80px" height="80px">
                                </td>
                                <td>
                                    <a href="upload.php" class="btn btn-primary" style="text-decoration:none">upload profile image </a>
                                    <i class="fa fa-heart"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight:bold"> change your Email </td>
                                <td>
                                    <input type="text" name="u-email" class="form-control" value="<?php echo $user_email ;?>">
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight:bold"> change you country</td>
                                <td>
                                    <select name="u-country" id="u-country" class="form-control" >
                                        <?php  
                                           while($c_result = mysqli_fetch_assoc($run_country_sql)) { ?>
                                           <option value="<?php echo $c_result['country']; ?>" ><?php echo $c_result['country']; ?></option>
                                        <?php }
                                        
                                        ?>
                                      
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                  <td style="font-weight:bold"> change you gender</td>
                                  <td>
                                    your gender is <?php echo $user_gender ?>
                                         <select name="u-gender" id="u-gender" class="form-control" >

                                         <?php  if(isset($user_gender) && $user_gender == 'male') {?>
                                              <option value="female">female</option>
                                             <option value="other">other</option>
                                            <?php } else if(isset($user_gender) && $user_gender == 'female'){?>
                                                <option value="male">male</option>
                                                <option value="other">other</option>

                                           <?php } else { ?>
                                            <option value="male">male</option>
                                             <option value="female">female</option>
                                            <?php }?>
                                           
                                        </select>
                                  </td>
                            </tr>
                            <tr>
                            <td style="font-weight:bold"> forgetton password</td>
                             <td>
                                 <button type="button" class="btn btn-primary" data-target="#mymodal" data-toggle="modal">
                                 forgetton password
                                 </button>
                             </td>
                            </tr>

                            <tr>
                            <td style="font-weight:bold"> Change password</td>
                             <td>
                                <a href="change_password.php" class="btn btn-primary" style="color:#fff;text-decoration:none"> Change password
                                     <i class="fa fa-key"></i>
                                </a>
                          
                             </td>
                            </tr>
                             <tr>
                                 <td>Update Your Profile </td>
                                 <td>
                                     <button type="submit" name="update" class="btn btn-info">Update Your info </button>
                                 </td>
                             </tr>
                        </table>
                    </form>
                    <?php if(isset($msg)) { echo $msg;} ?>
                </div>
                <div class="col-xs-2">
                    
                </div>
                <div id="mymodal" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">
                                                     &times;
                                 </button>
                            </div>
                            <div class="modal-body">
                                <form action="" method="post">
                                    <strong> What's your best friend name in our chat app </strong>
                                    <textarea name="best_friend" id="" cols="30" rows="4" class="form-control"></textarea>
                                    <br>
                                    <input type="submit" class="btn btn-primary" name="sub" value="Submit">
                                </form>
                                <?php if(isset($msg)) { echo $msg;} ?>
                             </div>
                             <div class="model-footer">
                                 <button class="btn btn-danger" data-dismiss="modal">Close</button>
                             </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
    </body>
</html>