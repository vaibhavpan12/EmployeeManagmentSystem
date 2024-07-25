<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

include ('includes/db.php');
$result = $conn->query("SELECT * FROM employees");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/dashboard_style.css">
</head>

<body>
    <div class="container dashboard-container">
        <div class="dashboard-header">
            <h2>Employee Dashboard</h2>
            <div>
                <a href="add_employee.php" class="btn btn-success">Add Employee</a>
                <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Position</th>
                    <th>Profile Picture</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>

                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['firstname']; ?></td>
                        <td><?php echo $row['lastname']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['phone']; ?></td>
                        <td><?php echo $row['position']; ?></td>
                        <td><img src="assets/uploads/<?php echo $row['profile_picture']; ?>" width="50"></td>
                        <td>
                            <a href="edit_employee.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">Edit</a>
                            <a href="delete_employee.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>

</html>