<?php
    $host = "localhost";
    $user = "rana";
    $pass = "@Suyog123";
    $db_name = "project";
    $conn = "";


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