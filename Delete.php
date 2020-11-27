<?php
require('config.php');
//turn on buffer output
ob_start();
// If form submitted, insert values into the database.
if (!empty($_GET)) {
    $response = array("error" => FALSE);
    
    $query = "DELETE FROM Appointments WHERE email = :email";
    
    $query_params = array(
        ':email' => $_GET['email']
    );
    
    try {
        $stmt = $db->prepare($query);
        $result = $stmt->execute($query_params);
}

    catch (PDOException $ex) {
        $response["error"] = true;
        $response["message"] = "Database Error. Please Try Again!";
        die(json_encode($response));
    }
    $email=$_GET['email'];
    echo $email;
    if ($result) {
    	header("Location: Staff_Approval.php");  
    }
}
?>
