<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "db_pos_inventory";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle adding supplier
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_supplier'])) {
    $supplier_name = isset($_POST['supplier_name']) ? $_POST['supplier_name'] : '';
    $contact_number = isset($_POST['contact_number']) ? $_POST['contact_number'] : '';
    $address = isset($_POST['address']) ? $_POST['address'] : '';

    if (!empty($supplier_name) && !empty($contact_number)) {
        $stmt = $conn->prepare("INSERT INTO supplier (Supplier_name, Contact_number, Address) VALUES (?, ?, ?)");
        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }
        $stmt->bind_param("sss", $supplier_name, $contact_number, $address);

        if ($stmt->execute()) {
            echo "<script>alert('Supplier added successfully!');</script>";
        } else {
            echo "<script>alert('Error: " . $stmt->error . "');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Please fill in all required fields.');</script>";
    }
}

// Handle updating supplier
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_supplier'])) {
    $supplier_id = isset($_POST['supplier_id']) ? $_POST['supplier_id'] : '';
    $supplier_name = isset($_POST['supplier_name']) ? $_POST['supplier_name'] : '';
    $contact_number = isset($_POST['contact_number']) ? $_POST['contact_number'] : '';
    $address = isset($_POST['address']) ? $_POST['address'] : '';

    if (!empty($supplier_id) && !empty($supplier_name) && !empty($contact_number)) {
        $stmt = $conn->prepare("UPDATE supplier SET Supplier_name = ?, Contact_number = ?, Address = ? WHERE Supplier_ID = ?");
        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }
        $stmt->bind_param("sssi", $supplier_name, $contact_number, $address, $supplier_id);

        if ($stmt->execute()) {
            echo "<script>alert('Supplier updated successfully!');</script>";
        } else {
            echo "<script>alert('Error: " . $stmt->error . "');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Please fill in all required fields.');</script>";
    }
}

// Handle deleting supplier
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_supplier'])) {
    $supplier_id = isset($_POST['supplier_id']) ? $_POST['supplier_id'] : '';

    if (!empty($supplier_id)) {
        $stmt = $conn->prepare("DELETE FROM supplier WHERE Supplier_ID = ?");
        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }
        $stmt->bind_param("i", $supplier_id);

        if ($stmt->execute()) {
            echo "<script>alert('Supplier deleted successfully!');</script>";
        } else {
            echo "<script>alert('Error: " . $stmt->error . "');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Please provide a supplier ID.');</script>";
    }
}

// Fetch supplier data
$suppliers = $conn->query("SELECT * FROM supplier");
if (!$suppliers) {
    die("Error fetching supplier data: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&family=Sigmar&display=swap" rel="stylesheet">
    <title>Inventory System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="output.css">
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
                    <a href="Login.html" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Logout</a>
                </div>
            </div>  
        </div>
    </div>
    <div class="w-[1000px] bg-whiteshell mx-auto min-h-screen text-center">
        <div class="flex flex-row">
            <div class="w-[350px] min-h-screen border-r border-black">
                <div class="pt-[50px] pb-[70px]">
                    <span class="text-xl text-center ">Add Supplier</span>
                </div>
                <form method="POST" action="">
                    <div class="grid grid-cols-1 gap-y-4 w-full max-w-[300px] mx-auto">
                        <input type="hidden" name="supplier_id" id="supplier_id">
                        <!-- Supplier Name -->
                        <div class="flex flex-col items-start">
                            <span class="font-sigmar mb-2 text-lg">Supplier Name</span>
                            <input class="w-full max-w-[300px] py-2 text-center border border-gray-300 rounded-sm" 
                                   type="text" name="supplier_name" id="supplier_name" placeholder="FULL NAME" required>
                        </div>
                        <!-- Contact Number -->
                        <div class="flex flex-col items-start">
                            <span class="font-sigmar mb-2 text-lg">Contact Number</span>
                            <input class="w-full max-w-[300px] py-2 text-center border border-gray-300 rounded-sm" 
                                   type="text" name="contact_number" id="contact_number" placeholder="CONTACT NUMBER" required>
                        </div>
                        <!-- Address -->
                        <div class="flex flex-col items-start">
                            <span class="font-sigmar mb-2 text-lg">Address</span>
                            <input class="w-full max-w-[300px] py-2 text-center border border-gray-300 rounded-sm" 
                                   type="text" name="address" id="address" placeholder="Can be Null">
                        </div>
                        <div class="flex flex-row  items-start mt-[20px] gap-2">
                            <button type="submit" name="add_supplier" class="w-full bg-green-700 text-white py-2 rounded">ENTER</button>
                            <button type="submit" name="update_supplier" class="w-full bg-blue-500 text-white py-2 rounded">UPDATE</button>
                            <button type="submit" name="delete_supplier" class="w-full bg-red-700 text-white py-2 rounded">DELETE</button>
                                
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
                <div class="mt-[20px] mx-auto w-[600px]">
                    <h1 class="text-2xl font-bold mb-4">Suppliers</h1>
                    <table class="bg-white p-8 rounded shadow-md max-w-4xl w-full" id="supplierTable">
                      <thead>
                        <tr class="bg-White">
                          <th class="border p-2">Supplier ID</th>
                          <th class="border p-2">Supplier Name</th>
                          <th class="border p-2">Contact Number</th>
                          <th class="border p-2">Address</th>
                        </tr>
                      </thead>
                      <tbody class="font-rubik">
                        <?php while ($supplier = $suppliers->fetch_assoc()): ?>
                          <tr class="hover:bg-gray-200 cursor-pointer" onclick="populateFields(<?php echo htmlspecialchars(json_encode($supplier)); ?>)">
                            <td class="border p-2"> <?php echo $supplier['Supplier_ID']; ?> </td>
                            <td class="border p-2"> <?php echo $supplier['Supplier_Name']; ?> </td>
                            <td class="border p-2"> <?php echo $supplier['Contact_Number']; ?> </td>
                            <td class="border p-2"> <?php echo $supplier['Address'] ?: 'N/A'; ?> </td>
                          </tr>
                        <?php endwhile; ?>
                      </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<script>
function searchTable() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toLowerCase();
    const table = document.getElementById('supplierTable');
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
function populateFields(supplier) {
    console.log(supplier); // Debugging: Check the object structure

    document.getElementById('supplier_id').value = supplier.Supplier_ID ?? ''; 
    document.getElementById('supplier_name').value = supplier.Supplier_Name ?? ''; 
    document.getElementById('contact_number').value = supplier.Contact_Number ?? ''; 
    document.getElementById('address').value = supplier.Address ?? ''; 
}

</script>
</body>
</html>