<?php
session_start();
include 'database.php';

// Set timezone and get current date/time
date_default_timezone_set('UTC');
$current_datetime = date('Y-m-d H:i:s');
$current_user = 'James43233';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update_status'])) {
    $sale_id = $_POST['sale_id'];
    $new_status = $_POST['status_type'];
    
    // Get the Status_ID for the new status
    $status_query = $conn->prepare("SELECT Status_ID FROM status_type WHERE Title = ?");
    $status_query->bind_param("s", $new_status);
    $status_query->execute();
    $status_result = $status_query->get_result();
    $status_row = $status_result->fetch_assoc();
    
    if ($status_row) {
        $new_status_id = $status_row['Status_ID'];
        
        // Update the delivery status
        $update_query = $conn->prepare("UPDATE delivery SET Status_ID = ? WHERE Sale_ID = ?");
        $update_query->bind_param("ii", $new_status_id, $sale_id);
        
        if ($update_query->execute()) {
            echo "<script>
                alert('Status updated successfully!');
                window.location.href = window.location.href;
            </script>";
        } else {
            echo "<script>alert('Error updating status!');</script>";
        }
        $update_query->close();
    }
    $status_query->close();
}

// Fetch status types for dropdown
$status_types = [];
$status_result = $conn->query("SELECT Title FROM status_type");
while($row = $status_result->fetch_assoc()) {
    $status_types[] = $row['Title'];
}

// Check if database connection exists
if (!$conn) {
    die("Database connection failed. Please check your database configuration.");
}

// Modified query to join through sales table
try {
    $delivered_items = $conn->query("
        SELECT 
            d.Sale_ID,
            s.Customer_ID,
            c.Customer_name,
            st.Title as status_title,
            s.Total_Amount,
            d.Delivery_Fee,
            (s.Total_Amount + d.Delivery_Fee) as overall_total
        FROM delivery d
        JOIN sale s ON d.Sale_ID = s.Sale_ID
        JOIN customer c ON s.Customer_ID = c.Customer_ID
        JOIN status_type st ON d.Status_ID = st.Status_ID
        WHERE st.Title = 'Delivered'
        ORDER BY d.Sale_ID
    ");

    if (!$delivered_items) {
        throw new Exception("Error executing query: " . $conn->error);
    }

    $totals = $conn->query("
        SELECT 
            s.Sale_ID,
            s.Total_Amount,
            d.Delivery_Fee,
            (s.Total_Amount + d.Delivery_Fee) as overall_total
        FROM sale s
        JOIN delivery d ON s.Sale_ID = d.Sale_ID
    ");

    if (!$totals) {
        throw new Exception("Error executing query: " . $conn->error);
    }
} catch (Exception $e) {
    die("Database error: " . $e->getMessage());
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&family=Sigmar&display=swap" rel="stylesheet">
    <title>Inventory System</title>
    <link rel="stylesheet" href="output.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-screen m-0 flex-col justify-center bg-gradient-to-r from-pink-400 via-purple-200 to-indigo-400 font-sigmar">
    <div class="bg-yellow-300 h-[90px] flex flex-row">
        <div class="flex items-center h-full font-sigmar text-2xl text-green-900 w-[460px] justify-center">
            <a href="Index.html">Urban Mis<span class="text-rose-400">Fits</span></a>
        </div>
        <div class="flex justify-start items-center flex-1 h-full font-sigmar gap-[70px] text-rose-400">
            <a href="sales.php">Point of Sales</a>
            <a href="add_sales.php">Sales</a> 
            <a href="Inventory.php">Inventory </a>
            <a href="Dashboard.php">Dashboard</a>
            <a href="Delivery.php">Delivery</a>
            <a href="Product.php">Product</a>
            <div class="relative group">
                <a href="#" class="font-sigmar mb-2 text-lg cursor-pointer">More </a>
                <div class="absolute hidden bg-white shadow-lg rounded-lg group-hover:block">
                    <a href="Customer.php" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Customers</a>
                    <a href="Supplier.php" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Supplier</a>
                    <a href="Register.php" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Register An Employee</a>
                </div>
            </div>  
        </div>
        <div class="flex justify-center items-center mr-[50px]">
            <div class="relative group">
                <img src="icons/Profile.jpg" alt="Profile" class="w-12 h-12 rounded-full cursor-pointer border border-gray-300 shadow-md">
                <div class="absolute hidden bg-white shadow-lg rounded-lg group-hover:block">
                    <a href="Account.html" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Update</a>
                    <a href="Login.php" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Logout</a>
                </div>
            </div>  
        </div>
    </div>

    <div class="w-[1400px] mx-auto bg-whiteshell min-h-screen flex justify-evenly">
        <div class="flex flex-row w-max justify-evenly">
            <!-- Pending Deliveries Table -->
            <div class="bg-blue-400 w-full p-4">
                <div class="bg-white rounded-lg shadow-md p-4">
                    <h2 class="text-xl font-bold mb-4 text-center">Delivered Items</h2>
                    <table class="w-full" id="deliveryTable">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border p-2 text-left">Sales ID</th>
                                <th class="border p-2 text-left">Customer Name</th>
                                <th class="border p-2 text-left">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if ($delivered_items && $delivered_items->num_rows > 0) {
                                while ($delivery = $delivered_items->fetch_assoc()): 
                            ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="border p-2"><?php echo htmlspecialchars($delivery['Sale_ID']); ?></td>
                                    <td class="border p-2"><?php echo htmlspecialchars($delivery['Customer_name']); ?></td>
                                    <form method="POST" action="">
                                        <td class="border p-2">
                                            <select name="status_type" class="w-full py-2 text-center border border-gray-300 rounded-sm" onchange="this.form.submit()">
                                                <option value="Delivered" <?php echo ($delivery['status_title'] === 'Delivered') ? 'selected' : ''; ?>>Delivered</option>
                                                <option value="Received" <?php echo ($delivery['status_title'] === 'Received') ? 'selected' : ''; ?>>Received</option>
                                            </select>
                                            <input type="hidden" name="sale_id" value="<?php echo htmlspecialchars($delivery['Sale_ID']); ?>">
                                            <input type="hidden" name="update_status" value="1">
                                        </td>
                                    </form>
                                </tr>
                            <?php 
                                endwhile;
                            } else {
                            ?>
                                <tr>
                                    <td colspan="6" class="border p-4 text-center text-gray-500">
                                        No delivered items found
                                    </td>
                                </tr>
                            <?php 
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="bg-red-400 w-full p-4">
                <h2 class="text-xl font-bold mb-4 text-center">Totals</h2>
                <table class="w-full" id="totalsTable">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border p-2 text-left">Sales ID</th>
                            <th class="border p-2 text-left">Total Amount</th>
                            <th class="border p-2 text-left">Delivery Fee</th>
                            <th class="border p-2 text-left">Overall Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if ($totals && $totals->num_rows > 0) {
                            while ($total = $totals->fetch_assoc()): 
                        ?>
                            <tr class="hover:bg-gray-50">
                                <td class="border p-2"><?php echo htmlspecialchars($total['Sale_ID']); ?></td>
                                <td class="border p-2"><?php echo htmlspecialchars($total['Total_Amount']); ?></td>
                                <td class="border p-2"><?php echo htmlspecialchars($total['Delivery_Fee']); ?></td>
                                <td class="border p-2"><?php echo htmlspecialchars($total['overall_total']); ?></td>
                            </tr>
                        <?php 
                            endwhile;
                        } else {
                        ?>
                            <tr>
                                <td colspan="4" class="border p-4 text-center text-gray-500">
                                    No totals found
                                </td>
                            </tr>
                        <?php 
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
    function searchTable() {
        const input = document.getElementById('searchInput');
        const filter = input.value.toLowerCase();
        const table = document.getElementById('deliveryTable');
        const tr = table.getElementsByTagName('tr');

        for (let i = 1; i < tr.length; i++) {
            let td = tr[i].getElementsByTagName('td');
            let match = false;
            for (let j = 0; j < td.length; j++) {
                if (td[j]) {
                    if (td[j].innerText.toLowerCase().indexOf(filter) > -1) {
                        match = true;
                        break;
                    }
                }
            }
            tr[i].style.display = match ? '' : 'none';
        }
    }
    </script>
</body>
</html>