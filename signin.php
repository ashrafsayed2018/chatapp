<?php require_once "signin_user.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/signin.css">
    <title>sign in</title>
</head>
<body>
     <div class="signin-form">
         <form action="" method="post">
             <div class="form-header">
                  <h2>log in</h2>
                  <p>login to chat system</p>
              </div>
              <div class="form-group">
                   <label for="email">email</label>
                   <input type="email" name="email" placeholder="enter your email" class="form-control" autocomplete="off" id="email" value="<?php echo isset($email) ? $email : '';?>">
              </div>
              <?php  
              if(isset($errors['emptyemail'])) {
                  echo $errors['emptyemail'];
              }
              ?>

              <div class="form-group">
                   <label for="password">password</label>
                   <input type="password" name="password" placeholder="enter your password" class="form-control" autocomplete="new-password" id="password" value="<?php echo isset($password) ? $password : '';?>">
              </div>
              <?php  
              if(isset($errors['emptypassword'])) {
                  echo $errors['emptypassword'];
              }
              if(isset($errors['lengthpassword'])) {
                echo $errors['lengthpassword'];
            }
              ?>
              <div class="small">
                   forgot passoword ?
                   <a href="forgot_pass.php">click here</a>
              </div>
              <div class="form-group">
                 <button type="submit" class="btn btn-primary btn-block btn-lg" name="signin">sign in </button>
              </div>
         </form>
         <div class="text-center small" style="color:#674288">Don't Have an Account ? 
                <br>
                <a href="signup.php">sign up </a>
         </div>
     </div>
     <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>