<?php
//import the config,php file to establish database connectivity
require('config.php');
//turn on buffer output
ob_start();

//retrive professor assigned lecture from cookies
$name=$_COOKIE["name"];

// If cookies is empty them redirect to login page
if($_COOKIE["lecture"]==""){
  header("Location: index.php");
}
//If cookies is present then page will load
else{ ?>
<!DOCTYPE HTML>
<html lang="en" >
<head>
  <title>View Approved Request</title>
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
        			<button >Home</button>
        		</form>
        		<form>
      				<button onClick="window.location.reload();">View Approvals</button>
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
	      	<form method="post" role="form">
	      		<!-- initalizing table to display fetch result in tabular form -->
	      		<table class="table table-bordered" id="myTable">
	      			<caption style="color:white; font-family:Serif; font-size:160%; font-weight: bold;">View Booked Appointments</caption>
	      			
	      			<!-- initalizing table head to display fetch result headings -->
	      			<thead class="alert-info">
	      				<tr>
	      					<th id="student_name">Student Name</th>
							<th id="student_email">Email</th>
							<th id="student_lecture">Lecture</th>
							<th id="student_date">Date</th>
							<th id="student_timeslot">Timeslot</th>
							<th id="student_status">Status</th>
						</tr>
					</thead>
					<!-- initalizing table body containing rows -->
					<tbody>
					<!-- MySQL query to fetch the data from database -->
					<?php

    $query = "SELECT * FROM Appointments where lecture=:lecture and status='approved'";
    $query_params = array(
        ':lecture' => $_COOKIE['lecture']
    );
    try {
        $stmt = $db->prepare($query);
        $result = $stmt->execute($query_params);
}

    catch (PDOException $ex) {
        $response["error"] = true;
        $response["message"] = "Database Error1. Please Try Again!";
        die(json_encode($response));
    }
        if($result){
            while($row = $stmt->fetch())
                {?>
						<!-- setting data inside table row by row stored in $fetch array-->
						<tr style="color:white;">
							<td><?php echo $row['name']?></td>
							<td><?php echo $row['email']?></td>
							<td><?php echo $row['lecture']?></td>
							<td><?php echo $row['date']?></td>
							<td><?php echo $row['timeslot']?></td>
							<td><?php echo $row['status']?></td>
							</tr><?php
						}
					}?>
					</tbody>
				</table>
				</form>
			</div>
		</div>
</section>
</body>
<!-- Script to flush the stored cookies -->
<script>
	function resetCookie(){
		document.cookie = "lecture" + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/"
        document.cookie = "name" + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/"
        document.cookie = "email" + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/"
    }
</script>
</html>
<?php }?>
