<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

include('includes/db.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM employees WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        header('Location: dashboard.php');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
