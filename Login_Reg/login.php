<?php
    session_start();
    if(isset($_SESSION["user"])){
        header("Location: index.php");  //session code to provide access to logined users only
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="./style.css">
</head>
<body class="bg-secondary">
    <div class="container">
        <?php
            if(!empty($_POST['login']))
            {
                $email=$_POST['email'];
                $password=$_POST['password'];  //taking values from login form by post method_exists

                //connection to database

                require "database.php";
                $query="select * from users where email='$email' and password='$password'"; //query for taking values from table for email and password verificaton.
                $result=mysqli_query($conn,$query);
                $count=mysqli_num_rows($result);

                $record = mysqli_fetch_array($result);
                if($count>0)
                {
                    session_start();
                    $_SESSION["user"] = $record['fullname'];
                    header("Location: index.php");  //access index.php for loginned users only
                    die();
                }
                else
                {
                    echo "<div class='alert alert-danger'>password does not match</div>";
                }
            }
        ?>
        <!--LOGIN FORM-->
        <p class="d-flex justify-content-center h2">Login Form</p>
        <form action="login.php" method="post">
            <div class="form-group">
                <input type="email" placeholder="Enter Email:" name="email" class="form-control" autocomplete="off">
            </div>
            <div class="form-group">
                <input type="password" placeholder="Enter Password:" name="password" class="form-control" autocomplete="off">
            </div>
            <div class="form-btn">  <!--Login-->
                <input type="submit" value="Login" name="login" class="btn btn-primary">
            </div>
        </form>
        <div><p>Not Registered Yet ? --> <a href="Registration.php" class="text-light">Register Here</a></p></div>
    </div>
    
</body>
</html>