<?php
include "con.php";

// Check if the matric value is passed in the URL
if (isset($_GET['matric'])) {
    $matric = $_GET['matric'];

    // Fetch user details based on matric
    $sql = "SELECT matric, name, role FROM users WHERE matric = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $matric);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User found, get user details
        $user = $result->fetch_assoc();
        $matric = $user['matric'];
        $name = $user['name'];
        $role = $user['role']; // Assuming "role" is stored in "category"
    } else {
        echo "User not found.";
        exit();
    }
} else {
    echo "Invalid request.";
    exit();
}

// Check if the form is submitted to update the details
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate inputs
    $matric = $conn->real_escape_string($_POST['matric']);
    $name = $conn->real_escape_string($_POST['name']);
    $role = $conn->real_escape_string($_POST['role']);

    // Update user details in the database
    $updateSql = "UPDATE users SET matric = ?, name = ?, role = ? WHERE matric = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("ssss", $matric, $name, $role, $matric);

    if ($updateStmt->execute()) {
        echo "User details updated successfully.";
        header("Location: display.php");
                exit();
    } else {
        echo "Error updating user details.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
    
        }
       
        input[type="text"] {
      
            
          
            border: 1px solid #ccc;
        
        }
     
    </style>
</head>
<body>
    <h1>Update User</h1>
    <form action="update_form.php?matric=<?php echo htmlspecialchars($matric); ?>" method="post">
        <label for="matric">Matric:</label>
        <input type="text" id="matric" name="matric" value="<?php echo htmlspecialchars($matric); ?>" required>
        <br><br>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
        <br><br>

        <label for="role">Role:</label>
        <input type="text" id="role" name="role" value="<?php echo htmlspecialchars($role); ?>" required>
        <br><br>

        <button type="submit">Update</button>
        <br><br>

        <a href="display.php" >
            <button type="button" >Cancel</button>
        </a>
    </form>
</body>
</html>
