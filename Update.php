<?php

//include the config.php the file for establishing database connectivity
include('config.php');
//turn on buffer output
ob_start();
// If form submitted, insert values into the database.
if (!empty($_GET)) {
    $response = array("error" => FALSE);
    $resp = "UPDATE Appointments SET status='approved' WHERE email=:email";
    
    $query_params = array(
        ':email' => $_GET['email']
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
    $email=$_GET['email'];
    echo $email;
    if ($resp) {
        header("Location: Staff_Approval.php");  
    }
}
?>
