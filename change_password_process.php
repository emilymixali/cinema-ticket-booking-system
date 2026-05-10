<?php

try {
    $db = new PDO('mysql:host=localhost;
    dbname=user_db',
     'root',
      '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection error: " . $e->getMessage();
}


if (!$db) {
    die("Database connection error");
}


session_start();


if (!isset($_SESSION['username'])) {
    
    header("Location: login.php");
    exit();
}


if (isset($_POST['old_password']) && isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

   
$query = "SELECT password FROM users WHERE username = :username";
$stmt = $db->prepare($query);
$stmt->bindParam(':username', $_SESSION['username']);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row) {
    
    $old_password_hash = $row['password'];
    if (password_verify($old_password, $old_password_hash)) {
       
    } else {
       
        echo "The old password is incorrect.";
    }
} else {
    
    echo "User was not found.";
}


  
    if ($new_password === $confirm_password) {
       
        $query = "UPDATE users SET password = :new_password WHERE username = :username";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':new_password', $new_password);
        $stmt->bindParam(':username', $_SESSION['username']);

        if ($stmt->execute()) {
           
            header("Location: profile.php");
            exit();
        } else {
           
            echo "There was an error while updating the password.";
        }
    } else {
        
        echo "The new password and confirmation do not match.";
    }
}
?>
