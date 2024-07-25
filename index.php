<?php
session_start();
include('includes/db.php');

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Validate login credentials (for simplicity, using hardcoded values)
    if ($username == 'admin' && $password == 'password') {
        $_SESSION['user'] = $username;
        header('Location: dashboard.php');
    } else {
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <!-- Include Bootstrap CSS from a CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Include the custom style.css file -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="container login-container">
    <h2>Login</h2>
    <!-- Display an error message if there is one -->
    <?php if (isset($error)) { echo "<div class='alert alert-danger'>$error</div>"; } ?>
    <!-- Login form -->
    <form method="POST" action="">
        <!-- Username input field -->
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <!-- Password input field -->
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <!-- Login button -->
        <button type="submit" name="login" class="btn btn-primary">Login</button>
    </form>
</div>
</body>
</html>
