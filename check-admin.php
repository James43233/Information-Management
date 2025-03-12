<?php
include 'database.php';

// Get POST data
$data = json_decode(file_get_contents('php://input'), true);
$username = $data['username'];
$password = $data['password'];

// Check if user exists and is admin
$sql = "SELECT * FROM user_employee WHERE username = ? AND password = ? AND Role_ID = 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();

// Send response
header('Content-Type: application/json');
if ($result && $result->num_rows > 0) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}

$stmt->close();
$conn->close();
?>