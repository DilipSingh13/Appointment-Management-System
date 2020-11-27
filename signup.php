<?php
//import database config.php file
require('config.php');
//turn on buffer output
ob_start();

// If form submitted, insert values into the database.
if (!empty($_POST)) {
  $response = array("error" => FALSE);
    $email = $_POST['email'];
    
    $query = "INSERT INTO Users (name, email, password, date, role, lecture_name) VALUES (:name, :email, :password, NOW(), :role, :lecture_name)";
    $query_params = array(
        ':name' => $_POST['name'],
        ':email' => $_POST['email'],
        ':password' => hash("sha256",$_POST['password']),
        ':role' => "student",
        ':lecture_name' => "not applicable"
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
            echo 'alert("Registered success");'; 
            echo 'window.location.href = "index.php";';
            echo '</script>';
        }
}
        else{
        ?>
<!DOCTYPE HTML>
<html lang="en" >
<head>
  <title>Sign Up</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="utf-8">
  <!-- binding CSS with HTML -->
  <link rel="stylesheet" type="text/css" href="login_signup_style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href='https://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'>  
  <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
</head>

<body class="body">
  <!-- login page layout division-->
<div>
  <div class="form">
    <form action= "" method="post" role="form">
      <lottie-player src="https://assets4.lottiefiles.com/datafiles/XRVoUu3IX4sGWtiC3MPpFnJvZNq7lVWDCa8LSqgS/profile.json"  background="transparent"  speed="1"  style="justify-content: center;" loop  autoplay></lottie-player>
      <!-- input filled for name -->
      <input type="text" name="name" id="name" placeholder="full name" data-required="true" required/>
      <!-- input filled for email -->
      <input type="email" name="email" id="email" placeholder="email address" data-required="true" data-rule="email" required/>
      <!-- input filled for password -->
      <input type="password" name="password" id="password" placeholder="set a password" data-required="true" required/>
      <!-- Signup button -->
        <button type="submit" value="submit" onclick="validator()">SIGN UP</button>
    </form>
  </div>
</div>
</body>
</html>
<?php }?>
