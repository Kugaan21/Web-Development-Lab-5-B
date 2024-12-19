<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <form  method="post">
        <label for="matric">Matric No:</label>
        <input type="text" id="matric" name="matric" required><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        <button type="submit">Login</button>

        <p><a href = "lab5b_q1.html">Register</a> here if you have not</p>
    </form>
    <?php if (isset($_GET['error'])): ?>
        <p class="error"><?php echo htmlspecialchars($_GET['error']); ?></p>
    <?php endif; ?>

    <?php
  
    // Include the database connection file
    include 'con.php';
    
    // Check if the form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve the username and password from the form
        $matric = $_POST['matric'];
        $password = $_POST['password'];
    
        // Query to check the username and password
        $sql = "SELECT * FROM users WHERE matric = ? AND password = ?";
        $stmt = $conn->prepare($sql);
    
        if ($stmt) {
          
            $stmt->bind_param("ss", $matric, $password);
            $stmt->execute();
            $result = $stmt->get_result();
    
            if ($result->num_rows > 0) {
                // Authentication successful, redirect to display_users.php
                header("Location: display.php");
                exit();
            } else {
                // Authentication failed, redirect back to login.php with an error message
                $error = "Invalid username or password! try login again.";
                header("Location: login.php?error=" . urlencode($error));
                exit();
            }
        } else {
            echo "Error preparing statement: " . $conn->error;
        }
    
        // Close the statement
        $stmt->close();
    }
    
    // Close the connection
    $conn->close();
    ?>
    
</body>
</html>
