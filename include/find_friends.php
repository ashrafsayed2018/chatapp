<?php 


require_once "find_friends_function.php";
if(!isset($_SESSION['email'])) {
    header('location:signin.php');
}
$username = $_SESSION['username'];

  ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> find friend page  </title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" href="../css/find_friends.css">
    </head>
    <body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12">
                <nav class="navbar navbar-inverse">
                    <a href="../chatroom.php?user_name=<?php echo $username; ?>" class="navbar-brand">
                        My Chat
                    </a>
                    <ul>
                        <li class="nav navbar-nav">
                            <a href="../account_settings.php" style="color:white;text-decoration:none;font-size:20px;position: relative;top: 10px;">
                                <i class="fa fa-gear"></i>
                            Settings</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <div class="row">
              <div class="col-xs-4">
               
              </div>
              <div class="col-xs-4">
                   <form action="" class="seacrh-form" method="GET">
                       <input type="text"  name = "search-query" class="search-query" placeholder="search friend" autocomplete="off">
                       <button class="btn btn-success" name="submit" class="search-btn">Search Freind</button>
                   </form>
              </div>
              <div class="col-xs-4">
              
              </div>
        </div>
    </div>
 <?php 
 print_r(search_user());
 ?>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
    <script>
    $('.search-query').focus();
    </script>
    </body>
</html>