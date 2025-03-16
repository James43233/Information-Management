<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "db_pos_inventory";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die(json_encode(['error' => "Connection failed: " . $conn->connect_error]));
}

if (isset($_POST['sale_id'])) {
    $sale_id = intval($_POST['sale_id']);
    
    $query = "SELECT sd.*, p.Product_Name 
              FROM sale_details sd 
              JOIN product p ON sd.Product_ID = p.Product_ID 
              WHERE sd.Sale_ID = ?";
              
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $sale_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $details = [];
    while ($row = $result->fetch_assoc()) {
        $details[] = $row;
    }
    
    echo json_encode($details);
} else {
    echo json_encode(['error' => 'No sale ID provided']);
}

$conn->close();
?>