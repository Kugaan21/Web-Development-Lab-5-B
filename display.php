<?php
// Include the database connection file
include 'con.php';

// Query to fetch data from the users table
$sql = "SELECT matric, name, role FROM users";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users List</title>
    <style>

        table, th, td {
            border: 1px solid black;
        }
        
       
    </style>
</head>
<body>
    <h1>Users List</h1>
    <?php
    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Matric</th><th>Name</th><th>Access Level</th> <th>Update</th><th>Delete</th></tr>";
        // Output data for each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . ($row['matric']) . "</td>";
            echo "<td>" . ($row['name']) . "</td>";
            echo "<td>" . ($row['role']) . "</td>";
            echo "<td>" . '<a href="update_form.php?matric=' . htmlspecialchars($row["matric"]) . '">Update</a>' . "</td>"; 
            echo "<td>" . '<a href="delete.php?matric=' . htmlspecialchars($row["matric"]) . '">Delete</a>' . "</td>";         
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No users found in the database.</p>";
    }
    // Close the database connection
    $conn->close();
    ?>
</body>
</html>
