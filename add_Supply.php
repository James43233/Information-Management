<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "db_pos_inventory";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch users from the User_employee table
$user_query = "SELECT User_ID, User_name FROM User_employee"; 
$user_result = $conn->query($user_query);

// Fetch suppliers from the supplier table
$supplier_query = "SELECT Supplier_ID, Supplier_Name FROM supplier"; 
$supplier_result = $conn->query($supplier_query);

if (!$user_result || !$supplier_result) {
    die("Query failed: " . $conn->error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $supply_id = isset($_POST['supply_id']) ? $_POST['supply_id'] : null;
    $user_id = $_POST['user_id'];
    $supplier_id = $_POST['supplier_id'];
    $receipt_number = $_POST['receipt_number'];
    $date = $_POST['date'];

    // Validate input (Ensure no empty values)
    if (empty($supply_id) || empty($user_id) || empty($supplier_id) || empty($receipt_number) || empty($date)) {
        die("Error: All fields are required.");
    }

    // Insert into `supply` table
    $query = "INSERT INTO supply (Supply_ID, User_ID, Supplier_ID, Receipt_Number, Date) 
              VALUES (?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($query);
    
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("iiiss", $supply_id, $user_id, $supplier_id, $receipt_number, $date);

    // Execute the query
    if ($stmt->execute()) {
        echo "<script>alert('Supply record added successfully!'); window.location.href='add_Supply.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Supply</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="output.css">
</head>
<body class="h-screen m-0 flex items-center justify-center bg-gradient-to-r from-pink-400 via-purple-200 to-indigo-400 ">

    <div class="bg-yellow-400 p-8 rounded-lg shadow-lg w-[500px]">
        <h2 class="text-2xl font-bold mb-4 text-center font-sigmar">Add Supply</h2>
        
        <form action="add_Supply.php" method="POST" class="space-y-4">

            <!-- Supply ID (Manual Entry) -->
            <label class="block">
                <span class="text-black font-sigmar">Supply ID:</span>
                <input type="text" name="supply_id" required class="w-full p-2 border border-gray-300 rounded-lg">
            </label>

            <!-- User ID (Dynamically Loaded) -->
            <label class="block">
                <span class="text-black font-sigmar">User ID:</span>
                <select name="user_id" required class="w-full p-2 border border-gray-300 rounded-lg">
                    <option value="">Select User</option>
                    <?php while ($row = $user_result->fetch_assoc()): ?>
                        <option value="<?= $row['User_ID'] ?>"><?= htmlspecialchars($row['User_name']) ?></option>
                    <?php endwhile; ?>
                </select>
            </label>

            <!-- Supplier ID (Dynamically Loaded) -->
            <label class="block">
                <span class="text-black font-sigmar">Supplier ID:</span>
                <select name="supplier_id" required class="w-full p-2 border border-gray-300 rounded-lg">
                    <option value="">Select Supplier</option>
                    <?php while ($row = $supplier_result->fetch_assoc()): ?>
                        <option value="<?= $row['Supplier_ID'] ?>"><?= htmlspecialchars($row['Supplier_Name']) ?></option>
                    <?php endwhile; ?>
                </select>
            </label>

            <!-- Receipt Number -->
            <label class="block">
                <span class="text-black font-sigmar">Receipt Number:</span>
                <input type="text" name="receipt_number" required class="w-full p-2 border border-gray-300 rounded-lg">
            </label>

            <!-- Date -->
            <label class="block">
                <span class="text-black font-sigmar">Date:</span>
                <input type="date" name="date" required class="w-full p-2 border border-gray-300 rounded-lg">
            </label>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-blue-500 text-white font-sigmar py-2 rounded-lg hover:bg-blue-600 mb-[20px]">
                Add Supply
            </button>
        </form>
        <a href="Product.php" class="mt-[20px] flex font-sigmar"> Back </a>
    </div>

</body>
</html>