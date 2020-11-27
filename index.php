<?php
//import database config.php file
require('config.php');
//turn on buffer output
ob_start();
// If form submitted, insert values into the database.
if (!empty($_POST)) {
    $response = array("error" => FALSE);
    $email = $_POST['email'];
    $password=$_POST['password'];
    
    $query = "SELECT * FROM Users WHERE email = :email";
    
    $query_params = array(
        ':email' => $_POST['email']
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
    $row = $stmt->fetch();
    $name=$row['name'];
    $email=$row['email'];
    $role=$row['role'];
    $lecture_name=$row['lecture_name'];
    $hash_password=hash("sha256", $password);
    $check_pass=strcmp($hash_password,$row['password']);
    if ($check_pass==0) {
        $login_ok = 1;
    }
    else{
      echo "Invalid password";
    $login_ok = 0;
    }

    if ($login_ok==1) {
      if($role=="professor") {
        setcookie("email", "$email", time()+30*24*60*60, "/");
        setcookie("name", "$name", time()+30*24*60*60, "/");
        setcookie("lecture", "$lecture_name", time()+30*24*60*60, "/");
        session_start();
        header("Location: Staff_Approval.php"); 
      }
      else if($role=="student") {
        setcookie("email", "$email", time()+30*24*60*60, "/");
        setcookie("name", "$name", time()+30*24*60*60, "/");
        setcookie("lecture", "$lecture_name", time()+30*24*60*60, "/");
        session_start();
        header("Location: Student_Home.php");  
      }
    }
    
  }
else{?>
<!DOCTYPE HTML>
<html lang="en" >
<head>
  <title>Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="utf-8">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href='https://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'>  
  <link href='https://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'> 
  <!-- binding CSS with HTML -->
  <link rel="stylesheet" type="text/css" href="login_signup_style.css">
  <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
  
  <!-- restrict user to go back to previous page logging out -->
  <script type = "text/javascript">
      history.pushState(null, null, location.href);
      history.back(); history.forward();
      window.onpopstate = function () { history.go(1); };
  </script>
</head>

<body class="body">
  <!-- login page layout division-->
<div class="login-page">
  <div class="form">

     <form  method="post" role="form">
      <lottie-player src="https://assets4.lottiefiles.com/datafiles/XRVoUu3IX4sGWtiC3MPpFnJvZNq7lVWDCa8LSqgS/profile.json"  background="transparent"  speed="1"  style="justify-content: center;" loop  autoplay></lottie-player>
      <!-- input filled for email -->
      <input type="email" name="email" id="email" placeholder="&#xf007 email"; data-required="true" required/>
      <!-- input filled for password -->
      <input type="password" name="password" id="password" data-required="true" placeholder="&#xf023;  password" required/>
      <!-- Login button -->
      <button>LOGIN</button>
    </form>
    <!-- Signup button -->
    <form class="login-form">
      <button type="button"onclick="window.location.href='signup.php'">SIGNUP</button>
    </form>
  </div>
</div>
</body>
</html>
<?php }?>
