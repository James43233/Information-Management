<?php
session_start();
include 'database.php';

$success = false;
$message = ""; // Initialize message to avoid undefined variable error

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize and assign form values
    $full_name = $conn->real_escape_string(trim($_POST['full_name']));
    $contact_number = $conn->real_escape_string(trim($_POST['contact_number']));
    $barangay_id = $conn->real_escape_string(trim($_POST['barangay_id']));
    $street_house_building_no = $conn->real_escape_string(trim($_POST['street_house_building_no']));

    // Insert the address data
    $sql = "INSERT INTO address (Street_House_Building_No, Barangay_ID) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ss", $street_house_building_no, $barangay_id);
        if ($stmt->execute()) {
            $address_id = $stmt->insert_id;
            $stmt->close(); // Close the statement after execution

            // Insert the customer data with the address_id
            $sql = "INSERT INTO customer (Customer_Name, Contact_Number, Address_ID) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("sss", $full_name, $contact_number, $address_id);
                if ($stmt->execute()) {
                    $success = true;
                    $message = "Customer added successfully!";
                } else {
                    $success = false;
                    $message = "Error inserting customer: " . $stmt->error;
                }
                $stmt->close(); // Close the statement after execution
            } else {
                $success = false;
                $message = "Prepare failed: " . $conn->error;
            }
        } else {
            $success = false;
            $message = "Error inserting address: " . $stmt->error;
        }
    } else {
        $success = false;
        $message = "Prepare failed: " . $conn->error;
    }
} else {
    header("Location: customer.php");
    exit();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Process Customer</title>
  <link rel="stylesheet" href="output.css">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
  <div class="p-8 rounded shadow-md max-w-md">
    <?php if ($success): ?>
      <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        <strong class="font-bold">Success!</strong>
        <span class="block sm:inline"><?php echo $message; ?></span>
      </div>
    <?php else: ?>
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
        <strong class="font-bold">Error!</strong>
        <span class="block sm:inline"><?php echo $message; ?></span>
      </div>
    <?php endif; ?>
    <div class="mt-4 text-center">
      <a href="Customer.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Back to Form
      </a>
    </div>
  </div>
</body>
</html>