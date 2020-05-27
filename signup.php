<?php require_once ("signup_user.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/signup.css">
    <title>sign up</title>
</head>
<body>
     <div class="signup-form">
          <?php
              if(isset($success)) {
                   echo $success;
              }
          ?>
         <form action="" method="post">
             <div class="form-header">
                  <h2>create new account</h2>
                  <p>sign up to chat system</p>
              </div>
              <div class="form-group">
                   <label for="username">username</label>
                   <input type="text" name="username" placeholder="Enter your Usermame" class="form-control" autocomplete="off" id="username" value="<?php echo isset($username) ? $username: '';?>">
              </div>
              <?php
              if(isset($errors['emptyusername'])) {

                   echo $errors['emptyusername'];
              }
              if(isset($errors['lengthusername'])) {

                     echo $errors['lengthusername'];
                }
                if(isset($errors['usernameexist'])) {
                     echo $errors['usernameexist'];
                }
              ?>
              <div class="form-group">
                   <label for="password">password</label>
                   <input type="password" name="user_password" placeholder="Enter your password" class="form-control" autocomplete="new-password" id="password" value="<?php echo isset($password) ? $password: '';?>">
              </div>
              <?php
              if(isset($errors['emptypassword'])) {

                   echo $errors['emptypassword'];
              }
              if(isset($errors['lengthpassword'])) {

               echo $errors['lengthpassword'];
             }
              ?>
              <div class="form-group">
                   <label for="email">email Address</label>
                   <input type="email" name="email" placeholder="Enter your email" class="form-control" autocomplete="off" id="email" value="<?php echo isset($email) ? $email: '';?>">
              </div>
              <?php 
            if(isset($errors['emailexist'])) {
                 echo $errors['emailexist'];
            }
              ?>
              <div class="form-group">
                   <label for="country">country</label>
                   <select name="user_country" id="country" class="form-control" value="<?php echo isset($country) ? $country: '';?>">
                       <option value=""> select the country</option>
                       <option value="egypt">egypt</option>
                       <option value="kuwait">kuwait</option>
                       <option value="usa">USA</option>
                       <option value="qater">qater</option>
                   </select>
              </div>
              <?php 
           if(isset( $errors['emptycountry'] )) {
                echo  $errors['emptycountry'] ;
           }
              ?>
              <div class="form-group">
                   <label for="gender">gender</label>
                   <select name="user_gender" id="gender" class="form-control" value="<?php echo isset($gender) ? $gender: '';?>">
                       <option value=""> select your gender</option>
                       <option value="male">male</option>
                       <option value="female">female</option>
                       <option value="other">other</option>
                   </select>
              </div>
              <?php 
           if(isset( $errors['emptygender'] )) {
                echo  $errors['emptygender'] ;
           } else { ?>
               <img src="<?php echo $profile_pic;?>" alt="" style="width:40px;height:40px">
          <?php }
              ?>
              
              <div class="form-group">
                  <label for="checkbox" class="container-checkbox">
                       <input type="checkbox" class="checkbox" id="checkbox" name="checkbox" value="on">
                       <span class="checkmark"></span>
                       I accept the <a href="#"> terms of conditons </a> &amp;
                       <a href="#">Privacy Policy</a>
                  </label>
                  <?php
                  if(isset($errors['emptycheckbox'])) {
                       echo $errors['emptycheckbox'];
                  }
                  ?>
              </div>
              <div class="form-group">
                 <button type="submit" class="btn btn-primary btn-block btn-lg" name="signup">sign up </button>
              </div>
            
         </form>
         <div class="text-center small" style="color:#674288">Already Have an Account ? 
                <br>
                <a href="signin.php">sign in </a>
         </div>
     </div>
     <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>