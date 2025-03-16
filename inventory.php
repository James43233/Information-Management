<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "db_pos_inventory";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$selected_brand = isset($_GET['brand_filter']) ? intval($_GET['brand_filter']) : 0;

// Single main SQL query for products
$sql = "SELECT 
    sd.Product_ID as product_id,
    p.Product_Name as product_name,
    p.Category_ID as category_id,
    c.Category_Name as category_name,
    p.Brand_ID as brand_id,
    b.Brand_Name as brand_name,
    sd.Price as purchase_price,
    p.Selling_Price as selling_price,
    p.Quantity as quantity,  -- Changed from sd.Quantity to p.Quantity
    sp.Date as supply_date,
    sup.Supplier_Name as supplier_name
FROM product p
LEFT JOIN supply_details sd ON p.Product_ID = sd.Product_ID
LEFT JOIN supply sp ON sd.Supply_ID = sp.Supply_ID
LEFT JOIN supplier sup ON sp.Supplier_ID = sup.Supplier_ID
LEFT JOIN category c ON p.Category_ID = c.Category_ID
LEFT JOIN brand b ON p.Brand_ID = b.Brand_ID";

// Add WHERE clause for brand filter
if ($selected_brand > 0) {
    $sql .= " WHERE p.Brand_ID = " . $selected_brand;
}

// Add ordering
$sql .= " ORDER BY 
    CASE WHEN p.Quantity > 0 THEN 0 ELSE 1 END,  -- Changed from sd.Quantity to p.Quantity
    p.Quantity DESC,                              -- Changed from sd.Quantity to p.Quantity
    p.Product_Name";
// Execute main query
$result = $conn->query($sql);
if (!$result) {
    die("Error executing query: " . $conn->error);
}

// Fetch brands for filter
$brands_array = array();
$brands_query = "SELECT Brand_ID, Brand_Name FROM Brand ORDER BY Brand_Name";
$brands_result = $conn->query($brands_query);
if ($brands_result) {
    while ($row = $brands_result->fetch_assoc()) {
        $brands_array[] = $row;
    }
}

// Fetch categories for form (for product update)
$categories_array = array();
$categories_query = "SELECT Category_ID, Category_Name FROM Category ORDER BY Category_Name";
$categories_result = $conn->query($categories_query);
if ($categories_result) {
    while ($row = $categories_result->fetch_assoc()) {
        $categories_array[] = $row;
    }
}

// Handle Product Update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_product'])) {
    $product_id = intval($_POST['product_id']);
    $product_name = htmlspecialchars($_POST['product_name']);
    $category_id = intval($_POST['category']);
    $brand_id = intval($_POST['brand']);
    $purchase_price = floatval($_POST['purchase_price']);
    $selling_price = floatval($_POST['selling_price']);
    $quantity = intval($_POST['quantity']);

    $stmt = $conn->prepare("UPDATE product SET Product_Name = ?, Category_ID = ?, Brand_ID = ?, Purchase_Price = ?, Selling_Price = ?, Quantity = ? WHERE Product_ID = ?");
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }
    $stmt->bind_param("siiiddi", $product_name, $category_id, $brand_id, $purchase_price, $selling_price, $quantity, $product_id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Product updated successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }
    $stmt->close();
}

// Handle Product Void
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['void_product'])) {
    $product_id = intval($_POST['product_id']);
    $admin_password = htmlspecialchars($_POST['admin_password']);

    // Check admin password
    if ($admin_password == "admin123") { // Replace with secure password check
        $stmt = $conn->prepare("DELETE FROM product WHERE Product_ID = ?");
        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }
        $stmt->bind_param("i", $product_id);
        
        if ($stmt->execute()) {
            echo "<script>alert('Product voided successfully!');</script>";
        } else {
            echo "<script>alert('Error: " . $stmt->error . "');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Error: Incorrect admin password.');</script>";
    }
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
  
  <!-- Header Section -->
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
          <a href="Login.html" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Logout</a>
        </div>
      </div>
    </div>
  </div>
  
  <div class="w-[1400px] mx-auto bg-whiteshell h-screen flex">
    <div class="flex flex-row">
        <div class="w-[330px] min-h-screen border-r border-black">
          <div class="pt-[50px] pb-[30px] flex items-center justify-center">
              <span class="text-xl text-center">Inventory System Update</span>
          </div>
          <div class="grid grid-cols-1 gap-y-4 w-full max-w-[240px] mx-auto ">
            
            <div class="flex flex-col items-start ">
              <label class="font-sigmar mb-2 text-lg">Product Name:</label>
              <input id="product_name" class="w-full py-2 text-center border border-gray-300 rounded-sm flex " type="text" placeholder="Product Name">
            </div>
            <div class="flex flex-col items-start">     
              <label>Category:</label>
              <select id="category" class="w-full p-2 border rounded bg-gray-100 text-black">
                <?php foreach ($categories_array as $category) { ?>
                    <option value="<?= $category['Category_ID']; ?>"><?= $category['Category_Name']; ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="flex flex-col items-start">
              <label>Brand:</label>
              <select id="brand" class="w-full p-2 border rounded bg-gray-100 text-black">
                <?php foreach ($brands_array as $brand) { ?>
                    <option value="<?= $brand['Brand_ID']; ?>"><?= $brand['Brand_Name']; ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="flex flex-col items-start">
              <label>Purchase Price:</label>
              <input id="purchase_price" class="w-full py-2 text-center border border-gray-300 rounded-sm flex" type="number" placeholder="Purchase Price">
            </div>
            <div class="flex flex-col items-start"> 
              <label>Selling Price:</label>
               <input id="selling_price" class="w-full py-2 text-center border border-gray-300 rounded-sm flex" type="number" placeholder="Selling Price">
            </div>
            <div class="flex flex-col items-start"> 
              <label>Quantity:</label>
              <input id="quantity" class="w-full py-2 text-center border border-gray-300 rounded-sm flex" type="number" placeholder="Quantity">
            </div>
            <input type="hidden" id="product_id">
            <div class="flex-row flex gap-2">
              <button class="w-full mt-4 p-2 bg-green-700 text-white" onclick="updateProduct()">UPDATE</button>
              <button class="w-full mt-4 p-2 bg-red-700 text-white" onclick="voidProduct()">VOID</button>
            </div>
        
          </div>

        </div>
        
        <div class="flex w-[850px] h-screen bg-whiteshell ">
          <div class="border-l border-black p-4   w-full">
          <div class="mb-[10px] flex items-center justify-center">
            <div class="w-[1000px] ml-[200px] flex items-center justify-center bg-Black border border-gray-300 rounded-full px-4 py-2 shadow-sm hover:shadow-md focus-within:ring-2 focus-within:ring-green-700">
                  <input 
                      type="text" 
                      id="searchInput" 
                      onkeyup="searchTable()" 
                      placeholder="Search..." 
                      class="w-[900px] outline-none bg-transparent text-black placeholder-black font-serif "
                  >
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-gray-500">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1118 10.5a7.5 7.5 0 01-1.35 6.15z"></path>
                  </svg>
              </div>
          </div>

            <table class="bg-white rounded shadow-md  w-[1040px]">
            <!-- Update the form fields section -->
              <div class="flex flex-row justify-between items-center mb-4 w-[1040px]">
                  <h1 class="text-2xl font-bold">Inventory</h1>
                  <div class="flex items-center gap-4">
                      <form method="GET" id="filterForm" class="flex items-center gap-4">
                          <!-- Brand Filter -->
                          <div class="flex items-center gap-2">
                              <label for="brand_filter" class="font-sigmar">Brand:</label>
                              <select name="brand_filter" id="brand_filter" class="p-2 border rounded bg-white" onchange="submitForm()">
                                  <option value="0">All Brands</option>
                                  <?php foreach ($brands_array as $brand) { 
                                      $selected = ($selected_brand == $brand['Brand_ID']) ? 'selected' : '';
                                  ?>
                                      <option value="<?= $brand['Brand_ID'] ?>" <?= $selected ?>>
                                          <?= htmlspecialchars($brand['Brand_Name']) ?>
                                      </option>
                                  <?php } ?>
                              </select>
                          </div>
                      </form>
                  </div>
              </div>
              <thead>
                <tr class="bg-White">
                  <th class="border p-2">ID</th>
                  <th class="border p-2">Name</th>
                  <th class="border p-2">Category</th>
                  <th class="border p-2">Brand</th>
                  <th class="border p-2">Supplier</th>
                  <th class="border p-2">Supply Date</th>
                  <th class="border p-2">Purchase</th>
                  <th class="border p-2">Selling</th>
                  <th class="border p-2">Qty</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()): 
                        $bgColor = ($row['quantity'] == 0) ? 'bg-red-200 hover:bg-red-300' : 'bg-green-200 hover:bg-green-300';
                ?>
                    <tr class="cursor-pointer font-rubik <?php echo $bgColor; ?>" 
                        onclick="populateFields(<?php echo htmlspecialchars(json_encode($row)); ?>)">
                        <td class="border p-2"><?php echo $row['product_id']; ?></td>
                        <td class="border p-2">
                            <?php echo $row['product_name']; ?>
                            <?php if ($row['quantity'] == 0): ?>
                                <span class="text-red-600 ml-2">(Out of Stock)</span>
                            <?php endif; ?>
                        </td>
                        <td class="border p-2"><?php echo $row['category_name']; ?></td>
                        <td class="border p-2"><?php echo $row['brand_name']; ?></td>
                        <td class="border p-2"><?php echo $row['supplier_name']; ?></td>
                        <td class="border p-2"><?php echo date('Y-m-d H:i:s', strtotime($row['supply_date'])); ?></td>
                        <td class="border p-2"><?php echo $row['purchase_price']; ?></td>
                        <td class="border p-2"><?php echo $row['selling_price']; ?></td>
                        <td class="border p-2" <?php echo $row['quantity'] == 0 ? 'class="text-red-600 font-bold"' : ''; ?>>
                            <?php echo $row['quantity']; ?>
                        </td>
                    </tr>
                <?php 
                    endwhile;
                } else {
                ?>
                    <tr>
                        <td colspan="9" class="border p-2 text-center">No products found</td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
            </table>
          </div>
        </div>  
       
      </div>
    </div>
    
    <script>
      function submitForm() {
          document.getElementById('filterForm').submit();
      }

      function populateFields(product) {
          document.getElementById("product_name").value = product.product_name;
          document.getElementById("category").value = product.category_id;
          document.getElementById("brand").value = product.brand_id;
          document.getElementById("purchase_price").value = product.purchase_price;
          document.getElementById("selling_price").value = product.selling_price;
          document.getElementById("quantity").value = product.quantity;
          document.getElementById("product_id").value = product.product_id;
      }

      function updateProduct() {
          var form = document.createElement("form");
          form.method = "POST";
          form.action = "";

          var product_id = document.createElement("input");
          product_id.type = "hidden";
          product_id.name = "product_id";
          product_id.value = document.getElementById("product_id").value;
          form.appendChild(product_id);

          var product_name = document.createElement("input");
          product_name.type = "hidden";
          product_name.name = "product_name";
          product_name.value = document.getElementById("product_name").value;
          form.appendChild(product_name);

          var category = document.createElement("input");
          category.type = "hidden";
          category.name = "category";
          category.value = document.getElementById("category").value;
          form.appendChild(category);

          var brand = document.createElement("input");
          brand.type = "hidden";
          brand.name = "brand";
          brand.value = document.getElementById("brand").value;
          form.appendChild(brand);

          var purchase_price = document.createElement("input");
          purchase_price.type = "hidden";
          purchase_price.name = "purchase_price";
          purchase_price.value = document.getElementById("purchase_price").value;
          form.appendChild(purchase_price);

          var selling_price = document.createElement("input");
          selling_price.type = "hidden";
          selling_price.name = "selling_price";
          selling_price.value = document.getElementById("selling_price").value;
          form.appendChild(selling_price);

          var quantity = document.createElement("input");
          quantity.type = "hidden";
          quantity.name = "quantity";
          quantity.value = document.getElementById("quantity").value;
          form.appendChild(quantity);

          var update_product = document.createElement("input");
          update_product.type = "hidden";
          update_product.name = "update_product";
          update_product.value = "1";
          form.appendChild(update_product);

          document.body.appendChild(form);
          form.submit();
      }

      function voidProduct() {
          var admin_password = prompt("Please enter admin password to void the product:");
          if (admin_password != null) {
              var form = document.createElement("form");
              form.method = "POST";
              form.action = "";

              var product_id = document.createElement("input");
              product_id.type = "hidden";
              product_id.name = "product_id";
              product_id.value = document.getElementById("product_id").value;
              form.appendChild(product_id);

              var admin_password_input = document.createElement("input");
              admin_password_input.type = "hidden";
              admin_password_input.name = "admin_password";
              admin_password_input.value = admin_password;
              form.appendChild(admin_password_input);

              var void_product = document.createElement("input");
              void_product.type = "hidden";
              void_product.name = "void_product";
              void_product.value = "1";
              form.appendChild(void_product);

              document.body.appendChild(form);
              form.submit();
          }
      }
            // Add this to your existing script section
      function searchTable() {
          const input = document.getElementById('searchInput');
          const filter = input.value.toLowerCase();
          const table = document.querySelector('table tbody');
          const rows = table.getElementsByTagName('tr');

          for (let i = 0; i < rows.length; i++) {
              let match = false;
              const cells = rows[i].getElementsByTagName('td');
              
              for (let j = 0; j < cells.length; j++) {
                  const cell = cells[j];
                  if (cell) {
                      const text = cell.textContent || cell.innerText;
                      if (text.toLowerCase().indexOf(filter) > -1) {
                          match = true;
                          break;
                      }
                  }
              }
              
              if (match) {
                  rows[i].style.display = '';
              } else {
                  rows[i].style.display = 'none';
              }
          }
      }
      </script>

</body>
</html>