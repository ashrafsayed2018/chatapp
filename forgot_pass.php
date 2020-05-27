<?php
require_once "include/connection.php";

if(isset($_POST['submit'])) {
    $email = htmlentities(mysqli_real_escape_string($conn,$_POST['email']));
    $bf = htmlentities(mysqli_real_escape_string($conn,$_POST['bf']));

    $errors = [];

    if(empty($email)) {
        $errors['emptyemail'] = "<div class='alert-danger' style='padding:10px'>Empty email </div>";

    }
    if(empty($bf)) {
        $errors['emptybf'] = "<div class='alert-danger' style='padding:10px'>Empty best friend field </div>";

    }

    if(empty($errors)) {
                // check the email if is already exists and the best friend

                $check_user = "SELECT * FROM users WHERE email = '$email' AND 	forgotten_answer = '$bf'";

                $run_user = mysqli_query($conn,$check_user);
                $row_count = mysqli_num_rows($run_user);

                if($row_count == 1) {
                    $_SESSION['email']    = $email;
                    $_SESSION['bf']       = $bf;
                    header("location:create_pass.php");
                } else {
                    $errors['wrong email or bf'] = "<div class='alert-danger' style='padding:10px'>wrong email or best friend name </div>";
                }
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
    <title>Forgot password</title>
</head>
<body>
     <div class="signin-form">
         <form action="" method="post">
             <div class="form-header">
                  <h2>forgot password</h2>
                  <p>MY Chat </p>
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
                   <label for="bf">best friend name</label>
                   <input type="text" name="bf" placeholder="enter your best friend name" class="form-control" autocomplete="off" id="bf" value="<?php echo isset($bf) ? $bf : '';?>">
                    <?php
                   if(isset($errors['emptybf'])) {
                  echo $errors['emptybf'];
              }
              if(isset($errors['wrong email or bf'])) {
                  echo $errors['wrong email or bf'];
              }
              ?>
              </div>
        
              <div class="form-group">
                 <button type="submit" class="btn btn-primary btn-block btn-lg" name="submit"> Submit</button>
              </div>
              <?php //require_once ("signin_user.php"); ?>
         </form>
         <div class="text-center small" style="color:#674288">Back to sign in
                <br>
                <a href="signin.php">click here </a>
         </div>
     </div>
     <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>