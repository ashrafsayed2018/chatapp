<?php 

require_once "connection.php";

function search_user() {
    global $conn;
      if(isset($_GET['submit'])) {
          $serach_query = $_GET['search-query'];
          $serach_query = htmlentities(mysqli_real_escape_string($conn, $serach_query));

         $sql = "SELECT * FROM users WHERE username LIKE '%$serach_query%'";

        
         
      } else {
          $sql = "SELECT * FROM users ORDER BY username, country DESC LIMIT 5";
      }

      $run_sql = mysqli_query($conn,$sql);

      while ($row = mysqli_fetch_assoc($run_sql)) {
            $username = $row['username'];
            $country = $row['country'];
            $gender = $row['gender'];
            $picture = $row['picture'];
            $username = trim($username,'');

            // display all user 

            echo "
            <div class='card'>
                <img src='../users_image/$picture' alt=''>
                <h1>$username</h1>
                <p class='title'>$country</p>
                <p>$gender</p>
                <form action='' method='post'>
                    <p>
                        <button name='add'>Chat With $username</button>
                    </p>
                </form>
            </div>
            ";
            if(isset($_POST['add'])) {
                header("location:../chatroom.php?user_name=$username");
            }
      }
}

?>

