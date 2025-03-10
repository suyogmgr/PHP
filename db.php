<?php
    // $host = "sql103.infinityfree.com";
    // $user = "if0_38409299";
    // $pass = "yourpassword";
    // $db_name = "if0_38409299_project";
    // $conn = "";

    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $db_name = 'login';
    $conn = '';

    $conn = mysqli_connect($host, $user, $pass, $db_name);

    if(!$conn){
        die("Oops connection failed: ". mysqli_connect_error());
    }

    // $conn = new mysqli($host, $user, $pass, $db_name);

    // if($conn->connect_error){
    //     die("Connection error" . $conn->connect_error);
    // }else{
    //     echo "Connection Sucessfull";
    // }
?>
