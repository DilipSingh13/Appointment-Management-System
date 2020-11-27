<?php
//import the config,php file to establish database connectivity
require('config.php');

ob_start();

$name=$_COOKIE['name'];

//retrive name & email from cookies
if($_COOKIE['email']==""){
  header("Location: index.php");
}
//If cookies is present then page will load
else{
// If form submitted, insert values into the database.


if (!empty($_POST)) {

  $response = array("error" => FALSE);
    
    $query = "INSERT INTO `Appointments` (`name`, `email`, `lecture`, `date`, `timeslot`, `status`) VALUES (:name, :email, :lecture, NOW(), :timeslot, :status)";
    $query_params = array(
        ':name' => $_COOKIE['name'],
        ':email' => $_COOKIE['email'],
        ':lecture' => $_POST['lecture'],
        ':timeslot' => $_POST['timeslot'],
        ':status' => "unapproved",
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
        echo '<script type="text/javascript">'; 
        echo 'alert("Booked Sucessfully");'; 
        echo 'window.location.href = "Student_Home.php";';
        echo '</script>';
        }
      }?>

<!DOCTYPE HTML>
<html lang="en" >
<head>
  <title>Book Appointment</title>
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
    <!-- right align naigation pannel -->
    <nav>
      <div class="form">
        <div class="tab right">
          <form>
            <button onClick="window.location.reload();">Home</button>
          </form>
          <form action="Student_Appointments.php">
            <button>My Appointments</button>
          </form>
          
          <!-- Redirect to login page and clear the stored Cookies using javacript function call resetCookie() -->
       <form action="index.php" onclick="resetCookie()">
            <button style="background-color:red;">Logout</button>
        </form>
        </div>
      </div>
    </nav>
    <!-- right align naigation pannel End -->

    <div id="outPopUp">
      <h1 style="color:white">Book your slot</h1>
      <div>
        <!-- On button click action the user seleted methods will get POST using method=post -->
        <form action="" method="post" role="form">
          <label for="lecture" style="color:white;"> <strong>Lecture</strong></label>
          <!-- one division space between lecture and slector -->
          <div></div>
          <!-- initalizing selector for selecting the lecture -->
          <select id="lecture" name="lecture" value ="lecture" size="1.2" class ="text-size">
            <option value="Click to select your lecture">Click to select your lecture</option>
            <option value="DevOps">DevOps</option>
            <option value="Cloud Archeitecture">Cloud Archeitecture</option>
            <option value="Cloud Platform Programming">Cloud Platform Programming</option>
            <option value="BlockChain">BlockChain</option>
          </select>
          <div></div>
          <label for="timeslot" style="color:white;"> <strong>Time Slot</strong></label>
          <div></div>
          <!-- initalizing selector for selecting the lecture -->
          <select id="timeslot" name="timeslot" value ="timeslot" size="1.2" class ="text-size">
            <option value="click to select your slot">click to select your slot</option>
            <option value="12:00 - 01:00">12:00 - 01:00</option>
            <option value="01:00 - 02:00">01:00 - 02:00</option>
            <option value="02:00 - 03:00">02:00 - 03:00</option>
          </select>
          <!-- initalizing submit button to complete the booking insert operation -->
          <input type="submit" style="font-weight: bold;" Lecturevalue="Submit" class ="text-size">
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
