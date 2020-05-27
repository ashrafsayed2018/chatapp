<?php
require_once "include/connection.php";

$email = $_SESSION['email'];
$bf = $_SESSION['bf'];

if(isset($_POST['create'])) {
    $password = htmlentities(mysqli_real_escape_string($conn,$_POST['password']));
    $confirm = htmlentities(mysqli_real_escape_string($conn,$_POST['confirm']));

    $errors = [];

    if(empty($password)) {
        $errors['emptypassword'] = "<div class='alert-danger' style='padding:10px'>Empty password </div>";

    }
    if(!empty($password) && strlen($password) < 8) {
        $errors['lengthpassword'] = "<div class='alert-danger' style='padding:10px'>password should be more than 8 chars </div>";

    }
    if(empty($confirm)) {
        $errors['emptyconfirm'] = "<div class='alert-danger' style='padding:10px'>Empty confirm password</div>";

    }

    if($password !== $confirm) {
        $errors['matching'] = "<div class='alert-danger' style='padding:10px'>password and confirm password not matching</div>";

    }

    if(empty($errors)) {
                // check the email if is already exists and the best friend

                $update = "UPDATE users SET password = '$password'  WHERE email = '$email' AND 	forgotten_answer = '$bf'";
                $run_update = mysqli_query($conn,$update);

                header("location:signin.php");  
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/signin.css">
    <title>create password</title>
</head>
<body>
     <div class="signin-form">
         <form action="" method="post">
             <div class="form-header">
                  <h2>create password</h2>
                  <p>My chat</p>
              </div>
              <div class="form-group">
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

              <div class="form-group">
                   <label for="password">confirm password</label>
                   <input type="password" name="confirm" placeholder="confirm your password" class="form-control" autocomplete="new-password" id="password" value="<?php echo isset($confirm) ? $confirm : '';?>">
              </div>
              <?php  
              if(isset($errors['emptyconfirm'])) {
                  echo $errors['emptyconfirm'];
              }
           
              if(isset($errors['matching'])) {
                  echo $errors['matching'];
              }
              ?>
          
              <div class="form-group">
                 <button type="submit" class="btn btn-primary btn-block btn-lg" name="create">create </button>
              </div>
         </form>
      
     </div>
     <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>