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
    if (!empty($_POST['product_id']) && !empty($_POST['sale_id']) && !empty($_POST['quantity']) && !empty($_POST['selling_price'])) {
        $product_id = intval($_POST['product_id']);
        $sale_id = intval($_POST['sale_id']);
        $quantity = intval($_POST['quantity']);
        $price = floatval($_POST['selling_price']);
        
        // Start transaction
        $conn->begin_transaction();
        
        try {
            // Check if Sale_ID exists
            $check_sale = $conn->prepare("SELECT Sale_ID FROM sale WHERE Sale_ID = ?");
            $check_sale->bind_param("i", $sale_id);
            $check_sale->execute();
            $check_sale->store_result();

            if ($check_sale->num_rows == 0) {
                // Sale_ID does not exist, create a new sale record
                $insert_sale = $conn->prepare("INSERT INTO sale (Sale_ID, total_amount, date) VALUES (?, 0, NOW())");
                if ($insert_sale === false) {
                    throw new Exception("Error preparing sale insert statement");
                }
                $insert_sale->bind_param("i", $sale_id);
                if (!$insert_sale->execute()) {
                    throw new Exception("Error creating new sale record: " . $insert_sale->error);
                }
                $insert_sale->close();
            }
            $check_sale->close();

            // Check if product exists in sale_details
            $check_product = $conn->prepare("SELECT Quantity FROM sale_details WHERE Sale_ID = ? AND Product_ID = ?");
            $check_product->bind_param("ii", $sale_id, $product_id);
            $check_product->execute();
            $check_product->store_result();

            if ($check_product->num_rows > 0) {
                throw new Exception("Product already exists in this sale. Please use update quantity instead.");
            }
            $check_product->close();

            // Check inventory
            $inventory_check = $conn->prepare("SELECT Quantity FROM product WHERE Product_ID = ?");
            $inventory_check->bind_param("i", $product_id);
            $inventory_check->execute();
            $result = $inventory_check->get_result();
            $current_stock = $result->fetch_assoc()['Quantity'];
            
            if ($current_stock < $quantity) {
                throw new Exception("Not enough inventory available!");
            }

            // Update inventory
            $update_inventory = $conn->prepare("UPDATE product SET Quantity = Quantity - ? WHERE Product_ID = ?");
            $update_inventory->bind_param("ii", $quantity, $product_id);
            if (!$update_inventory->execute()) {
                throw new Exception("Error updating inventory");
            }

            // Calculate subtotal
            $subtotal = $quantity * $price;
            
            // Insert into sale_details
            $stmt = $conn->prepare("INSERT INTO sale_details (Product_ID, Sale_ID, Quantity, Selling_Price, Sub_total) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("iiidd", $product_id, $sale_id, $quantity, $price, $subtotal);
            
            if (!$stmt->execute()) {
                throw new Exception("Error adding product to sale");
            }

            // Update total amount in sale table
            $update_total = $conn->prepare("
                UPDATE sale 
                SET total_amount = (
                    SELECT COALESCE(SUM(Sub_total), 0) 
                    FROM sale_details 
                    WHERE Sale_ID = ?
                )
                WHERE Sale_ID = ?
            ");
            $update_total->bind_param("ii", $sale_id, $sale_id);
            if (!$update_total->execute()) {
                throw new Exception("Error updating sale total");
            }

            $conn->commit();
            echo "<script>
                alert('Product added successfully!');
                window.location.href = window.location.href;
            </script>";
            exit();

        } catch (Exception $e) {
            $conn->rollback();
            echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
        }
    } else {
        echo "<script>alert('Error: All fields are required.');</script>";
    }
}


// At the top of your HTML, after session_start()
if (isset($_SESSION['success_message'])) {
    echo "<script>alert('" . $_SESSION['success_message'] . "');</script>";
    unset($_SESSION['success_message']);
}
// Add this after your existing database connection code
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_quantity'])) {
    $product_id = intval($_POST['product_id']);
    $sale_id = intval($_POST['sale_id']);
    $new_quantity = intval($_POST['quantity']);
    $old_quantity = intval($_POST['old_quantity']);
    $selling_price = floatval($_POST['selling_price']);

    // Start transaction
    $conn->begin_transaction();

    try {
        // Get current product quantity from inventory
        $inventory_stmt = $conn->prepare("SELECT Quantity FROM product WHERE Product_ID = ?");
        $inventory_stmt->bind_param("i", $product_id);
        $inventory_stmt->execute();
        $inventory_result = $inventory_stmt->get_result();
        $current_inventory = $inventory_result->fetch_assoc()['Quantity'];

        // Calculate quantity difference
        $quantity_difference = $new_quantity - $old_quantity;

        // Check if we have enough inventory if increasing quantity
        if ($quantity_difference > 0 && $current_inventory < $quantity_difference) {
            throw new Exception("Not enough inventory available!");
        }

        if ($new_quantity <= 0) {
            // Remove from sale_details and return stock to inventory
            $delete_stmt = $conn->prepare("DELETE FROM sale_details WHERE Product_ID = ? AND Sale_ID = ?");
            $delete_stmt->bind_param("ii", $product_id, $sale_id);
            $delete_stmt->execute();

            // Update inventory (return all quantity)
            $update_inventory = $conn->prepare("UPDATE product SET Quantity = Quantity + ? WHERE Product_ID = ?");
            $update_inventory->bind_param("ii", $old_quantity, $product_id);
            $update_inventory->execute();
        } else {
            // Update sale_details quantity and subtotal
            $new_subtotal = $new_quantity * $selling_price;
            $update_stmt = $conn->prepare("UPDATE sale_details SET Quantity = ?, Sub_total = ? WHERE Product_ID = ? AND Sale_ID = ?");
            $update_stmt->bind_param("idii", $new_quantity, $new_subtotal, $product_id, $sale_id);
            $update_stmt->execute();

            // Update inventory
            $update_inventory = $conn->prepare("UPDATE product SET Quantity = Quantity - ? WHERE Product_ID = ?");
            $update_inventory->bind_param("ii", $quantity_difference, $product_id);
            $update_inventory->execute();
        }

        // Update total amount in sale table
        $update_total = $conn->prepare("
            UPDATE sale s 
            SET total_amount = (
                SELECT COALESCE(SUM(Sub_total), 0) 
                FROM sale_details 
                WHERE Sale_ID = ?
            )
            WHERE s.Sale_ID = ?
        ");
        $update_total->bind_param("ii", $sale_id, $sale_id);
        $update_total->execute();

        $conn->commit();
        echo "<script>alert('Quantity updated successfully!');</script>";
        echo "<script>window.location.href = window.location.href;</script>";

    } catch (Exception $e) {
        $conn->rollback();
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }
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
$inventory_products = $conn->query("
    SELECT p.Product_ID, p.Product_Name, p.Quantity, p.Selling_Price, c.Category_Name, b.Brand_Name 
    FROM product p
    LEFT JOIN category c ON p.Category_ID = c.Category_ID
    LEFT JOIN brand b ON p.Brand_ID = b.Brand_ID
    ORDER BY 
        CASE WHEN p.Quantity > 0 THEN 0 ELSE 1 END,  
        p.Quantity DESC,                              
        p.Product_Name                                
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

    <div class="w-[1400px] mx-auto bg-whiteshell min-h-screen flex justify-evenly">
        <div class="flex flex-row w-max">
            <div class="flex flex-col w-[600px] h-screen bg-whiteshell border-r-2 border-black">
                <form method="POST" action="" id="mainForm">
                    <!-- Sale ID input and Enter button -->
                   <div class="flex flex-row justify-center items-center mt-[20px]">
                        <span class="font-sigmar mb-2 text-lg mr-[20px]">Sale ID : </span>
                        <input class="w-full max-w-[200px] py-2 text-left border border-gray-300 rounded-sm text-black placeholder-black font-serif" 
                            type="text" name="sale_id" id="sale_id" 
                            value="<?php echo isset($_GET['sale_id']) ? htmlspecialchars($_GET['sale_id']) : ''; ?>" 
                            placeholder="">
                        <button type="button" 
                                onclick="fetchSaleDetails()" 
                                class="ml-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                            Enter
                        </button>
                    </div>

                    <!-- Sales Details Table -->
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
                                <tbody id="salesDetailsBody">
                                    <!-- Table content will be dynamically populated -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Product Form Fields -->
                    <div class="grid grid-cols-1 gap-y-4 w-full max-w-[300px] mx-auto mt-[20px]">
                        <!-- Hidden fields for update quantity -->
                        <input type="hidden" name="old_quantity" id="old_quantity">
                        
                        <!-- Product Name -->
                        <div class="flex flex-col items-start">
                            <span class="font-sigmar mb-2 text-lg">Product Name</span>
                            <select class="w-full max-w-[300px] py-2 text-center border border-gray-300 rounded-sm text-black font-serif" 
                                    name="product_id" required>
                                <option value="">Select Product</option>
                                <?php 
                                $products->data_seek(0);
                                while ($product = $products->fetch_assoc()): 
                                ?>
                                    <option value="<?php echo $product['Product_ID']; ?>"><?php echo $product['Product_Name']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <!-- Quantity -->
                        <div class="flex flex-col items-start">
                            <span class="font-sigmar mb-2 text-lg">Quantity</span>
                            <input class="w-full max-w-[300px] py-2 text-center border border-gray-300 rounded-sm text-black font-serif" 
                                type="number" name="quantity" value="1" min="1" step="1" required>
                        </div>

                        <!-- Selling Price -->
                        <div class="flex flex-col items-start">
                            <span class="font-sigmar mb-2 text-lg">Selling Price</span>
                            <input class="w-full max-w-[300px] py-2 text-center border border-gray-300 rounded-sm text-black font-serif" 
                                type="number" name="selling_price" min="0.01" step="0.01" required>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-between gap-2 mt-4">
                            <button type="submit" name="update_quantity" class="border-2 w-1/2 bg-blue-700 text-white p-2 rounded">
                                Update
                            </button>
                            <button type="submit" name="add_product" class="border-2 w-1/2 bg-green-700 text-white p-2 rounded" onclick="return validateForm()">
                                Add
                            </button>
                        </div>
                    </div>
                </form>   
            </div> 

            <div class="flex w-[850px] h-screen bg-whiteshell flex-col">
                <div class="mt-[20px] border-black w-full">
                    <div class="mb-[10px] flex items-center justify-center">
                        <button class="flex items-center bg-Black border border-gray-300 rounded-full px-4 py-2 shadow-sm hover:shadow-md focus-within:ring-2 focus-within:ring-green-700">
                            <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search..." class="w-[750px] outline-none bg-transparent text-black placeholder-black font-serif">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-gray-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1118 10.5a7.5 7.5 0 011-1.35z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="mt-[20px] mx-auto w-[800px]">
                    <table class="bg-white p-8 rounded shadow-md max-w-4xl w-full" id="inventoryTable">
                       <h1 class="text-2xl font-bold mb-4">Inventory</h1>
                      <thead>
                        <tr class="bg-White">
                          <th class="border p-2">ID</th>
                          <th class="border p-2">Name</th>
                          <th class="border p-2">Category</th>
                          <th class="border p-2">Brand</th>
                          <th class="border p-2">Quantity</th>
                          <th class="border p-2">Price</th>
                        </tr>
                      </thead>
                        <tbody>
                            <?php while ($product = $inventory_products->fetch_assoc()): ?>
                                <?php 
                                // Determine background color based on quantity
                                $bgColor = ($product['Quantity'] <= 0) 
                                    ? 'bg-red-200 hover:bg-red-300' 
                                    : 'bg-green-200 hover:bg-green-300';
                                ?>
                                <tr class="cursor-pointer font-rubik <?php echo $bgColor; ?>" 
                                    onclick="populateFields(<?php echo htmlspecialchars(json_encode($product)); ?>)">
                                    <td class="border p-2"> <?php echo $product['Product_ID']; ?> </td>
                                    <td class="border p-2"> 
                                        <?php echo $product['Product_Name']; ?>
                                        <?php if ($product['Quantity'] <= 0): ?>
                                            <span class="text-red-600 ml-2">(Sold Out)</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="border p-2"> <?php echo $product['Category_Name']; ?> </td>
                                    <td class="border p-2"> <?php echo $product['Brand_Name']; ?> </td>
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
        // Keep track of current sale_id
        const currentSaleId = document.querySelector("input[name='sale_id']").value;
        
        // Update fields but maintain the current sale_id
        document.querySelector("input[name='sale_id']").value = currentSaleId;
        document.querySelector("select[name='product_id']").value = product.Product_ID;
        document.querySelector("input[name='quantity']").value = "1"; // Set default quantity to 1
        document.querySelector("input[name='selling_price']").value = product.Selling_Price;

        // Optional: Scroll the form into view
        document.querySelector("select[name='product_id']").scrollIntoView({ behavior: 'smooth' });
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
    // Add this function to your existing script section
// Add this function to your existing script section
    function fetchSaleDetails() {
        const saleId = document.getElementById('sale_id').value;
        if (!saleId) {
            alert('Please enter a Sale ID');
            return;
        }

        // Update URL with sale_id without reloading the page
        window.history.replaceState({}, '', `?sale_id=${saleId}`);

        // Create form data
        const formData = new FormData();
        formData.append('sale_id', saleId);

        // Fetch sale details
        fetch('fetch_sale_details.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
                return;
            }
            
            // Clear existing table content
            const tbody = document.getElementById('salesDetailsBody');
            tbody.innerHTML = '';

            // Populate table with new data
            data.forEach(item => {
                const row = document.createElement('tr');
                row.className = 'hover:bg-gray-200';
                row.innerHTML = `
                    <td class="border p-1">${item.Product_Name}</td>
                    <td class="border p-1">
                        <input type="number" 
                            value="${item.Quantity}" 
                            min="0" 
                            class="w-20 p-1 border rounded"
                            onchange="updateQuantity(${item.Product_ID}, ${item.Sale_ID}, this.value, ${item.Quantity}, ${item.Selling_Price})">
                    </td>
                    <td class="border p-1">${item.Selling_Price}</td>
                    <td class="border p-1">${item.Sub_total}</td>
                `;
                tbody.appendChild(row);
            });
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error fetching sale details');
        });
    }

    function updateQuantity(productId, saleId, newQuantity, oldQuantity, sellingPrice) {
        const formData = new FormData();
        formData.append('update_quantity', '1');
        formData.append('product_id', productId);
        formData.append('sale_id', saleId);
        formData.append('quantity', newQuantity);
        formData.append('old_quantity', oldQuantity);
        formData.append('selling_price', sellingPrice);

        fetch(window.location.href, {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(() => {
            // Refresh the sale details
            fetchSaleDetails();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error updating quantity');
        });
    }

    // Add event listener for Enter key on sale_id input
    document.getElementById('sale_id').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            fetchSaleDetails();
        }
    });
    function validateForm() {
        const saleId = document.querySelector("input[name='sale_id']").value;
        const productId = document.querySelector("select[name='product_id']").value;
        const quantity = document.querySelector("input[name='quantity']").value;
        const sellingPrice = document.querySelector("input[name='selling_price']").value;

        if (!saleId) {
            alert('Please enter a Sale ID');
            return false;
        }
        if (!productId) {
            alert('Please select a product');
            return false;
        }
        if (!quantity || quantity <= 0) {
            alert('Please enter a valid quantity');
            return false;
        }
        if (!sellingPrice || sellingPrice <= 0) {
            alert('Please enter a valid selling price');
            return false;
        }
        return true;
    }
    </script>
</body>
</html>