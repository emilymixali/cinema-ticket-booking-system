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

$fixed_role = "Customer"; 

function registerUser($db, $username, $password, $role) {
    try {
        $stmt = $db->prepare("INSERT INTO users (username, password, role) VALUES (:username, :password, :role)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);

        $stmt->bindParam(':role', $role);
        $stmt->execute();
        return "Successful registration";
    } catch(PDOException $e) {
        return "Registration error: " . $e->getMessage();
    }
}

$login_error = "";


if(isset($_POST['username']) && isset($_POST['password'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    
    $result = registerUser($db, $username, $password, $fixed_role);

   
    if ($result === "Successful registration") {
       
        echo '<div class="alert alert-success" role="alert">';
        echo 'Your registration was successful. <a href="login.php">Click here</a> to log in.';
        echo '</div>';
    } else {
       
        $login_error = $result;
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/stylelogin.css">
</head>
<body>

<div class="error-message">
    <?php echo $login_error; ?>
</div>
<div class="container">
    <div class="screen">
        <div class="screen__content">
            <form class="login" method="POST" action="">
                <div class="login__field">
                    <i class="login__icon fas fa-user"></i>
                    <input type="text" class="login__input" name="username" placeholder="Username">
                </div>
                <div class="login__field">
                    <i class="login__icon fas fa-lock"></i>
                    <input type="password" class="login__input" name="password" placeholder="Password">
                </div>
                <button type="submit" class="button login__submit">
                    <span class="button__text">Sign Up Now</span>
                    <i class="button__icon fas fa-chevron-right"></i>
                </button>                
            </form>
            <div class="social-login">
                <p>Cinema Computers</p>
                <div class="social-icons">
                    <a href="#" class="social-login__icon fab fa-instagram"></a>
                    <a href="#" class="social-login__icon fab fa-facebook"></a>
                    <a href="#" class="social-login__icon fab fa-twitter"></a>
                </div>
            </div>
        </div>
        <div class="screen__background">
            <span class="screen__background__shape screen__background__shape4"></span>
            <span class="screen__background__shape screen__background__shape3"></span>        
            <span class="screen__background__shape screen__background__shape2"></span>
            <span class="screen__background__shape screen__background__shape1"></span>
        </div>      