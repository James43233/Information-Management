<?php
session_start();
include 'database.php';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Construct the SQL query (note: this is vulnerable to SQL injection)
    // For production, use prepared statements instead.
    $sql = "SELECT * FROM user_employee WHERE username = '$username' AND password = '$password'";
    
    // Execute the query (corrected method name and added semicolon)
    $result = $conn->query($sql);

    // Check if a matching user is found
    if ($result && $result->num_rows > 0) {
        // Successful login
        $_SESSION['username'] = $username;
        // Redirect or process login success here
        header("Location: index.php");
        exit();
    } else {
        // Invalid credentials
        echo "<script>alert('Invalid username or password!'); window.location.href='Login.php';</script>";
    }
}

$conn->close();
?>

