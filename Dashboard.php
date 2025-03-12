<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "db_pos_inventory";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
$month = date('F', strtotime($date));
$year = date('Y', strtotime($date));

// Fetch deliveries data
$deliveries_sql = "SELECT * FROM total_deliveries_per_month WHERE Month = '$month' AND Year = '$year'";
$deliveries_result = $conn->query($deliveries_sql);
if (!$deliveries_result) {
    die("Error fetching deliveries data: " . $conn->error);
}
$deliveries_data = $deliveries_result->fetch_assoc();

// Fetch sales data
$sales_sql = "SELECT * FROM total_sales_revenue_view WHERE Month = '$month' AND Year = '$year'";
$sales_result = $conn->query($sales_sql);
if (!$sales_result) {
    die("Error fetching sales data: " . $conn->error);
}
$sales_data = $sales_result->fetch_assoc();

// Fetch supplies data
$supplies_sql = "SELECT * FROM total_supplies_cost_per_month WHERE Month = '$month' AND Year = '$year'";
$supplies_result = $conn->query($supplies_sql);
if (!$supplies_result) {
    die("Error fetching supplies data: " . $conn->error);
}
$supplies_data = $supplies_result->fetch_assoc();

// Fetch product statistics
$product_stats_sql = "SELECT * FROM available_products_view";
$product_stats_result = $conn->query($product_stats_sql);
if (!$product_stats_result) {
    die("Error fetching product statistics: " . $conn->error);
}
$product_stats_data = $product_stats_result->fetch_assoc();

// Fetch customer statistics
$customer_stats_sql = "SELECT * FROM total_customers_view";
$customer_stats_result = $conn->query($customer_stats_sql);
if (!$customer_stats_result) {
    die("Error fetching customer statistics: " . $conn->error);
}
$customer_stats_data = $customer_stats_result->fetch_assoc();

$conn->close();
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
<body class="h-screen m-0 flex flex-col justify-center bg-gradient-to-r from-pink-400 via-purple-200 to-indigo-400 font-sigmar">
    <!-- Navbar -->
    <div class="bg-yellow-300 h-[90px] flex">
        <div class="flex items-center h-full font-sigmar text-2xl text-green-900 w-[460px] justify-center">
            <a href="Index.html">Urban Mis<span class="text-rose-400">Fits</span></a>
        </div>
        <div class="flex flex-1 items-center gap-[70px] text-rose-400">
            <a href="sales.php">Point of Sales</a>
            <a href="add_sales.php">Sales</a>
            <a href="Inventory.php">Inventory</a>
            <a href="Dashboard.php">Dashboard</a>
            <a href="Delivery.php">Delivery</a>
            <a href="Product.php">Product</a>
            <div class="relative group">
                <a href="#" class="mb-2 text-lg cursor-pointer">More</a>
                <div class="absolute hidden bg-white shadow-lg rounded-lg group-hover:block">
                    <a href="Customer.php" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Customers</a>
                    <a href="Supply.php" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Supplier</a>
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

    <!-- Main Content -->
    <div class="w-[1400px] mx-auto bg-white h-[1100px] flex flex-col p-8">
        <h1 class="text-4xl font-sigmar text-center text-purple-700 mb-8">Dashboard</h1>

        <form method="GET" class="mb-8">
            <label for="date" class="text-xl">Select Date: </label>
            <input type="date" id="date" name="date" value="<?php echo $date; ?>" class="p-2 border rounded">
            <button type="submit" class="p-2 bg-blue-500 text-white rounded">Filter</button>
        </form>

        <div class="grid grid-cols-3 gap-8">
            <!-- Deliveries -->
            <div class="bg-blue-400 p-6 rounded-lg shadow-lg">
                <h2 class="text-2xl text-white mb-4">Deliveries</h2>
                <p>Total Deliveries: <?php echo isset($deliveries_data['Total_deliveries']) ? $deliveries_data['Total_deliveries'] : 'No data'; ?></p>
            </div>

            <!-- Sales Revenue -->
            <div class="bg-green-400 p-6 rounded-lg shadow-lg">
                <h2 class="text-2xl text-white mb-4">Sales Revenue</h2>
                <p>Total Sales: <?php echo isset($sales_data['Total_Sales']) ? $sales_data['Total_Sales'] : 'No data'; ?>, Total Revenue: $<?php echo isset($sales_data['Total_Revenue']) ? $sales_data['Total_Revenue'] : 'No data'; ?></p>
            </div>

            <!-- Supplies Amount -->
            <div class="bg-red-400 p-6 rounded-lg shadow-lg">
                <h2 class="text-2xl text-white mb-4">Supplies Amount</h2>
                <p>Total Supplies: <?php echo isset($supplies_data['Total_Supplies']) ? $supplies_data['Total_Supplies'] : 'No data'; ?>, Total Amount: $<?php echo isset($supplies_data['Total_Supply_Cost']) ? $supplies_data['Total_Supply_Cost'] : 'No data'; ?></p>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-8 mt-8">
            <!-- Product Statistics -->
            <div class="bg-yellow-400 p-6 rounded-lg shadow-lg">
                <h2 class="text-2xl text-white mb-4">Product Statistics</h2>
                <p>Total Available Products: <?php echo isset($product_stats_data['Total_Available_Products']) ? $product_stats_data['Total_Available_Products'] : 'No data'; ?></p>
            </div>

            <!-- Customer Statistics -->
            <div class="bg-purple-400 p-6 rounded-lg shadow-lg">
                <h2 class="text-2xl text-white mb-4">Customer Statistics</h2>
                <p>Total Customers: <?php echo isset($customer_stats_data['Total_Customers']) ? $customer_stats_data['Total_Customers'] : 'No data'; ?></p>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('date').addEventListener('change', function () {
            this.form.submit(); // Auto-submit form on date change
        });
    </script>
</body>
</html>