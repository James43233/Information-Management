<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "db_pos_inventory";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$month = isset($_GET['month']) ? $_GET['month'] : date('Y-m');
$year = date('Y', strtotime($month));
$month_name = date('F', strtotime($month));

// Add this SQL query
$low_stock_sql = "SELECT 
    Product_Name, 
    Quantity 
FROM product 
WHERE Quantity <= 10 
ORDER BY Quantity ASC";

$top_products_sql = "SELECT 
    p.Product_Name,
    COUNT(sd.Product_ID) as sales_count,
    SUM(sd.Sub_total) as total_revenue
FROM sale_details sd
JOIN product p ON sd.Product_ID = p.Product_ID
GROUP BY sd.Product_ID
ORDER BY sales_count DESC
LIMIT 5";

$recent_transactions_sql = "SELECT 
    s.Sale_ID,
    s.Date,
    s.total_amount,
    c.Customer_name
FROM sale s
LEFT JOIN customer c ON s.Customer_id = c.Customer_ID
ORDER BY s.Date DESC
LIMIT 5";

// Add this SQL query
$daily_revenue_sql = "SELECT 
    DATE(Date) as sale_date,
    SUM(total_amount) as daily_total
FROM sale
WHERE MONTH(Date) = MONTH(CURRENT_DATE)
GROUP BY DATE(Date)
ORDER BY sale_date DESC
LIMIT 7";

// Fetch deliveries data
$deliveries_sql = "SELECT * FROM total_deliveries_per_month WHERE Month = '$month_name' AND Year = '$year'";
$deliveries_result = $conn->query($deliveries_sql);
if (!$deliveries_result) {
    die("Error fetching deliveries data: " . $conn->error);
}
$deliveries_data = $deliveries_result->fetch_assoc();

// Fetch sales data
$sales_sql = "SELECT * FROM total_sales_revenue_view WHERE Month = '$month_name' AND Year = '$year'";
$sales_result = $conn->query($sales_sql);
if (!$sales_result) {
    die("Error fetching sales data: " . $conn->error);
}
$sales_data = $sales_result->fetch_assoc();

// Fetch supplies data
$supplies_sql = "SELECT * FROM total_supplies_cost_per_month WHERE Month = '$month_name' AND Year = '$year'";
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

// Fetch low stock alerts
$low_stock_result = $conn->query($low_stock_sql);
if (!$low_stock_result) {
    die("Error fetching low stock data: " . $conn->error);
}

// Fetch top selling products
$top_products_result = $conn->query($top_products_sql);
if (!$top_products_result) {
    die("Error fetching top products data: " . $conn->error);
}

// Fetch recent transactions
$recent_transactions_result = $conn->query($recent_transactions_sql);
if (!$recent_transactions_result) {
    die("Error fetching recent transactions data: " . $conn->error);
}

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
    <div class="bg-yellow-300 h-[120px] flex">
        <div class="flex items-center h-full font-sigmar text-2xl text-green-900 w-[460px] justify-center">
            <a href="Index.html">Urban Mis<span class="text-rose-400">Fits</span></a>
        </div>
        <div class="flex justify-start items-center flex-1 h-full font-sigmar gap-[70px] text-rose-400">
            <a href="sales.php">Point of Sales</a>
            <a href="add_sales.php">Sales</a> 
            <a href="Delivery.php">Delivery</a>
            <a href="Receive_status.php">Delivery Status</a>
            <a href="Inventory.php">Inventory </a>
            <a href="Dashboard.php">Dashboard</a>
            <div class="relative group">
                <a href="#" class="font-sigmar mb-2 text-lg cursor-pointer">More </a>
                <div class="absolute hidden bg-white shadow-lg rounded-lg group-hover:block">
                    <a href="Product.php" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Product</a>
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
    <div class="w-[1400px] mx-auto bg-white h-[1100px] flex flex-col p-8">

        <form method="GET" class="mb-8">
            <label for="month" class="text-xl">Select Month: </label>
            <input type="month" id="month" name="month" value="<?php echo $month; ?>" class="p-2 border rounded">
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
                <p>Total Sales: <?php echo isset($sales_data['Total_Sales']) ? $sales_data['Total_Sales'] : 'No data'; ?>, Total Revenue: <?php echo isset($sales_data['Total_Revenue']) ? $sales_data['Total_Revenue'] : 'No data'; ?></p>
            </div>

            <!-- Supplies Amount -->
            <div class="bg-red-400 p-6 rounded-lg shadow-lg">
                <h2 class="text-2xl text-white mb-4">Supplies Amount</h2>
                <p>Total Supplies: <?php echo isset($supplies_data['Total_Supplies']) ? $supplies_data['Total_Supplies'] : 'No data'; ?>, Total Amount: <?php echo isset($supplies_data['Total_Supply_Cost']) ? $supplies_data['Total_Supply_Cost'] : 'No data'; ?></p>
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
        <div class="grid grid-cols-3 gap-2 mt-8">
            <div class="bg-orange-400 p-4 rounded-lg shadow-lg ">
                <h2 class="text-2xl text-white mb-4">Low Stock Alerts</h2>
                <div class="overflow-y-auto max-h-48">
                    <table class="w-full text-white">
                        <thead>
                            <tr>
                                <th class="text-left">Product</th>
                                <th class="text-right">Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while($row = $low_stock_result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['Product_Name'] . "</td>";
                                echo "<td class='text-right'>" . $row['Quantity'] . "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="bg-teal-400 p-6 rounded-lg shadow-lg ">
                <h2 class="text-2xl text-white mb-4">Top Selling Products</h2>
                <div class="overflow-y-auto max-h-48">
                    <table class="w-full text-white">
                        <thead>
                            <tr>
                                <th class="text-left">Product</th>
                                <th class="text-right">Sales</th>
                                <th class="text-right">Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while($row = $top_products_result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['Product_Name'] . "</td>";
                                echo "<td class='text-right'>" . $row['sales_count'] . "</td>";
                                echo "<td class='text-right'>" . number_format($row['total_revenue'], 2) . "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="bg-indigo-400 p-6 rounded-lg shadow-lg">
                <h2 class="text-2xl text-white mb-4">Recent Transactions</h2>
                <div class="overflow-y-auto max-h-48">
                    <table class="w-full text-white">
                        <thead>
                            <tr>
                                <th class="text-left">Sale ID</th>
                                <th class="text-left">Customer</th>
                                <th class="text-right">Amount</th>
                                <th class="text-right">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while($row = $recent_transactions_result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['Sale_ID'] . "</td>";
                                echo "<td>" . ($row['Customer_name'] ?? 'Walk-in') . "</td>";
                                echo "<td class='text-right'>" . number_format($row['total_amount'], 2) . "</td>";
                                echo "<td class='text-right'>" . date('M d, Y', strtotime($row['Date'])) . "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    
   
    <script>
        document.getElementById('month').addEventListener('change', function () {
            this.form.submit(); // Auto-submit form on month change
        });
    </script>
</body>
</html>