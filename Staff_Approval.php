<?php
//import the config,php file to establish database connectivity
include('config.php');
//turn on buffer output
ob_start();
//retrive professor assigned lecture from cookies
$name=$_COOKIE["name"];
// If cookies is empty them redirect to login page
if($_COOKIE['lecture']==""){
  header("Location: index.php");
}
//If cookies is present then page will load
else{ ?>
<!DOCTYPE HTML>
<html lang="en" >
<head>
  <title>Approve Request</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="utf-8">

  <!-- binding CSS with HTML -->
  <link rel="stylesheet" type="text/css" href="style.css">

<!-- restrict user to go back to previous page -->
  <script type = "text/javascript">
      history.pushState(null, null, location.href);
      history.back(); history.forward();
      window.onpopstate = function () { history.go(1); };
  </script>
</head>

<body class="body">
  <!-- logout button division -->
<div class="lable">
    <div class="cssmarquee">
     <h1 style="color:white; font-family:Serif; font-size:160%; font-weight: bold;">Welcome, <?php echo $safename = htmlspecialchars($name);?></h1>
  </div>
</div>
<!-- after logout button lable divide page into 30:70 ratio using section -->
<section>
<!-- right align naigation pannel menu-->
<nav>
    <div class="form">
      <div class="tab right">
        <form action="Staff_Approval.php">
          <button onClick="window.location.reload();">Home</button>
        </form>
       <form action="Staff_View_Approval.php">
          <button>View Approvals</button>
      </form>
      <!-- Redirect to login page and clear the stored Cookies using javacript function call resetCookie() -->
       <form action="index.php" onclick="resetCookie()">
            <button style="background-color:red;">Logout</button>
        </form>
    </div>
  </div>
</nav>
 <!-- right align naigation pannel End -->
 <!-- view booking division tag -->
<div id="outPopUp">
  <div>
    <form action="" method="post" role="form">   
      <!-- initalizing table to display fetch result in tabular form -->
      <table class="table table-bordered" id="myTable">
        <caption style="color:white; font-family:Serif; font-size:160%; font-weight: bold;">Pending Appointments Approvals</caption>
        <!-- initalizing table head to display fetch result headings -->
        <thead class="alert-info">
          <tr>
            <th id="student_name">Student Name</th>
            <th id="student_email">Email</th>
            <th id="student_lecture">Lecture</th>
            <th id="student_timeslot">Timeslot</th>
            <th id="student_status">Status</th>
            <th id="student_approve">Approve</th>
            <th id="student_decline">Decline</th>
          </tr>
        </thead>
        <!-- initalizing table body containing rows -->
        <tbody>
        <!-- MySQL query to fetch the appointment of professor lecture data from database -->
          <?php

          // If form submitted, insert values into the database.
    $resp = "SELECT * FROM Appointments WHERE lecture=:lecture AND status='unapproved'";
    $query_params = array(
        ':lecture' => $_COOKIE['lecture']
    );
    try {
        $stmt = $db->prepare($resp);
        $result = $stmt->execute($query_params);
}

    catch (PDOException $ex) {
        $response["error"] = true;
        $response["message"] = "Database Error1. Please Try Again!";
        die(json_encode($response));
    }
        if($resp){
            while($fetch = $stmt->fetch())
                {?>
                  <tr style="color:white;">
                    <td><?php echo $fetch['name']?></td>
                    <td><?php echo $fetch['email']?></td>
                    <td><?php echo $fetch['lecture']?></td>
                    <td><?php echo $fetch['timeslot']?></td>
                    <td><?php echo $fetch['status']?></td>
                    <!-- execute update operation using Update.php -->
                    <td><a class="button1" href="Update.php?email=<?php echo $fetch['email']; ?>" data-toggle="tooltip" data-placement=bottom title="Approve">Approve</a></td>
                    <!-- execute delete operation using Delete.php -->
                    <td><a class="button" href="Delete.php?email=<?php echo $fetch['email']; ?>" data-toggle="tooltip" data-placement=bottom title="Decline">Decline</a></td>
                   </tr>
                   <?php }
        }?>
        </tbody>
      </table> 
    </form>
  </div>
</div>
</section>
<!-- Script to flush the stored cookies -->
<script>
  function resetCookie(){
    document.cookie = "lecture" + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/"
    document.cookie = "name" + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/"
    document.cookie = "email" + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/"
  }
</script>
</body>
</html>
<?php }?>
