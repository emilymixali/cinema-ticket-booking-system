<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <header>
        <h1>Change Password</h1>
    </header>

    <nav>
    
    <a href="index.php">Movies</a>
    <a href="userreservations.php" class="btn btn-custom">My Reservations</a>
    <a href="logout.php"class="btn btn-custom">Logout</a>
    <a href="change_password.php"class="btn btn-custom">Change Password</a>
</nav>

    <main>
    <h2 style="color: rgb(31, 31, 31);">Change Password</h2>
    <form action="change_password_process.php" method="post">
        <div class="input-group">
            <label for="old_password" style="color: rgb(31, 31, 31);">Old Password:</label>
            <input type="password" id="old_password" name="old_password" required>
        </div>
        <div class="input-group">
            <label for="new_password" style="color: rgb(31, 31, 31);">New Password:</label>
            <input type="password" id="new_password" name="new_password" required>
        </div>
        <div class="input-group">
            <label for="confirm_password" style="color: rgb(31, 31, 31);">Confirm New Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
        </div>
        <button type="submit">Change Password</button>
    </form>
</main>


    <footer>
        
    </footer>
</body>
</html>
