<?php
include 'con.php';


if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Retrieve the matric value from the POST request
    $matric = $_GET['matric'];



    $sql = "DELETE FROM users WHERE matric = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $matric);
        $result = $stmt->execute();
   
        header("Location: display.php");

        if ($result) {
            return true;
        } else {
            return "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        return "Error: " . $conn->error;
    }
}

    // Close the connection
    $conn->close();
