<?php
    session_start();
    if(isset($_SESSION["user"])){       //session code to provide access to logined users only
        header("Location: index.php");
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <!--Bootstrap cdn link and css-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="./style.css">
    
</head>
<body class="bg-secondary">
    <div class="container">
        <!--php code-->
        <?php
        if(isset($_POST["submit"])){
            $fullname = $_POST["fullname"];
            $phone = $_POST["phone"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $compass = $_POST["compass"];     //Taking all values from the Reg form by post method

            $password_hash = password_hash($password,PASSWORD_DEFAULT); //turns password into a short string of letters and numbers using an encryption algorithm

            $errors = array();//empty array for displaying errors
            if(empty($fullname) OR empty($phone) OR empty($email) OR empty($password) OR empty($compass)){
                array_push($errors,"All fields are required");
            }
            if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                array_push($errors,"Email is not Valid");
            }
            if(strlen($password)<8){
                array_push($errors,"Password must be at least 8 characters");
            }
            if($password!=$compass){
                array_push($errors,"Password does not match");
            }
            //connecting with database

            require_once "database.php";
            $sql = "SELECT * FROM users WHERE email ='$email'"; //query for selecting email column for checking duplicate email in db
            $result = mysqli_query($conn,$sql);  
            $rowCount = mysqli_num_rows($result);
            if($rowCount>0)
            {
                array_push($errors,"Email already Exists");
            }
            //displaying errors in above form by bootstrap class
            if(count($errors)>0){
                foreach($errors as $error){
                    echo "<div class='alert alert-danger'>$error</div>";
                }
            }
            else{
                //inserting the all form values into database which are taken from the registration form
                $sql = "INSERT INTO users(fullname, phone, email, password) VALUES(?, ?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);
                $prepareStmt = mysqli_stmt_prepare($stmt,$sql);
                if($prepareStmt){
                    mysqli_stmt_bind_param($stmt,"siss",$fullname, $phone, $email, $password);//string integer string string (siss)
                    mysqli_stmt_execute($stmt);
                    echo "<div class='alert alert-success'>You are Registered successfully..</div>";
                }
                else{
                    die("Something went Wrong...!");
                }
            }

        }
        ?>
        <!--Registration Form -->
        <form action="Registration.php" method="post">
            <div class="form-group">
                <p class="d-flex justify-content-center h2">Registration Form</p>
                <input type="text" class="form-control" name="fullname" placeholder="Enter Your Fullname" autocomplete="off">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="phone" placeholder="Enter Your Phone Number" autocomplete="off">
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Enter Your Email ID" autocomplete="off">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Enter Password" autocomplete="off">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="compass" placeholder="Confirm Password" autocomplete="off">
            </div>
            <div>
                <!--Register button-->
                <input type="submit" class="btn btn-primary" value="Register" name="submit">
            </div>
        </form>
        <div><p>Already Registered. --><a href="login.php" class="text-light">Login Here</a></p></div>
    </div>
    
</body>
</html>