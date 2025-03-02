<?php
    require "db.php";

    $password = $login_input = '';
    $password_err = $login_input_err = '';

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        if(empty(trim($_POST['login_input']))){
            $login_input_err = 'Empty Username/Email';
        }else{
            if(trim(strlen($_POST['$login_input'])) < 3){
                $login_input_err = 'Username must have atleast 3 characters';
           }else{
                $login_input = trim(filter_input(INPUT_POST, 'login_input', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
           }
        }

        if(empty(trim($_POST['password']))){
            $password_err = 'Empty Password';

        }else{
            if(strlen(trim($_POST['password'])) < 8){

                $password_err = 'Password must have atleast 8 characters';
            }else{

                $password = trim($_POST['password']);
            }
        }


        if(empty($login_input_err) && empty($password_err)){

            $sql = 'SELECT * FROM users WHERE user = ? or email = ?';
            $stmt = mysqli_prepare($conn, $sql);

            if(!$stmt){
                die("MYSQLI error: ". mysqli_error($conn));
            }

            mysqli_stmt_bind_param($stmt, 'ss', $login_input, $login_input);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if(mysqli_num_rows($result) == 1){
                $row = mysqli_fetch_assoc($result);

                if(password_verify($password, $row['password'])){
                    $_SESSION['username'] = $row['user'];
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['red_date'] = $row['reg_date'];

                    header('location: index.html');
                    exit;
                }
            }else{
                echo "Accoutnt not found";
            }
            mysqli_stmt_close($stmt);
        }
        mysqli_close($conn);
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
</head>
<body>
    <main>
        <form class="login-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <label for="login_input">Username/Email<span>*</span></label>
            <input type="text" name="login_input" value="<?php echo $login_input; ?>" placeholder="Enter Username/Password" required>
            <span><?php echo $login_input_err; ?></span>

            <label for="password">Password<span>*</span></label>
            <input type="password" name="password" placeholder="Enter Password" required>
            <span><?php echo $password_err; ?></span>

            <input type="submit" value="Login" name="Login">

        </form>
    </main>
</body>
</html>

