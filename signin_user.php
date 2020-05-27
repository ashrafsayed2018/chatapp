<?php
require_once "include/connection.php";

if(isset($_POST['signin'])) {
    $email = htmlentities(mysqli_real_escape_string($conn,$_POST['email']));
    $password = htmlentities(mysqli_real_escape_string($conn,$_POST['password']));
    $errors = [];
    if($email == '') {
        $errors['emptyemail'] = "<div class='alert-danger' style='padding:10px'>Empty email </div>";
   
       }
     
       if($password == '') {
        $errors['emptypassword'] = "<div class='alert-danger' style='padding:10px'>Empty password</div>";
   
       }
       if(!empty($password) && strlen($password) < 8) {
        $errors['lengthpassword'] = "<div class='alert-danger' style='padding:10px'> password Length is more than 8 char</div>";
       }

       if(empty($errors)) {
        // check the email if is already exists and the password

        $check_user = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";

        $run_user = mysqli_query($conn,$check_user);
        $row_count = mysqli_num_rows($run_user);
        if($row_count  == 1) {

         $sql = "UPDATE users SET login_status = 'online' WHERE email = '$email' AND password = '$password'";
         $login_user = mysqli_query($conn,$sql);
         $result = mysqli_fetch_assoc($run_user);
         $_SESSION['user_id'] = $result['id'];
         $_SESSION['username'] = $result['username'];
         $_SESSION['email']    = $email;
         $_SESSION['picture']  = $result['picture'];
         $_SESSION['password'] = $password;
         $_SESSION['login_status'] = "online";

           header('Location:chatroom.php');
        } else {
            $errors['wrong email or password'] = "<div class='alert-danger' style='padding:10px'>wrong email or password </div>";
        }
    }
}