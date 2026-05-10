<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    $db = new PDO('mysql:host=localhost;
    dbname=user_db',
     'root',
      '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection error: " . $e->getMessage();
}

try {
    $db_movies = new PDO('mysql:host=localhost;dbname=movies_db', 'root', '');
    $db_movies->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Database connection error with database 'movies_db': " . $e->getMessage();
}


try {
    $db_reservations = new PDO('mysql:host=localhost;dbname=reservations_db', 'root', '');
    $db_reservations->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Database connection error with database 'reservations_db': " . $e->getMessage();
}

$login_error = "";
function loginUser($db, $username, $password) {
    try {
        $stmt = $db->prepare("SELECT password, role FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && $password == $user['password']) {
            
            return array("status" => "Successful login", "role" => $user['role']);
        } else {
            
            return array("status" => "Wrong username or password");
        }
    } catch(PDOException $e) {
        return array("status" => "Connection error: " . $e->getMessage());
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $loginResult = loginUser($db, $username, $password);

    if ($loginResult["status"] === "Successful login") {
        session_start();
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $loginResult["role"];
        
        if ($loginResult["role"] !== 'Employee') {
            header("Location: index.php");
            exit();
        } else {
           
            header("Location: admin.php");
            exit();
        }
    } else {
        $login_error = $loginResult["status"];
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/stylelogin.css">
</head>
<body>
<div class="error-message">
    <?php echo $login_error; ?>
</div>

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
                    <span class="button__text">Log In Now</span>
                    <i class="button__icon fas fa-chevron-right"></i>
                </button>                
            </form>
            <div class="social-login">
     <p>Cinema Computers</p>
     
     <p class="paragraph-spacing">Log in to see our movies and book your tickets </p>
    <p>OR</p>
        <a href="register.php" class="button login__submit sign-up-button">
    <span class="button__text">Sign Up Now</span>
    <i class="button__icon fas fa-chevron-right"></i>
</a>

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
    </div>
</div>
</body>
</html>
