<?php
include_once("config.php");
session_start();
// check if the user is already logged in
if (isset($_SESSION['email'])) {
    if($_SESSION['email']=='admin@tindog'){
        header("Location:admin.php");
    }
    else{
        header("Location:dashboard.php");
    }
}
$username = $password = "";
// if request method is post
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $email = trim($_POST['email']);
  $password = trim($_POST['password']);
  $sql = "SELECT `email`, `password` , `payment` FROM `details` WHERE `email` = '$email'";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);
  if (mysqli_num_rows($result) == 0) {
    echo "no user exits";
  } else {
    $hashedPwd = $row['password'];
    if (password_verify($password, $hashedPwd)) {
        if($row['payment']=='done'){
            $_SESSION["email"] = $email;
            $_SESSION["loggedin"] = true;
            if($email == 'admin@tindog'){
                header("Location:admin.php");
            }
            else{
                header("Location:dashboard.php");
            }
        }
        else{
            echo "please complete your payment first";
        }
    } else {
      echo "please enter the correct password";
    }
  }
}
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignUp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>
</head>

<body>
    <div class="container mt-3">
        <h1>Login Form</h1>
        <form class="form-group" action="" method="post">
            <div class="mb-3">
                <label for="email" class="form-label">email</label>
                <input type="email" class="form-control" id="email" placeholder="email" name="email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">password</label>
                <input type="password" class="form-control" id="password" placeholder="password" name="password">
            </div>
            <input value="login" type="submit" class="btn btn-primary">
        </form>
    </div>

</body>

</html>