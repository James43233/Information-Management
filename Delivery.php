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
$customer_result = $conn->query("SELECT Customer_ID, Customer_name, Address_ID FROM customer");
if (!$customer_result) {
    die("Error fetching customer data: " . $conn->error);
}

// Fetch courier data
$courier_result = $conn->query("SELECT Courier_ID, Courier_name FROM courier");
if (!$courier_result) {
    die("Error fetching courier data: " . $conn->error);
}

// Fetch address data
$address_result = $conn->query("SELECT Address_ID, Street_House_Building_No FROM address");
if (!$address_result) {
    die("Error fetching address data: " . $conn->error);
}

// Fetch status data
$status_result = $conn->query("SELECT Status_ID, Title FROM status_type");
if (!$status_result) {
    die("Error fetching status data: " . $conn->error);
}

// Handle adding delivery record
$required_fields = ['sale_id', 'courier_id', 'delivery_fee', 'date', 'status_id'];

// Handle adding delivery record
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_delivery'])) {
    $missing_fields = [];
    
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $missing_fields[] = $field;
        }
    }
    
    if (!empty($missing_fields)) {
        echo "<script>alert('Missing required fields: " . implode(', ', $missing_fields) . "');</script>";
        exit;
    }

    $sale_id = intval($_POST['sale_id']);
    
    // Get the customer's address_id and total_amount from the sale
    $sale_query = $conn->prepare("
        SELECT c.Address_ID, s.Total_Amount 
        FROM sale s 
        JOIN customer c ON s.Customer_id = c.Customer_ID 
        WHERE s.Sale_ID = ?
    ");
    $sale_query->bind_param("i", $sale_id);
    $sale_query->execute();
    $sale_result = $sale_query->get_result();
    $sale_data = $sale_result->fetch_assoc();
    $address_id = $sale_data['Address_ID'];
    $total_amount = $sale_data['Total_Amount'];

    if (!$address_id) {
        echo "<script>alert('No customer address found for this sale!');</script>";
        exit;
    }

    $courier_id = intval($_POST['courier_id']);
    $delivery_fee = floatval($_POST['delivery_fee']);
    $date = $_POST['date'];
    $status_id = intval($_POST['status_id']);
    
    // Calculate overall_total
    $overall_total = $total_amount + $delivery_fee;
    
    // Check if sale_id already exists in delivery table
    $check_delivery = $conn->query("SELECT Sale_ID FROM delivery WHERE Sale_ID = $sale_id");
    if ($check_delivery->num_rows > 0) {
        echo "<script>alert('Delivery record already exists for this Sale ID!');</script>";
        exit;
    }

    // Start transaction
    $conn->begin_transaction();
    
    try {
        // Insert delivery record with overall_total
        $insert_delivery = $conn->prepare("
            INSERT INTO delivery 
            (Sale_ID, Courier_ID, Address_ID, Delivery_fee, Date, Status_ID, Overall_total) 
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        
        if (!$insert_delivery) {
            throw new Exception("Error preparing delivery statement: " . $conn->error);
        }
        
        $insert_delivery->bind_param("iiidssd", 
            $sale_id, 
            $courier_id, 
            $address_id, 
            $delivery_fee, 
            $date, 
            $status_id,
            $overall_total
        );
        
        if (!$insert_delivery->execute()) {
            throw new Exception("Error inserting delivery: " . $insert_delivery->error);
        }
        
        $insert_delivery->close();

        // Commit transaction
        $conn->commit();
        echo "<script>alert('Delivery record added successfully!'); window.location.href = window.location.href;</script>";
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        echo "<script>alert('Error: " . addslashes($e->getMessage()) . "');</script>";
        echo "<div style='color: red; padding: 10px; margin: 10px; border: 1px solid red;'>";
        echo "Error Details: " . $e->getMessage() . "<br>";
        echo "Error File: " . $e->getFile() . "<br>";
        echo "Error Line: " . $e->getLine() . "<br>";
        echo "</div>";
    }
}
// Fetch sales data and sort by date
$sales = $conn->query("SELECT s.Sale_ID, u.User_name, c.Customer_name, s.total_amount, s.payment_type, s.date, 
        s.User_id, MAX(d.Courier_ID) AS Courier_ID, MAX(d.Address_ID) AS Address_ID, MAX(d.Delivery_fee) AS Delivery_fee, 
        MAX(d.Status_ID) AS Status_ID, MAX(d.Tracking_number) AS Tracking_number, MAX(m.merchant_id) AS merchant_id, 
        MAX(m.Ref_num) AS Ref_num,
        c.Address_ID as Customer_Address_ID,
        a.Street_House_Building_No,
        b.Barangay_name,
        GROUP_CONCAT(
            CONCAT_WS(':', 
                p.Product_name,
                sd.Quantity,
                sd.Selling_Price
            ) SEPARATOR '|'
        ) as product_details
    FROM sale s 
    LEFT JOIN user_employee u ON s.User_id = u.User_ID 
    LEFT JOIN customer c ON s.Customer_id = c.Customer_ID
    LEFT JOIN address a ON c.Address_ID = a.Address_ID
    LEFT JOIN barangay b ON a.Barangay_ID = b.Barangay_ID
    LEFT JOIN delivery d ON s.Sale_ID = d.Sale_ID
    LEFT JOIN mode_payment m ON s.Sale_ID = m.Sale_ID
    LEFT JOIN sale_details sd ON s.Sale_ID = sd.Sale_ID
    LEFT JOIN product p ON sd.Product_ID = p.Product_ID
    GROUP BY s.Sale_ID, u.User_name, c.Customer_name, s.total_amount, s.payment_type, s.date, s.User_id, s.Customer_id, 
            c.Address_ID, a.Street_House_Building_No, b.Barangay_name
    ORDER BY s.date DESC");
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
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
        <div class="flex flex-row w-full">
            <div class="flex flex-col w-[350px] min-h-screen border-r-2 border-black ">
            <form method="POST" action="">
                    <div class="grid grid-cols-1 gap-y-4 w-[240px] mx-auto mt-[20px] ">
                        <div class="flex flex-col items-start mt-[20px]">
                            <span class="font-sigmar mb-2 text-lg mr-[20px]">Sale ID : </span>
                            <input class="w-full max-w-[300px] py-2 text-left border border-gray-300 rounded-sm text-black placeholder-black font-serif" 
                                type="text" name="sale_id" value="<?php echo isset($_POST['sale_id']) ? $_POST['sale_id'] : ''; ?>" placeholder="">
                        </div>
                        <!-- Courier -->
                        <div class="flex flex-col items-start">
                            <span class="font-sigmar mb-2 text-lg">Courier</span>
                            <select class="w-full max-w-[300px] py-2 text-center border border-gray-300 rounded-sm text-black font-serif" name="courier_id">
                                <option value="">Select Courier</option>
                                <?php while ($courier = $courier_result->fetch_assoc()): ?>
                                    <option value="<?php echo $courier['Courier_ID']; ?>"><?php echo $courier['Courier_name']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <!-- Address -->
                        <!-- Delivery Fee -->
                        <div class="flex flex-col items-start">
                            <span class="font-sigmar mb-2 text-lg">Delivery Fee</span>
                            <input class="w-full max-w-[300px] py-2 text-center border border-gray-300 rounded-sm text-black font-serif" 
                                   type="text" name="delivery_fee" placeholder="">
                        </div>
                        <!-- Date -->
                        <div class="flex flex-col items-start">
                            <span class="font-sigmar mb-2 text-lg">Date</span>
                            <input class="w-full max-w-[300px] py-2 text-center border border-gray-300 rounded-sm text-black font-serif" 
                                   type="date" name="date" value="<?php echo date('Y-m-d'); ?>">
                        </div>
                        <!-- Status -->
                        <div class="flex flex-col items-start">
                            <span class="font-sigmar mb-2 text-lg">Status</span>
                            <select class="w-full max-w-[300px] py-2 text-center border border-gray-300 rounded-sm text-black font-serif" name="status_id">
                                <option value="">Select Status</option>
                                <?php while ($status = $status_result->fetch_assoc()): ?>
                                    <option value="<?php echo $status['Status_ID']; ?>"><?php echo $status['Title']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="flex flex-col items-start mt-[20px]">
                            <button type="submit" name="add_delivery" class="w-full bg-green-700 text-white py-2 rounded">Add Delivery</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="flex w-full h-screen bg-whiteshell flex-col">
                <div class="mt-[20px] border-black w-full">
                        <div class="mb-[10px] flex items-center justify-center">
                            <button class="flex items-center bg-Black border border-gray-300 rounded-full px-4 py-2 shadow-sm hover:shadow-md focus-within:ring-2 focus-within:ring-green-700">
                                <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search..." class="w-[1000px] outline-none bg-transparent text-black placeholder-black font-serif">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-gray-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1118 10.5a7.5 7.5 0 011-1.35z"></path>
                                </svg>
                            </button>
                        </div>
                </div>
                <div class="mt-[20px] mx-auto w-full ">
                    <div class="flex flex-row justify-end">
                        <div class="w-full">
                            <h1 class="text-2xl font-bold mb-4 ml-[20px]">Sales and Delivery</h1>
                        </div>
                        <div class="w-full flex items-center"> 
                            <button type="button" onclick="sortDeliveries()" class="w-full text-blue-600" id="sortButton">
                                Sort Incomplete Deliveries
                            </button>
                        </div>
                    </div>
                    
                    <table id="salesTable" class="bg-white p-8 rounded shadow-md w-[1100px] font-rubik mx-auto">
                        <thead>
                            <tr class="bg-White">
                                <th class="border p-2">Sale ID</th>
                                <th class="border p-2">User</th>
                                <th class="border p-2">Customer</th>
                                <th class="border p-2">Total Amount</th>
                                <th class="border p-2">Payment Type</th>
                                <th class="border p-2">Date</th>
                                <th class="border p-2">Courier</th>
                                <th class="border p-2">Customer Address</th>
                                <th class="border p-2">Delivery Fee</th>
                                <th class="border p-2">Status</th>
                                <th class="border p-2">Print Receipt</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($sale = $sales->fetch_assoc()): 
                                // Check if any important fields are null
                                $hasNullValues = empty($sale['Courier_ID']) || 
                                                empty($sale['Address_ID']) || 
                                                empty($sale['Delivery_fee']) || 
                                                empty($sale['Status_ID']);
                                                                
                                $rowClass = $hasNullValues ? 'bg-red-200 hover:bg-red-300' : 'bg-green-200 hover:bg-green-300';
                            ?>
                                <tr class="<?php echo $rowClass; ?> cursor-pointer" 
                                    onclick="populateFields(<?php echo htmlspecialchars(json_encode($sale)); ?>)">
                                    <td class="border p-2"> <?php echo $sale['Sale_ID']; ?> </td>
                                    <td class="border p-2"> <?php echo $sale['User_name'] ?: '-'; ?> </td>
                                    <td class="border p-2"> <?php echo $sale['Customer_name'] ?: '-'; ?> </td>
                                    <td class="border p-2"> <?php echo $sale['total_amount'] ?: '-'; ?> </td>
                                    <td class="border p-2"> <?php echo $sale['payment_type'] ?: '-'; ?> </td>
                                    <td class="border p-2"> <?php echo $sale['date'] ?: '-'; ?> </td>
                                    <td class="border p-2"> <?php echo $sale['Courier_ID'] ?: '-'; ?> </td>
                                    <td class="border p-2"> <?php echo $sale['Address_ID'] ?: '-'; ?> </td>
                                    <td class="border p-2"> <?php echo $sale['Delivery_fee'] ?: '-'; ?> </td>
                                    <td class="border p-2"> <?php echo $sale['Status_ID'] ?: '-'; ?> </td>
                                    <td class="border p-2">
                                        <button onclick="printReceipt(<?php echo htmlspecialchars(json_encode($sale)); ?>)" class="bg-blue-500 text-white px-4 py-2 rounded">Print</button>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <script>
    function togglePaymentFields() {
        const paymentType = document.getElementById('payment_type').value;
        const ePaymentFields = document.getElementById('e-payment-fields');
        
        if (paymentType === 'credit') {
            ePaymentFields.style.display = 'block';
        } else {
            ePaymentFields.style.display = 'none';
        }
    }

    function populateFields(sale) {
        document.querySelector("input[name='sale_id']").value = sale.Sale_ID || '';
        document.querySelector("select[name='courier_id']").value = sale.Courier_ID || '';
        document.querySelector("select[name='address_id']").value = sale.Address_ID || '';
        document.querySelector("input[name='delivery_fee']").value = sale.Delivery_fee || '';
        document.querySelector("select[name='status_id']").value = sale.Status_ID || '';
        document.querySelector("input[name='reference_number']").value = sale.Tracking_number || '';
        document.querySelector("input[name='date']").value = sale.date || '';
    }

    function fetchAddresses(customerId) {
        const addressSelect = document.getElementById('address_id');
        addressSelect.innerHTML = '<option value="">Select Address</option>'; // Clear existing options

        if (customerId) {
            fetch(`fetch_addresses.php?customer_id=${customerId}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(address => {
                        const option = document.createElement('option');
                        option.value = address.Address_ID;
                        option.textContent = address.Street_House_Building_No;
                        addressSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching addresses:', error));
        }
    }

    const customerSelect = document.querySelector("select[name='customer_id']");
    if (customerSelect) {
        customerSelect.addEventListener('change', function() {
            fetchAddresses(this.value);
        });
    }

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
    // Add this to your existing <script> section
    let deliverySortState = 'default'; // Track sorting state

    function sortDeliveries() {
        const tbody = document.querySelector('#salesTable tbody');
        const rows = Array.from(tbody.getElementsByTagName('tr'));
        const button = document.getElementById('sortButton');
        
        if (deliverySortState === 'default') {
            // Sort incomplete (red) rows to top
            rows.sort((a, b) => {
                const aHasRed = a.classList.contains('bg-red-200');
                const bHasRed = b.classList.contains('bg-red-200');
                return bHasRed - aHasRed; // Red rows first
            });
            deliverySortState = 'incomplete';
            button.textContent = 'Sort by Date';
        } else {
            // Return to default date-based sorting
            rows.sort((a, b) => {
                const aDate = new Date(a.children[5].textContent.trim()); // Date is in 6th column
                const bDate = new Date(b.children[5].textContent.trim());
                return bDate - aDate; // Most recent first
            });
            deliverySortState = 'default';
            button.textContent = 'Sort Incomplete Deliveries';
        }

        // Remove existing rows
        while (tbody.firstChild) {
            tbody.removeChild(tbody.firstChild);
        }

        // Add sorted rows back
        rows.forEach(row => tbody.appendChild(row));
    }

    // Modify your existing searchTable function to preserve the sort order
    function searchTable() {
        const input = document.getElementById('searchInput');
        const filter = input.value.toLowerCase();
        const tbody = document.querySelector('#salesTable tbody');
        const tr = tbody.getElementsByTagName('tr');

        for (let i = 0; i < tr.length; i++) {
            let td = tr[i].getElementsByTagName('td');
            let match = false;
            for (let j = 0; j < td.length; j++) {
                if (td[j]) {
                    if (td[j].textContent.toLowerCase().indexOf(filter) > -1) {
                        match = true;
                        break;
                    }
                }
            }
            tr[i].style.display = match ? '' : 'none';
        }
    }
    function printReceipt(sale) {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();
            
            // Set font for the header
            doc.setFont("helvetica", "bold");
            doc.setFontSize(24);
            doc.text('Urban MisFits', 105, 20, { align: 'center' });
            
            // Add receipt header
            doc.setFontSize(18);
            doc.text('Sales Receipt', 105, 30, { align: 'center' });
            
            // Add date and time
            doc.setFontSize(10);
            doc.text(`Date Printed: ${new Date().toLocaleString()}`, 20, 40);
            
            // Add receipt content
            doc.setFont("helvetica", "normal");
            doc.setFontSize(12);
            
            // Customer and Sale Information
            doc.text('Sale Information:', 20, 50);
            doc.text(`Sale ID: ${sale.Sale_ID}`, 20, 60);
            doc.text(`Date: ${sale.date || '-'}`, 120, 60);
            doc.text(`Customer: ${sale.Customer_name || '-'}`, 20, 70);
            doc.text(`Cashier: ${sale.User_name || '-'}`, 120, 70);
            
            // Payment Information
            doc.text('Payment Details:', 20, 85);
            doc.text(`Payment Type: ${sale.payment_type || '-'}`, 20, 95);
            doc.text(`Total Amount: ${Math.abs(parseFloat(sale.total_amount || 0)).toFixed(2)}`, 120, 95);
            
            // Delivery Information
            doc.text('Delivery Information:', 20, 110);
            doc.text(`Courier: ${sale.Courier_ID || '-'}`, 20, 120);
            doc.text(`Tracking Number: ${sale.Tracking_number || '-'}`, 120, 120);
            doc.text(`Delivery Fee: ${Math.abs(parseFloat(sale.Delivery_fee || 0)).toFixed(2)}`, 20, 130);
            doc.text(`Status: ${sale.Status_ID || '-'}`, 120, 130);
            
            // Product Details Header
            doc.setFont("helvetica", "bold");
            doc.text('Products:', 20, 145);
            doc.text('Item', 20, 155);
            doc.text('Qty', 120, 155);
            doc.text('Price', 140, 155);
            doc.text('Subtotal', 170, 155);
            
            // Product Details
            doc.setFont("helvetica", "normal");
            let yPos = 165;
            let total = 0;
            
            if (sale.product_details) {
                const products = sale.product_details.split('|');
                products.forEach(product => {
                    const [name, quantity, price] = product.split(':');
                    const subtotal = Math.abs(parseFloat(quantity)) * Math.abs(parseFloat(price));
                    total += subtotal;
                    
                    // Handle long product names
                    const truncatedName = name.length > 40 ? name.substring(0, 37) + '...' : name;
                    
                    doc.text(truncatedName, 20, yPos);
                    doc.text(Math.abs(parseFloat(quantity)).toString(), 120, yPos);
                    doc.text(`${Math.abs(parseFloat(price)).toFixed(2)}`, 140, yPos);
                    doc.text(`${subtotal.toFixed(2)}`, 170, yPos);
                    
                    yPos += 10;
                    
                    // Add new page if needed
                    if (yPos > 270) {
                        doc.addPage();
                        yPos = 20;
                    }
                });
            }
            
            // Add total line
            doc.line(20, yPos, 190, yPos);
            yPos += 10;
            
            // Summary
            doc.setFont("helvetica", "bold");
            doc.text('Summary:', 20, yPos);
            yPos += 10;
            doc.setFont("helvetica", "normal");
            doc.text(`Subtotal: ${total.toFixed(2)}`, 140, yPos);
            yPos += 10;
            doc.text(`Delivery Fee: ${Math.abs(parseFloat(sale.Delivery_fee || 0)).toFixed(2)}`, 140, yPos);
            yPos += 10;
            doc.text(`Total Amount: ${Math.abs(parseFloat(sale.total_amount || 0)).toFixed(2)}`, 140, yPos);
            
            // Footer
            yPos += 20;
            doc.setFontSize(10);
            doc.text('Thank you for shopping at Urban MisFits!', 105, yPos, { align: 'center' });
            
            // Save the PDF
            doc.save(`receipt_${sale.Sale_ID}.pdf`);
        }
    </script>
</body>
</html>