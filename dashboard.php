<?php
include_once("config.php");
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  header("location: login.php");
}
?>
<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
    crossorigin="anonymous"></script>
  <link href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet">
  <title>User DashBoard</title>
  <script> if (window.history.replaceState) {
      window.history.replaceState(null, null, window.location.href);
    }
  </script>
</head>
<?php
          $email = $_SESSION['email'];
          $query = "select * from `details` where `email` ='$email'";
          $result = mysqli_query($conn, $query);
          $row = mysqli_fetch_assoc($result);
          $name = $row['name'];
          $breed = $row['breed'];
          ?>
<body>
<nav class="navbar navbar-expand-lg bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Tindog</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <button class="btn btn-outline-success" onclick = "window.open('logout.php','_self')">Logout</button>
      </ul>
    </div>
  </div>
</nav>
   <div class="container mt-2">
   <h3>welcome <?php echo ucwords($name)." start finding the perfect dog for your ".$breed?></h3>
    <table class="mt-3 table" id="myTable">
      <thead>
        <tr>
          <th scope="col">S. No.</th>
          <th scope="col">Name</th>
          <th scope="col">email</th>
          <th scope="col">phone</th>
          <th scope="col">breed</th>
        </tr>
      </thead>
      <tbody>
        <?php
        //connecting to user database
        include_once("config.php");
        $sql = "select * from `details` where `breed` ='$breed' AND `payment` = 'done'";
        $result = mysqli_query($conn, $sql);
        $num = mysqli_num_rows($result); //gives total number of rows
        $sno = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            if($row['email']==$email){
                continue;
            }
          $sno += 1;
          $msg = "
                        <tr>
                        <th scope = 'row'>" . $sno . "</th>
                        <td>" . $row["name"] . "</td>
                        <td>" . $row["email"] . "</td>
                        <td>" . $row["phone"] . "</td>
                        <td>" . $row["breed"] . "</td>
                        </tr>
                      ";
          echo $msg;
        }
        ?>
      </tbody>
    </table>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI="
    crossorigin="anonymous"></script>
  <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"> </script>
  <script>
    $(document).ready(function () {
      $('#myTable').DataTable();
    });
  </script>
</body>

</html>