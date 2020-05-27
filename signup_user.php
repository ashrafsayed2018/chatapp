<?php
require_once "include/connection.php";
if(isset($_POST['signup'])) {

     $username = htmlentities(mysqli_real_escape_string($conn,$_POST['username']));
     $password = htmlentities(mysqli_real_escape_string($conn,$_POST['user_password']));
     $email = htmlentities(mysqli_real_escape_string($conn,$_POST['email']));
     $country = htmlentities(mysqli_real_escape_string($conn,$_POST['user_country']));
     $gender = htmlentities(mysqli_real_escape_string($conn,$_POST['user_gender']));
     
     $random = rand(1,2);
     $errors = [];
    if($username == '') {
     $errors['emptyusername'] = "<div class='alert-danger' style='padding:10px'>Empty user name</div>";

    }
    if(!empty($username) && strlen($username) < 4) {
     $errors['lengthusername'] = "<div class='alert-danger' style='padding:10px'> user name Length is more than 3 char</div>";

    }
    if($password == '') {
     $errors['emptypassword'] = "<div class='alert-danger' style='padding:10px'>Empty password</div>";

    }
    if(!empty($password) && strlen($password) < 8) {
     $errors['lengthpassword'] = "<div class='alert-danger' style='padding:10px'> password Length is more than 8 char</div>";
    }

    // check the email if is already exists 

    $check_email = "SELECT * FROM users WHERE email = '$email'";

    $run_email = mysqli_query($conn,$check_email);
    $row_count = mysqli_num_rows($run_email);
    if($row_count  == 1) {
        $errors['emailexist'] = "<div class='alert-danger' style='padding:10px'> the email is already exists </div>";
    }
     //  check user name 
     $check_username = "SELECT * FROM users WHERE username = '$username'";

     $run_username = mysqli_query($conn,$check_username);
     
     $row_count = mysqli_num_rows($run_username);
     if($row_count > 0) {
     $errors['usernameexist'] = "<div class='alert-danger' style='padding:10px'> the username is already exists </div>";

     }

    if(empty($country)) {
     $errors['emptycountry'] = "<div class='alert-danger' style='padding:10px'> select your country </div>";
    }
    if(empty($gender)) {
     $errors['emptygender'] = "<div class='alert-danger' style='padding:10px'> select your gender </div>";
    }

    if($gender == "male") {
         $profile_pic = "images/male.png";
    }
    if($gender == "female") {
     $profile_pic = "images/female.png";
     }

     if($gender == "other") {
          $profile_pic = "images/other.png";
      }
    if(!isset($_POST['checkbox'])) {
        $errors['emptycheckbox'] = "<div class='alert-danger' style='padding:10px'> please agree the term af use </div>";
    }
      // if empty errors 

      if(empty($errors)) {
           $sql = "INSERT INTO users (username,password,email,country,gender,picture) ";
           $sql .= "VALUES('$username','$password','$email','$country','$gender','$profile_pic')";

           $query = mysqli_query($conn,$sql);

           if($query) {
                $success = "<div class='alert-success text-center'> Congratulation $username you are logged in </div>";
           }
      }
 
 }