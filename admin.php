<?php
session_start();
include_once("config.php");
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !=true || $_SESSION['email']!='admin@tindog')
    {
    header("location: login.php");
    }
    if(isset($_GET['delete'])){
      $phone= $_GET['delete'];
      $sql = "DELETE FROM `details` WHERE `phone` = '$phone'";
      $result1 = mysqli_query($conn , $sql);
      if(!$result1){
        echo "Internal Server Error : cannot delete the records";
      }
      else{
        unset($_GET['delete']);
        header('Location: admin.php');
      }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>user details</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
    crossorigin="anonymous"></script>
  <link href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet">
</head>
<script> if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
  }
</script>

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
  <div class="container">
    <h3>Welcome admin</h3>
    <table class="table" id="myTable">
      <thead>
        <tr>
          <th scope="col">S. No.</th>
          <th scope="col">Name</th>
          <th scope="col">Email</th>
          <th scope="col">Phone</th>
          <th scope="col">Breed</th>
          <th scope="col">Payment</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
            //connecting to user database
            $sql = "select * from `details`";
            $result = mysqli_query($conn, $sql);
            $num = mysqli_num_rows($result); //gives total number of rows
            $sno = 0;
            while ($row = mysqli_fetch_assoc($result)) {
              if ($row['email'] == 'admin@tindog')
                continue;
              $sno += 1;
              $msg = "
                  <tr>
                  <th scope = 'row'>" . $sno . "</th>
                  <td>" . $row["name"] . "</td>
                  <td>" . $row["email"] . "</td>
                  <td>" . $row["phone"] . "</td>
                  <td>" . $row["breed"] . "</td>
                  <td>" . $row["payment"] . "</td>
                  <td>" . '<button type="button" class="delete btn btn-danger">Delete</button>' . "</td>
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
  <script>
    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
      element.addEventListener('click', (e) => {
        tr = e.target.parentNode.parentNode;
        phone = tr.getElementsByTagName('td')[2].innerText;
        if (confirm("Do you really want to delete this record?")) {
          window.location = `admin.php?delete=${phone}`;
        }
      })
    })
  </script>
</body>

</html>