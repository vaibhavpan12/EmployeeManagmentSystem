<?php
// Include the functions file
require 'includes/functions.php';

// Check if 'id' is set in the query string
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = intval($_GET['id']); // Ensure ID is an integer
} else {
    echo "Error: No ID provided.";
    exit;
}

// Fetch employee data based on the ID
$employee = getEmployeeById($id);

if (!$employee) {
    echo "Error: Employee not found.";
    exit;
}

// Handle form submission for updating the employee
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $position = $_POST['position'];

    // Handle file upload if applicable
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
        $fileTmpPath = $_FILES['profile_picture']['tmp_name'];
        $fileName = $_FILES['profile_picture']['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        $allowedExtensions = ['jpg', 'jpeg', 'png'];
        
        if (in_array($fileExtension, $allowedExtensions)) {
            $uploadFileDir = './uploads/';
            $dest_path = $uploadFileDir . $fileName;
            
            // Debugging file upload
            echo "File name: " . $fileName . "<br>";
            echo "Destination path: " . $dest_path . "<br>";
            
            // Delete old file if it exists
            if ($employee['profile_picture'] && file_exists($uploadFileDir . $employee['profile_picture'])) {
                unlink($uploadFileDir . $employee['profile_picture']);
            }
            
            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $profile_picture = $fileName; // Update with new file name
            } else {
                echo "Error uploading file.";
                $profile_picture = $employee['profile_picture']; // Retain old profile picture
            }
        } else {
            echo "Invalid file extension.";
            $profile_picture = $employee['profile_picture']; // Retain old profile picture
        }
    } else {
        $profile_picture = $employee['profile_picture']; // Retain old profile picture if no new file is uploaded
    }

    // Update employee details in the database
    $success = updateEmployee($id, [
        'firstname' => $firstname,
        'lastname' => $lastname,
        'email' => $email,
        'phone' => $phone,
        'position' => $position,
        'profile_picture' => $profile_picture
    ]);

    $message = $success ? "Employee updated successfully." : "Error updating employee.";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Employee</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/edit_employee_style.css">
</head>
<body>
<div class="container edit-employee-container">
    <h2>Edit Employee</h2>
    <?php if (isset($message)) { echo "<div class='alert alert-info'>$message</div>"; } ?>
    <form method="POST" action="" enctype="multipart/form-data">
        <div class="form-group">
            <label>First Name</label>
            <input type="text" name="firstname" class="form-control" value="<?php echo htmlspecialchars($employee['firstname']); ?>" required>
        </div>
        <div class="form-group">
            <label>Last Name</label>
            <input type="text" name="lastname" class="form-control" value="<?php echo htmlspecialchars($employee['lastname']); ?>" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($employee['email']); ?>" required>
        </div>
        <div class="form-group">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($employee['phone']); ?>" required>
        </div>
        <div class="form-group">
            <label>Position</label>
            <input type="text" name="position" class="form-control" value="<?php echo htmlspecialchars($employee['position']); ?>" required>
        </div>
        <div class="form-group">
            <label>Profile Picture</label>
            <input type="file" name="profile_picture" class="form-control">
            <?php if ($employee['profile_picture']) { ?>
                <img src="uploads/<?php echo htmlspecialchars($employee['profile_picture']); ?>" class="img-preview" alt="Profile Picture">

            <?php } ?>
        </div>
        <button type="submit" name="update" class="btn btn-primary">Update Employee</button>
    </form>
</div>
</body>
</html>
