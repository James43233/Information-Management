<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "db_pos_inventory";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user data
$user_result = $conn->query("SELECT User_ID, User_name FROM user_employee");
if (!$user_result) {
    die("Error fetching user data: " . $conn->error);
}

// Fetch customer data
$customer_result = $conn->query("SELECT Customer_ID, Customer_name FROM customer");
if (!$customer_result) {
    die("Error fetching customer data: " . $conn->error);
}

// Fetch merchant data
$merchant_result = $conn->query("SELECT Merchant_ID, Merchant_name FROM merchant");
if (!$merchant_result) {
    die("Error fetching merchant data: " . $conn->error);
}

// Handle updating sales record with null values
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_sale'])) {
    $sale_id = intval($_POST['sale_id']);
    $user_id = intval($_POST['user_id']);
    $customer_id = intval($_POST['customer_id']);
    $payment_type = $_POST['payment_type'];
    $date = $_POST['date'];
    $merchant_id = isset($_POST['merchant_id']) ? intval($_POST['merchant_id']) : null;
    $ref_num = isset($_POST['ref_num']) ? $_POST['ref_num'] : null;

    // Calculate total amount from sales_details
    $total_amount_result = $conn->query("SELECT SUM(Sub_total) as total_amount FROM sale_details WHERE Sale_ID = $sale_id");
    if ($total_amount_result) {
        $total_amount_row = $total_amount_result->fetch_assoc();
        $total_amount = $total_amount_row['total_amount'];
    } else {
        $total_amount = 0;
    }

    $update_sale = $conn->prepare("UPDATE sale SET User_id = ?, Customer_id = ?, total_amount = ?, payment_type = ?, date = ? WHERE Sale_ID = ?");
    if ($update_sale === false) {
        die("Error preparing statement: " . $conn->error);
    }
    $update_sale->bind_param("iidssi", $user_id, $customer_id, $total_amount, $payment_type, $date, $sale_id);

    if ($update_sale->execute()) {
        echo "<script>alert('Sale updated successfully!');</script>";
    } else {
        echo "<script>alert('Error updating sale: " . $update_sale->error . "');</script>";
    }
    $update_sale->close();

    // Update mode_payment table if payment_type is E-Payment
    if ($payment_type === 'e-payment' && $merchant_id !== null && $ref_num !== null) {
        $update_mode_payment = $conn->prepare("REPLACE INTO mode_payment (Sale_ID, Merchant_ID, Ref_num) VALUES (?, ?, ?)");
        if ($update_mode_payment === false) {
            die("Error preparing mode_payment statement: " . $conn->error);
        }
        $update_mode_payment->bind_param("iis", $sale_id, $merchant_id, $ref_num);

        if ($update_mode_payment->execute()) {
            echo "<script>alert('Mode payment updated successfully!');</script>";
        } else {
            echo "<script>alert('Error updating mode payment: " . $update_mode_payment->error . "');</script>";
        }
        $update_mode_payment->close();
    }
}

// Fetch sales data
$sales = $conn->query("SELECT s.Sale_ID, u.User_name, c.Customer_name, s.total_amount, s.payment_type, s.date, s.User_id, s.Customer_id 
                       FROM sale s 
                       LEFT JOIN user_employee u ON s.User_id = u.User_ID 
                       LEFT JOIN customer c ON s.Customer_id = c.Customer_ID");
if (!$sales) {
    die("Error fetching sales data: " . $conn->error);
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

    <div class="w-[1200px] mx-auto bg-whiteshell min-h-screen flex justify-evenly">
        <div class="flex flex-row w-full">
            <div class="flex flex-col w-[350px] h-screen  border-r-2 border-black ">
                <form method="POST" action="">
                    <div class="grid grid-cols-1 gap-y-4 w-[240px] mx-auto mt-[20px]">
                        <div class="flex flex-col items-start mt-[20px]">
                            <span class="font-sigmar mb-2 text-lg mr-[20px]">Sale ID : </span>
                            <input class="w-full max-w-[300px] py-2 text-left border border-gray-300 rounded-sm text-black placeholder-black font-serif" 
                                type="text" name="sale_id" value="<?php echo isset($_POST['sale_id']) ? $_POST['sale_id'] : ''; ?>" placeholder="">
                        </div>
                        <!-- User -->
                        <div class="flex flex-col items-start">
                            <span class="font-sigmar mb-2 text-lg">User</span>
                            <select class="w-full max-w-[300px] py-2 text-center border border-gray-300 rounded-sm text-black font-serif" name="user_id">
                                <option value="">Select User</option>
                                <?php while ($user = $user_result->fetch_assoc()): ?>
                                    <option value="<?php echo $user['User_ID']; ?>"><?php echo $user['User_name']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <!-- Customer -->
                        <div class="flex flex-col items-start">
                            <span class="font-sigmar mb-2 text-lg">Customer</span>
                            <select class="w-full max-w-[300px] py-2 text-center border border-gray-300 rounded-sm text-black font-serif" name="customer_id">
                                <option value="">Select Customer</option>
                                <?php while ($customer = $customer_result->fetch_assoc()): ?>
                                    <option value="<?php echo $customer['Customer_ID']; ?>"><?php echo $customer['Customer_name']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <!-- Payment Type -->
                        <div class="flex flex-col items-start">
                            <span class="font-sigmar mb-2 text-lg">Payment Type</span>
                            <select class="w-full max-w-[300px] py-2 text-center border border-gray-300 rounded-sm text-black font-serif" name="payment_type" id="payment_type" onchange="togglePaymentFields()">
                                <option value="cash">Cash on Delivery</option>
                                <option value="e-payment">E-Payment</option>
                            </select>
                        </div>
                        <!-- E-Payment Fields -->
                        <div id="e-payment-fields" style="display: none;">
                            <div class="flex flex-col items-start">
                                <span class="font-sigmar mb-2 text-lg">Merchant</span>
                                <select class="w-full max-w-[300px] py-2 text-center border border-gray-300 rounded-sm text-black font-serif" name="merchant_id">
                                    <option value="">Select Merchant</option>
                                    <?php while ($merchant = $merchant_result->fetch_assoc()): ?>
                                        <option value="<?php echo $merchant['Merchant_ID']; ?>"><?php echo $merchant['Merchant_name']; ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="flex flex-col items-start">
                                <span class="font-sigmar mb-2 text-lg">Reference Number</span>
                                <input class="w-full max-w-[300px] py-2 text-center border border-gray-300 rounded-sm text-black font-serif" 
                                       type="text" name="ref_num" placeholder="">
                            </div>
                        </div>
                        <!-- Date -->
                        <div class="flex flex-col items-start">
                            <span class="font-sigmar mb-2 text-lg">Date</span>
                            <input class="w-full max-w-[300px] py-2 text-center border border-gray-300 rounded-sm text-black font-serif" 
                                   type="date" name="date" value="<?php echo date('Y-m-d'); ?>">
                        </div>
                        <div class="flex flex-col items-start mt-[20px]">
                            <button type="submit" name="update_sale" class="w-full bg-green-700 text-white py-2 rounded">Update</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="flex w-full h-screen bg-whiteshell flex-col">
                <div class="mt-[20px] border-black w-full">
                        <div class="mb-[10px] flex items-center justify-center">
                            <button class="flex items-center bg-Black border border-gray-300 rounded-full px-4 py-2 shadow-sm hover:shadow-md focus-within:ring-2 focus-within:ring-green-700">
                                <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search..." class="w-[700px] outline-none bg-transparent text-black placeholder-black font-serif">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-gray-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1118 10.5a7.5 7.5 0 011-1.35z"></path>
                                </svg>
                            </button>
                        </div>
                </div>
                <div class="mt-[20px] mx-auto w-[900px]">
                    <table class="bg-white p-8 rounded shadow-md max-w-4xl w-full" id="salesTable">
                       <h1 class="text-2xl font-bold mb-4">Sales</h1>
                      <thead>
                        <tr class="bg-White">
                          <th class="border p-2">Sale ID</th>
                          <th class="border p-2">User</th>
                          <th class="border p-2">Customer</th>
                          <th class="border p-2">Total Amount</th>
                          <th class="border p-2">Payment Type</th>
                          <th class="border p-2">Date</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php while ($sale = $sales->fetch_assoc()): ?>
                          <tr class="hover:bg-gray-200 cursor-pointer font-rubik" onclick="populateFields(<?php echo htmlspecialchars(json_encode($sale)); ?>)">
                            <td class="border p-2"> <?php echo $sale['Sale_ID']; ?> </td>
                            <td class="border p-2"> <?php echo $sale['User_name'] ?: 'N/A'; ?> </td>
                            <td class="border p-2"> <?php echo $sale['Customer_name'] ?: 'N/A'; ?> </td>
                            <td class="border p-2"> <?php echo $sale['total_amount'] ?: 'N/A'; ?> </td>
                            <td class="border p-2"> <?php echo $sale['payment_type'] ?: 'N/A'; ?> </td>
                            <td class="border p-2"> <?php echo $sale['date'] ?: 'N/A'; ?> </td>
                          </tr>
                        <?php endwhile; ?>
                      </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <script>
    function populateFields(sale) {
        document.querySelector("input[name='sale_id']").value = sale.Sale_ID || '';
        document.querySelector("select[name='user_id']").value = sale.User_id || '';
        document.querySelector("select[name='customer_id']").value = sale.Customer_id || '';
        document.querySelector("input[name='total_amount']").value = sale.total_amount || '';
        document.querySelector("select[name='payment_type']").value = sale.payment_type || '';
        document.querySelector("input[name='date']").value = sale.date || '';

        // Show or hide e-payment fields based on payment type
        togglePaymentFields();
    }

    function togglePaymentFields() {
        const paymentType = document.getElementById('payment_type').value;
        const ePaymentFields = document.getElementById('e-payment-fields');
        
        if (paymentType === 'e-payment') {
            ePaymentFields.style.display = 'block';
        } else {
            ePaymentFields.style.display = 'none';
        }
    }

    document.getElementById('payment_type').addEventListener('change', togglePaymentFields);

    function searchTable() {
        const input = document.getElementById('searchInput');
        const filter = input.value.toLowerCase();
        const table = document.getElementById('salesTable');
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