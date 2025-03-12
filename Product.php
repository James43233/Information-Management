<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "db_pos_inventory";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle Product Addition
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_product'])) {
    $product_name = htmlspecialchars($_POST['product_name']);
    $description = htmlspecialchars($_POST['description']);
    $brand_id = intval($_POST['brand']);
    $category_id = intval($_POST['category']);
    $purchase_price = floatval($_POST['purchased_price']);
    $selling_price = floatval($_POST['selling_price']);
    $quantity = intval($_POST['quantity']);

    $stmt = $conn->prepare("INSERT INTO product (Product_Name, Product_Description, Brand_ID, Category_ID, Purchase_Price, Selling_Price, Quantity) VALUES (?, ?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }
    $stmt->bind_param("ssiiidi", $product_name, $description, $brand_id, $category_id, $purchase_price, $selling_price, $quantity);
    
    if ($stmt->execute()) {
        echo "<script>alert('Product added successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }
    $stmt->close();
}

// Handle Supply Addition
// Handle Supply Addition
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_supply'])) {
    $supply_id = intval($_POST['supply_id']);
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['current_stock']); // Use inputted quantity
    $price = floatval($_POST['price']);
    $subtotal = $quantity * $price; // Calculate subtotal dynamically
    $condition_id = intval($_POST['condition']);

    if ($supply_id == 0 || $product_id == 0 || $quantity == 0) {
        die("<script>alert('Error: Supply ID, Product ID, or Quantity is missing.');</script>");
    }

    // Insert into supply_details
    $stmt = $conn->prepare("INSERT INTO supply_details (Supply_ID, Product_ID, Quantity, Price, SubTotal, Condition_ID) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }
    $stmt->bind_param("iiiddi", $supply_id, $product_id, $quantity, $price, $subtotal, $condition_id);

    if ($stmt->execute()) {
        // Update the Total_Cost in the supply table
        $update_total_cost = $conn->prepare("
            UPDATE supply s
            JOIN (
                SELECT Supply_ID, SUM(SubTotal) AS total_cost
                FROM supply_details
                GROUP BY Supply_ID
            ) sd ON s.Supply_ID = sd.Supply_ID
            SET s.Total_Cost = sd.total_cost
            WHERE s.Supply_ID = ?
        ");

        if ($update_total_cost === false) {
            die("Error preparing statement: " . $conn->error);
        }

        $update_total_cost->bind_param("i", $supply_id);
        $update_total_cost->execute();
        $update_total_cost->close();

        echo "<script>alert('Supply added successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}

// Handle Brand Addition
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_brand'])) {
    $brand_name = htmlspecialchars($_POST['brand_name']);
    $description = htmlspecialchars($_POST['brand_description']);

    if (!empty($brand_name)) {
        $stmt = $conn->prepare("INSERT INTO brand (Brand_Name, Description) VALUES (?, ?)");
        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }
        $stmt->bind_param("ss", $brand_name, $description);
        
        if ($stmt->execute()) {
            echo "<script>alert('Brand added successfully!');</script>";
        } else {
            echo "<script>alert('Error: " . $stmt->error . "');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Please fill in all required fields.');</script>";
    }
}

// Handle Category Addition
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_category'])) {
    $category_name = htmlspecialchars($_POST['category_name']);
    $description = !empty($_POST['category_description']) ? htmlspecialchars($_POST['category_description']) : null;

    if (!empty($category_name)) {
        $stmt = $conn->prepare("INSERT INTO category (Category_Name, Description) VALUES (?, ?)");
        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }
        $stmt->bind_param("ss", $category_name, $description);

        if ($stmt->execute()) {
            echo "<script>alert('Category added successfully!');</script>";
        } else {
            echo "<script>alert('Error: " . $stmt->error . "');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Please fill in all required fields.');</script>";
    }
}

// Fetch Data
$brands = $conn->query("SELECT Brand_ID, Brand_Name FROM Brand");
$categories = $conn->query("SELECT Category_ID, Category_Name FROM Category");
$products = $conn->query("SELECT Product_ID, Product_Name, Purchase_Price, Quantity FROM product");
$supply_details = $conn->query("SELECT * FROM supply_details");
$conditions = $conn->query("SELECT * FROM condition_item");

// Fetch products data again for the supply form
$products_for_supply = $conn->query("SELECT Product_ID, Product_Name, Purchase_Price, Quantity FROM product");

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&family=Sigmar&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rubik&display=swap" rel="stylesheet">

    <title>Product & Supply Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="output.css">
    <script>
        function updateProductDetails() {
            let productSelect = document.getElementById("productSelect");
            let selectedOption = productSelect.options[productSelect.selectedIndex];

            if (!selectedOption || selectedOption.value === "") {
                document.getElementById("price").value = "";
                document.getElementById("current_stock").value = "";
                document.getElementById("subtotal").value = "";
                return;
            }

            // Get values from data attributes
            let price = parseFloat(selectedOption.getAttribute("data-price")) || 0;
            let currentStock = parseInt(selectedOption.getAttribute("data-quantity")) || 0;
            
            // Set values in the corresponding fields
            document.getElementById("price").value = price;
            document.getElementById("current_stock").value = currentStock;
            
            // Calculate and set subtotal (price * current_stock)
            let subtotal = price * currentStock;
            document.getElementById("subtotal").value = subtotal.toFixed(2);
        }

        // Initialize the form when the page loads
        document.addEventListener('DOMContentLoaded', function() {
            updateProductDetails();
        });
    </script>
</head>
<body class="h-screen m-0 flex-col justify-center bg-gradient-to-r from-pink-400 via-purple-200 to-indigo-400 ">
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
                 <a href="Login.html" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Logout</a>
              </div>
            </div>  
        </div>
    </div>
    <div class="w-[1200px] bg-whiteshell mx-auto min-h-screen text-center">
    <div class="flex flex-row justify-evenly ">
        <!-- Add Product Section -->
        <div class="w-[48%] mt-[50px]">
            <div class="border-black p-4 bg-white shadow-lg rounded-lg">
                <h2 class="text-2xl mb-4 font-sigmar">Add Product</h2>
                <form method="POST">
                    <div class="grid grid-cols-1 mx-auto w-[350px] gap-4">
                        <input type="hidden" name="add_product" value="1">
                        <div class="flex flex-col">    
                            <label class="font-sigmar text-start">Product Name:</label>
                            <input type="text" name="product_name" required class="w-full p-2 border rounded bg-gray-100 text-black">
                        </div>
                        <div class="flex flex-col">    
                            <label class="font-sigmar text-start">Description:</label>
                            <input type="text" name="description" required class="w-full p-2 border rounded bg-gray-100 text-black">
                        </div>
                        <div class="flex flex-col">      
                            <label class="font-sigmar text-start">Brand:</label>
                            <select name="brand" class="w-full p-2 border rounded bg-gray-100 text-black">
                                <?php while ($row = $brands->fetch_assoc()) { ?>
                                    <option value="<?= $row['Brand_ID']; ?>"><?= $row['Brand_Name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="flex flex-col">    
                            <label class="font-sigmar text-start">Category:</label>
                            <select name="category" class="w-full p-2 border rounded bg-gray-100 text-black">
                                <?php while ($row = $categories->fetch_assoc()) { ?>
                                    <option value="<?= $row['Category_ID']; ?>"><?= $row['Category_Name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="flex flex-col text-start">    
                            <label class="font-sigmar">Purchase Price:</label>
                            <input type="number" name="purchased_price" step="0.01" required class="w-full p-2 border rounded bg-gray-100 text-black">
                        </div>
                        <div class="flex flex-col text-start">    
                            <label class="font-sigmar">Selling Price:</label>
                            <input type="number" name="selling_price" step="0.01" required class="w-full p-2 border rounded bg-gray-100 text-black">
                        </div>
                        <div class="flex flex-col text-start">    
                            <label class="font-sigmar">Quantity:</label>
                            <input type="number" name="quantity" required class="w-full p-2 border rounded bg-gray-100 text-black">
                        </div>
                        <button type="submit" class="w-full mt-4 p-3 bg-green-600 text-white rounded font-sigmar" name="add_product">Add Product</button>
                    </div>
                </form>
            </div>

            <!-- Add Brand Section -->
            <div class="border-black mt-[50px] p-4 bg-white shadow-md rounded-lg ">
                <h2 class="text-xl mb-3 font-sigmar">Add Brand</h2>
                <form method="POST">
                    <div class="grid grid-cols-1 mx-auto w-[350px] gap-4 mt-[20px]">
                        <input type="hidden" name="add_brand" value="1">
                        <div>
                                <label class="font-sigmar text-start">Brand Name:</label>
                                <input type="text" name="brand_name" required class="w-full p-2 border rounded bg-white text-black">
                        </div>
                        <div class="flex flex-col">
                                <label class="font-sigmar text-start">Description (Optional):</label>
                                <input type="text" name="brand_description" class="w-full p-2 border rounded bg-white text-black">
                        </div>
                        <button type="submit" class="w-full mt-3 p-2 bg-blue-500 text-white rounded font-sigmar">Add Brand</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Add Supply Section -->
        <div class="w-[48%] mt-[50px]">
            <div class="border-black p-4 bg-white shadow-lg rounded-lg h-[714px]">
                <h2 class="text-2xl mb-4 font-sigmar">Add Supply</h2>
                <a href="add_supply.php" class="font-sigmar text-lg text-blue-800 rounded">MAKE RECEIPT FIRST!</a>
                <form method="POST">
                    <div class="grid grid-cols-1 mx-auto w-[350px] gap-4 mt-[20px]">
                        <div class="flex flex-col">    
                            <label class="text-black font-sigmar text-start">Supply ID:</label>
                            <input type="number" name="supply_id" required class="w-full p-2 border rounded bg-gray-100 text-black">
                        </div>
                        <div class="flex flex-col">    
                            <label class="text-black font-sigmar text-start">Product:</label>
                            <select id="productSelect" name="product_id" class="w-full p-2 border rounded bg-gray-100 text-black" onchange="updateProductDetails()">
                                <option value="">Select Product</option>
                                <?php while ($row = $products_for_supply->fetch_assoc()) { ?>
                                    <option value="<?= $row['Product_ID']; ?>" 
                                            data-price="<?= $row['Purchase_Price']; ?>"
                                            data-quantity="<?= $row['Quantity']; ?>">
                                        <?= $row['Product_Name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="flex flex-col">    
                            <label class="text-black font-sigmar text-start">Condition:</label>
                            <select name="condition" class="w-full p-2 border rounded bg-gray-100 text-black">
                                <?php while ($row = $conditions->fetch_assoc()) { ?>
                                    <option value="<?= $row['Condition_ID']; ?>">
                                        <?= $row['Condition_Name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="flex flex-col">    
                            <label class="text-black font-sigmar text-start">Current Stock:</label>
                            <input type="number" id="current_stock" name="current_stock" readonly 
                                class="w-full p-2 border rounded bg-gray-100 text-black cursor-not-allowed">
                        </div>
                        <div class="flex flex-col">    
                            <label class="text-black font-sigmar text-start">Price:</label>
                            <input type="number" id="price" name="price" readonly class="w-full p-2 border rounded bg-gray-100 text-black cursor-not-allowed">
                        </div>
                        <div class="flex flex-col">    
                            <label class="text-black font-sigmar text-start">SubTotal:</label>
                            <input type="number" id="subtotal" name="subtotal" readonly class="w-full p-2 border rounded bg-gray-100 text-black cursor-not-allowed">
                        </div>
                        <button type="submit" class="w-full mt-4 p-3 bg-rose-400 text-white rounded font-sigmar" name="add_supply">Add Supply</button>    
                    </div>  
                </form>
            </div>

                 <!-- Add Category Section -->
                <div class="border-black mt-[50px] p-4 bg-white shadow-md rounded-lg">
                    <h2 class="text-xl mb-3 font-sigmar">Add Category</h2>
                    <form method="POST">
                        <div class="grid grid-cols-1 mx-auto w-[350px] gap-4 mt-[20px]">
                            <input type="hidden" name="add_category" value="1">
                            <div class="flex flex-col ">
                                <label class="font-sigmar text-start">Category Name:</label>
                                <input type="text" name="category_name" required class="w-full p-2 border rounded bg-white text-black">
                            </div>
                            <div class="flex flex-col ">
                                <label class="font-sigmar text-start">Description (Optional):</label>
                                <input type="text" name="category_description" class="w-full p-2 border rounded bg-white text-black">
                            </div>
                            <button type="submit" class="w-full mt-3 p-2 bg-blue-500 text-white rounded font-sigmar">Add Category</button>
                        </div>
                    </form>
                </div>
            </div>

           
        </div>
    </div>
</div>

</body>
</html>