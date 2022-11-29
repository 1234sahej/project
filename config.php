<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "tindog";

    $conn = mysqli_connect($servername , $username , $password , $database);
    if(!$conn){
        die("Connection to database failed" . mysqli_connect_error());
    }
?>