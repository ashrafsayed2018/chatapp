<?php 

$email = $_SESSION['email'];
$sql = "SELECT * FROM users WHERE email  != '$email'";

$all_users = mysqli_query($conn,$sql);
$result = mysqli_fetch_assoc($all_users);


while($result = mysqli_fetch_assoc($all_users)) {
    $user_id = $result['id'];
    $username =  $result['username'];
    $picture = $result['picture'];
    if($picture == '') {
        if($result['gender'] == 'male') {
            $picture = "images/male.png";
        } else {
            $picture = "images/female.png";
        }
        
    } else {
        $picture = 'users_image/' . $picture;
    }
    $login_status = $result['login_status'];
        
        echo "
        <li>
            <div class='chat-left-img'>
                <img src='$picture' alt=''>
                
            </div>
            <div class='chat-left-details'>
                <p>
                    <a href='chatroom.php?user_name=$username' id='$username' class='username_link'>$username</a>
                </p>";
                if($login_status == "online") {
                    echo '<span><i class="fa fa-circle online"></i> <small>متصل</small></span>';
                } else {
                    echo '<span><i class="fa fa-circle offline"></i> <small>غير متصل </small></span>';
                }
           echo "</div>
        </li>";

}

if($all_users) {
   
}



?>



