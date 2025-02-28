<?php

    session_start();
    require ("db.php");

    $username = $pass = $email = $conform_password = '';
    $username_err = $pass_err = $email_err = $conform_password_err = '';

    if($_SERVER["REQUEST_METHOD"] == "POST"){

        //Username
        if(empty(trim($_POST["username"]))){
            $username_err = "Username is required";
        }else{
            $username = trim(filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS));

            if(strlen($username) < 3){
                $username_err = "Username must be at least 3 characters long";
            }
        }

        //Email
        if(empty(trim($_POST["email"]))){
            $email_err = "Email is requierd";
        }elseif(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
            $email_err = "Enter a valid email address";
        }else{
            $email = trim($_POST["email"]);
        }

        //Password
        if(empty(trim($_POST["password"]))){
            $password_err = "Password is required";
        }else{
            if(trim(strlen($_POST["password"])) < 8){
                $password_err = "Password must be at least 8 characters";
            }else{
                $password = trim($_POST["password"]);
            }
        }

        //Confirm Password

        if(empty(trim($_POST["conform_password"]))){
            $conform_password_err = "Please conform your password";
        }else{
            $conform_password = trim($_POST["conform_password"]);

            if($conform_password != $password){
                $conform_password_err = "Passwords do not match";
            }
        }

        if(empty($username_err) && empty($email_err) && empty($password_err) &&  empty($conform_password_err)){

            $hash = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users(user, email, password) 
            VALUES('$username', '$email', '$hash')";

            try{
                mysqli_query($conn, $sql);
                echo "Registered Sucessfully";

                session_destroy();

                header("Location: login.php");

            }
            catch(Exception){
                echo "Something went wrong";
            }
        }

    }

    mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main> 
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="form_container">
      <h2>Register</h2>
        <label for="username">Name<span>*</span> </label>
        <input type="text" id="username" name="username" value="<?php echo $username; ?>" placeholder="Enter your name" required> 
        <span><?php echo $username_err; ?></span>

        <label for="email">Email<span>*</span></label> 
        <input type="text" id="email" name="email" value="<?php echo $email;?>" placeholder="Enter your email" required> 
        <span><?php echo $email_err; ?></span>  
        
        <label for="password">Password<span>*</span></label> 
        <input type="password" id="password" name="password" placeholder="Enter your password"> 
        <span><?php echo $password_err; ?></span>  

        <label for="conform_password">Conform Password<span>*</span></label> 
        <input type="password" id="conform_password" name="conform_password" placeholder="Re-type your password"> 
        <span><?php echo $conform_password_err; ?></span>  
        
        <div class="submit">
            <input type="submit" value="submit" name="submit">
        </div>
      </form>
    </main>
    
</body>
</html>


<?php

    
?>
