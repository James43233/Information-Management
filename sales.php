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

// Handle Product Addition to sales_details
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_product'])) {
    $product_id = intval($_POST['product_id']);
    $sale_id = intval($_POST['sale_id']);
    $quantity = intval($_POST['quantity']);
    $price = floatval($_POST['selling_price']);
    $subtotal = $quantity * $price;

    // Check if Sale_ID exists
    $check_sale = $conn->prepare("SELECT Sale_ID FROM sale WHERE Sale_ID = ?");
    $check_sale->bind_param("i", $sale_id);
    $check_sale->execute();
    $check_sale->store_result();

    if ($check_sale->num_rows == 0) {
        // Sale_ID does not exist, create a new sale record
        $insert_sale = $conn->prepare("INSERT INTO sale (total_amount, User_id, Customer_id) VALUES (NULL, NULL, NULL)");
        if ($insert_sale === false) {
            die("Error preparing statement: " . $conn->error);
        }
        if ($insert_sale->execute()) {
            $sale_id = $insert_sale->insert_id;
            echo "<script>alert('New Sale ID created successfully!');</script>";
        } else {
            echo "<script>alert('Error creating new Sale ID: " . $insert_sale->error . "');</script>";
        }
        $insert_sale->close();
    }

    if ($quantity <= 0 || $price <= 0) {
        echo "<script>alert('Error: Quantity and Selling Price must be positive values.');</script>";
    } else {
        // Proceed with inserting into sale_details
        $stmt = $conn->prepare("INSERT INTO sale_details (Product_ID, Sale_ID, Quantity, Selling_Price, Sub_total) VALUES (?, ?, ?, ?, ?)");
        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }
        $stmt->bind_param("iiidd", $product_id, $sale_id, $quantity, $price, $subtotal);

        if ($stmt->execute()) {
            echo "<script>alert('Product added to sale successfully!');</script>";
        } else {
            echo "<script>alert('Error: " . $stmt->error . "');</script>";
        }
        $stmt->close();
    }
    $check_sale->close();
}

// Fetch sales details data
$sale_id = isset($_POST['sale_id']) ? intval($_POST['sale_id']) : 0;
$sales_details = $conn->query("SELECT sd.*, p.Product_Name FROM sale_details sd JOIN product p ON sd.Product_ID = p.Product_ID WHERE sd.Sale_ID = $sale_id");
if (!$sales_details) {
    die("Error fetching data: " . $conn->error);
}

// Fetch products data for the sales form
$products = $conn->query("SELECT Product_ID, Product_Name, Quantity, Selling_Price FROM product");
if (!$products) {
    die("Error fetching data: " . $conn->error);
}

// Fetch products data for the inventory table
$inventory_products = $conn->query("SELECT Product_ID, Product_Name, Quantity, Selling_Price FROM product");
if (!$inventory_products) {
    die("Error fetching data: " . $conn->error);
}
$inventory_products = $conn->query("
    SELECT Product_ID, Product_Name, Quantity, Selling_Price 
    FROM product 
    ORDER BY 
        CASE WHEN Quantity > 0 THEN 0 ELSE 1 END,  
        Quantity DESC,                              
        Product_Name                                
");

if (!$inventory_products) {
    die("Error fetching data: " . $conn->error);
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
        <div class="flex flex-row w-max">
            <div class="flex flex-col w-[600px] h-screen bg-whiteshell border-r-2 border-black">
                <form method="POST" action="">
                    <div class="flex flex-row justify-center items-center mt-[20px]">
                        <span class="font-sigmar mb-2 text-lg mr-[20px]">Sale ID : </span>
                        <input class="w-full max-w-[200px] py-2 text-left border border-gray-300 rounded-sm text-black placeholder-black font-serif" 
                               type="text" name="sale_id" value="<?php echo $sale_id; ?>" placeholder="">
                    </div>
                    <div class="w-[570px] h-[300px] bg-white mt-[20px] mx-auto border border-black overflow-hidden">
                        <h1 class="text-lg font-bold mb-4">Sales Details</h1>
                        <div class="overflow-y-auto h-[250px]">
                            <table class="bg-white p-8 rounded shadow-md w-full" id="salesDetailsTable">
                                <thead>
                                    <tr class="bg-white sticky top-0">
                                        <th class="border p-1">Product Name</th>
                                        <th class="border p-1">Quantity</th>
                                        <th class="border p-1">Selling Price</th>
                                        <th class="border p-1">Total Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $sales_details->fetch_assoc()): ?>
                                    <tr class="hover:bg-gray-200 cursor-pointer" onclick="populateFields(<?php echo htmlspecialchars(json_encode($row)); ?>)">
                                        <td class="border p-1"> <?php echo $row['Product_Name']; ?> </td>
                                        <td class="border p-1"> <?php echo $row['Quantity']; ?> </td>
                                        <td class="border p-1"> <?php echo $row['Selling_Price']; ?> </td>
                                        <td class="border p-1"> <?php echo $row['Sub_total']; ?> </td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="flex justify-evenly gap-2 mt-[20px] w-[570px] mx-auto">
                        <button type="submit" name="delete_product" class="border-2 w-full bg-green-700">
                            Delete
                        </button>
                        <button type="submit" name="add_product" class="border-2 w-full bg-green-700">
                            ADD
                        </button>
                    </div>
                    <div class="grid grid-cols-1 gap-y-4 w-full max-w-[300px] mx-auto mt-[20px]">
                        <!-- Product Name -->
                        <div class="flex flex-col items-start">
                            <span class="font-sigmar mb-2 text-lg">Product Name</span>
                            <select class="w-full max-w-[300px] py-2 text-center border border-gray-300 rounded-sm text-black font-serif" name="product_id">
                                <?php while ($product = $products->fetch_assoc()): ?>
                                    <option value="<?php echo $product['Product_ID']; ?>"><?php echo $product['Product_Name']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <!-- Quantity -->
                        <div class="flex flex-col items-start">
                            <span class="font-sigmar mb-2 text-lg">Quantity</span>
                            <input class="w-full max-w-[300px] py-2 text-center border border-gray-300 rounded-sm text-black font-serif" 
                                   type="number" name="quantity" placeholder="" min="1" step="1">
                        </div>
                        <!-- Selling Price -->
                        <div class="flex flex-col items-start">
                            <span class="font-sigmar mb-2 text-lg">Selling Price</span>
                            <input class="w-full max-w-[300px] py-2 text-center border border-gray-300 rounded-sm text-black font-serif" 
                                   type="number" name="selling_price" placeholder="" min="0.01" step="0.01">
                        </div>
                    </div>
                </form>
            </div>

            <div class="flex w-[650px] h-screen bg-whiteshell flex-col">
                <div class="mt-[20px] border-black w-full">
                    <div class="mb-[10px] flex items-center justify-center">
                        <button class="flex items-center bg-Black border border-gray-300 rounded-full px-4 py-2 shadow-sm hover:shadow-md focus-within:ring-2 focus-within:ring-green-700">
                            <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search..." class="w-[500px] outline-none bg-transparent text-black placeholder-black font-serif">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-gray-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1118 10.5a7.5 7.5 0 011-1.35z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="mt-[20px] mx-auto w-[620px]">
                    <table class="bg-white p-8 rounded shadow-md max-w-4xl w-full" id="inventoryTable">
                       <h1 class="text-2xl font-bold mb-4">Inventory</h1>
                      <thead>
                        <tr class="bg-White">
                          <th class="border p-2">ID</th>
                          <th class="border p-2">Name</th>
                          <th class="border p-2">Quantity</th>
                          <th class="border p-2"> Price</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php while ($product = $inventory_products->fetch_assoc()): ?>
                            <tr class="hover:bg-gray-200 cursor-pointer font-rubik <?php echo ($product['Quantity'] <= 0) ? 'bg-red-200' : ''; ?>" 
                                onclick="populateFields(<?php echo htmlspecialchars(json_encode($product)); ?>)">
                                <td class="border p-2"> <?php echo $product['Product_ID']; ?> </td>
                                <td class="border p-2"> 
                                    <?php echo $product['Product_Name']; ?>
                                    <?php if ($product['Quantity'] <= 0): ?>
                                        <span class="text-red-600 ml-2">(Sold Out)</span>
                                    <?php endif; ?>
                                </td>
                                <td class="border p-2"> <?php echo $product['Quantity']; ?> </td>
                                <td class="border p-2"> <?php echo $product['Selling_Price']; ?> </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <script>
    function populateFields(product) {
        document.querySelector("input[name='sale_id']").value = product.Sale_ID || '';
        document.querySelector("select[name='product_id']").value = product.Product_ID;
        document.querySelector("input[name='quantity']").value = product.Quantity;
        document.querySelector("input[name='selling_price']").value = product.Selling_Price;
    }

    function searchTable() {
        const input = document.getElementById('searchInput');
        const filter = input.value.toLowerCase();
        const table = document.getElementById('inventoryTable');
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