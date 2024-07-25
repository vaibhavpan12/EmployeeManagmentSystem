<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

include ('includes/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $position = $_POST['position'];

    $profile_picture = $_FILES['profile_picture']['name'];
    $target_dir = "assets/uploads/";
    $target_file = $target_dir . basename($profile_picture);

    move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_file);

    $sql = "INSERT INTO employees (firstname, lastname, email, phone, position, profile_picture)
            VALUES ('$firstname', '$lastname', '$email', '$phone', '$position', '$profile_picture')";

    if ($conn->query($sql) === TRUE) {
        header('Location: dashboard.php');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Employee</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/add_employee_style.css">
</head>
<body>
<div class="container add-employee-container">
    <h2>Add Employee</h2>
    <!-- Display an error or success message if there is one -->
    <?php if (isset($message)) { echo "<div class='alert alert-info'>$message</div>"; } ?>
    <!-- Add employee form -->
    <form method="POST" action="" enctype="multipart/form-data">
        <!-- First Name input field -->
        <div class="form-group">
            <label>First Name</label>
            <input type="text" name="firstname" class="form-control" required>
        </div>
        <!-- Last Name input field -->
        <div class="form-group">
            <label>Last Name</label>
            <input type="text" name="lastname" class="form-control" required>
        </div>
        <!-- Email input field -->
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <!-- Phone input field -->
        <div class="form-group">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control" required>
        </div>
        <!-- Position input field -->
        <div class="form-group">
            <label>Position</label>
            <input type="text" name="position" class="form-control" required>
        </div>
        <!-- Profile Picture upload field -->
        <div class="form-group">
            <label>Profile Picture</label>
            <input type="file" name="profile_picture" class="form-control">
            <!-- Preview area for profile picture -->
            <img id="img-preview" class="img-preview" src="#" alt="Profile Picture" style="display: none;">
        </div>
        <!-- Submit button -->
        <button type="submit" name="add" class="btn btn-primary">Add Employee</button>
    </form>
</div>

<script>
    document.querySelector('input[name="profile_picture"]').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('img-preview');
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src
