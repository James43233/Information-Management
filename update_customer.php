<?php
session_start();
include 'database.php';

$success = false;
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize input
    $customer_id = isset($_POST['customer_id']) ? intval($_POST['customer_id']) : 0;
    $address_id = isset($_POST['address_id']) && $_POST['address_id'] !== "undefined" ? intval($_POST['address_id']) : 0;
    $full_name = isset($_POST['full_name']) ? $conn->real_escape_string(trim($_POST['full_name'])) : "";
    $contact_number = isset($_POST['contact_number']) ? $conn->real_escape_string(trim($_POST['contact_number'])) : "";
    $barangay_id = isset($_POST['barangay_id']) ? intval($_POST['barangay_id']) : 0;
    $street_house_building_no = isset($_POST['street_house_building_no']) ? $conn->real_escape_string(trim($_POST['street_house_building_no'])) : "";

    // Check if Address_ID exists
    $sql_check_address = "SELECT Address_ID FROM address WHERE Address_ID = ?";
    $stmt_check_address = $conn->prepare($sql_check_address);
    if (!$stmt_check_address) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt_check_address->bind_param("i", $address_id);
    $stmt_check_address->execute();
    $stmt_check_address->store_result();

    if ($stmt_check_address->num_rows == 0) {
        $message .= "Error: Address_ID not found. <br>";
    } else {
        // Update Address
        $sql = "UPDATE address SET 
                    Street_House_Building_No = ?, 
                    Barangay_ID = ? 
                WHERE Address_ID = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("sii", $street_house_building_no, $barangay_id, $address_id);
        if ($stmt->execute()) {
            $message .= ($stmt->affected_rows > 0) ? "Address updated successfully! <br>" : "No changes made to Address. <br>";
            $success = true;
        } else {
            $message .= "Error updating Address: " . $stmt->error . "<br>";
        }
        $stmt->close();
    }
    $stmt_check_address->close();

    // Check if Customer_ID exists
    $sql_check_customer = "SELECT Customer_ID FROM customer WHERE Customer_ID = ?";
    $stmt_check_customer = $conn->prepare($sql_check_customer);
    if (!$stmt_check_customer) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt_check_customer->bind_param("i", $customer_id);
    $stmt_check_customer->execute();
    $stmt_check_customer->store_result();

    if ($stmt_check_customer->num_rows == 0) {
        $message .= "Error: Customer_ID not found. <br>";
    } else {
        // Update Customer
        $sql = "UPDATE customer SET Customer_Name = ?, Contact_Number = ? WHERE Customer_ID = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("ssi", $full_name, $contact_number, $customer_id);
        if ($stmt->execute()) {
            $message .= ($stmt->affected_rows > 0) ? "Customer updated successfully! <br>" : "No changes made to Customer. <br>";
            $success = true;
        } else {
            $message .= "Error updating Customer: " . $stmt->error . "<br>";
        }
        $stmt->close();
    }
    $stmt_check_customer->close();
} else {
    header("Location: Customer.php");
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
    <div class="<?php echo $success ? 'bg-green-100 border border-green-400 text-green-700' : 'bg-red-100 border border-red-400 text-red-700'; ?> px-4 py-3 rounded relative">
      <strong class="font-bold"><?php echo $success ? 'Success!' : 'Error!'; ?></strong>
      <span class="block sm:inline"><?php echo $message; ?></span>
    </div>
    <div class="mt-4 text-center">
      <a href="Customer.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Back to Form
      </a>
    </div>
  </div>
</body>
</html>