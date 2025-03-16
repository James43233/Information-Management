<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'database.php';

/*
  1. Retrieve data for each table needed for the cascading dropdowns:
     region -> province -> municipality -> barangay
*/

// --- Regions --- //
$regions = [];
$sqlRegion = "SELECT Region_ID, Region_Name 
              FROM region
              ORDER BY Region_Name ASC";
$resultRegion = $conn->query($sqlRegion);
if ($resultRegion) {
    while ($row = $resultRegion->fetch_assoc()) {
        $regions[] = $row;
    }
    $resultRegion->free();
}

// --- Provinces --- //
$provinces = [];
$sqlProvince = "SELECT Province_ID, Province_Name, Region_ID
                FROM province
                ORDER BY Province_Name ASC";
$resultProvince = $conn->query($sqlProvince);
if ($resultProvince) {
    while ($row = $resultProvince->fetch_assoc()) {
        $provinces[] = $row;
    }
    $resultProvince->free();
}

// --- Municipalities --- //
$municipalities = [];
$sqlMunicipality = "SELECT Municipality_ID, Municipality_Name, Province_ID, Postal_Code
                    FROM municipality
                    ORDER BY Municipality_Name ASC";
$resultMunicipality = $conn->query($sqlMunicipality);
if ($resultMunicipality) {
    while ($row = $resultMunicipality->fetch_assoc()) {
        $municipalities[] = $row;
    }
    $resultMunicipality->free();
}

// --- Barangays --- //
$barangays = [];
$sqlBarangay = "SELECT Barangay_ID, Barangay_Name, Municipality_ID
                FROM barangay
                ORDER BY Barangay_Name ASC";
$resultBarangay = $conn->query($sqlBarangay);
if ($resultBarangay) {
    while ($row = $resultBarangay->fetch_assoc()) {
        $barangays[] = $row;
    }
    $resultBarangay->free();
}

/*
  2. Retrieve the customer list from your view: customer_address_view.
  This view presumably joins customer + address + region/province/municipality/barangay info.
*/
$customers = [];
$sqlCustomers = "
    SELECT 
       c.Customer_ID,
       c.Customer_Name,
       c.Contact_Number,
       a.Address_ID,
       a.Street_House_Building_No,
       r.Region_ID,
       r.Region_Name,
       p.Province_ID,
       p.Province_Name,
       m.Municipality_ID,
       m.Municipality_Name,
       b.Barangay_ID,
       b.Barangay_Name
    FROM customer c
    JOIN address a ON c.Address_ID = a.Address_ID
    JOIN barangay b ON a.Barangay_ID = b.Barangay_ID
    JOIN municipality m ON b.Municipality_ID = m.Municipality_ID
    JOIN province p ON m.Province_ID = p.Province_ID
    JOIN region r ON p.Region_ID = r.Region_ID
    ORDER BY c.Customer_Name ASC
";

$resultCustomers = $conn->query($sqlCustomers);
if ($resultCustomers) {
    while ($row = $resultCustomers->fetch_assoc()) {
        $customers[] = $row;
    }
    $resultCustomers->free();
} else {
    die("Error retrieving customers: " . $conn->error);
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Inventory System - Add Customer</title>
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

  <!-- Main Content -->
  <div class="w-[1400px] bg-whiteshell mx-auto min-h-screen">
      <div class="flex flex-row">

          <!-- Left Column: Add Customer Form -->
          <div class="w-[320px] min-h-screen border-r border-black p-4">
              <div class="pt-[50px] pb-[70px] text-center">
                  <span class="text-xl">Add Customer</span>
              </div>

              <form method="POST" action="process_customer.php" class="grid grid-cols-1 gap-y-4 w-full max-w-[300px] mx-auto">
                  <input type="hidden" name="customer_id" id="customer_id" value="">
                  <input type="hidden" name="address_id" id="address_id" value="">
                  <!-- Full Name -->
                  <div class="flex flex-col items-start">
                      <label class="font-sigmar mb-2 text-lg">Full Name</label>
                      <input 
                        class="w-full max-w-[300px] py-2 text-center border border-gray-300 rounded-sm"
                        type="text" 
                        name="full_name" 
                        id="full_name"
                        placeholder="FULL NAME" 
                        required
                      />
                  </div>
                  <!-- Contact Number -->
                  <div class="flex flex-col items-start">
                      <label class="font-sigmar mb-2 text-lg">Contact Number</label>
                      <input 
                        class="w-full max-w-[300px] py-2 text-center border border-gray-300 rounded-sm"
                        type="text" 
                        name="contact_number" 
                        id="contact_number"
                        placeholder="CONTACT NUMBER" 
                        required
                      />
                  </div>

                  <!-- Address Section -->
                  <div class="address-section">
                      <div class="flex flex-col items-start">
                          <!-- Region -->
                          <label class="font-sigmar mb-2 text-sm">Region</label>
                          <select 
                            name="region_id" 
                            id="region_id" 
                            class="region w-full py-2 border border-gray-300 rounded-sm" 
                            required
                          >
                              <option value="" selected disabled>Select Region</option>
                              <?php foreach ($regions as $reg): ?>
                                  <option value="<?php echo htmlspecialchars($reg['Region_ID']); ?>">
                                      <?php echo htmlspecialchars($reg['Region_Name']); ?>
                                  </option>
                              <?php endforeach; ?>
                          </select>

                          <!-- Province -->
                          <label class="font-sigmar mb-2 text-sm mt-[10px]">Province</label>
                          <select 
                            name="province_id" 
                            id="province_id" 
                            class="province w-full py-2 border border-gray-300 rounded-sm" 
                            required
                          >
                              <option value="" selected disabled>Select Province</option>
                              <?php foreach ($provinces as $prov): ?>
                                  <option 
                                    value="<?php echo htmlspecialchars($prov['Province_ID']); ?>" 
                                    data-region="<?php echo htmlspecialchars($prov['Region_ID']); ?>"
                                  >
                                      <?php echo htmlspecialchars($prov['Province_Name']); ?>
                                  </option>
                              <?php endforeach; ?>
                          </select>

                          <!-- Municipality -->
                          <label class="font-sigmar mb-2 text-sm mt-[10px]">Municipality</label>
                          <select 
                            name="municipality_id" 
                            id="municipality_id" 
                            class="municipality w-full py-2 border border-gray-300 rounded-sm" 
                            required
                          >
                              <option value="" selected disabled>Select Municipality</option>
                              <?php foreach ($municipalities as $mun): ?>
                                  <option 
                                    value="<?php echo htmlspecialchars($mun['Municipality_ID']); ?>" 
                                    data-province="<?php echo htmlspecialchars($mun['Province_ID']); ?>"
                                  >
                                      <?php echo htmlspecialchars($mun['Municipality_Name']); ?>
                                  </option>
                              <?php endforeach; ?>
                          </select>

                          <!-- Barangay -->
                          <label class="font-sigmar mb-2 text-sm mt-[10px]">Barangay</label>
                          <select 
                            name="barangay_id" 
                            id="barangay_id" 
                            class="barangay w-full py-2 border border-gray-300 rounded-sm" 
                            required
                          >
                              <option value="" selected disabled>Select Barangay</option>
                              <?php foreach ($barangays as $brgy): ?>
                                  <option 
                                    value="<?php echo htmlspecialchars($brgy['Barangay_ID']); ?>" 
                                    data-municipality="<?php echo htmlspecialchars($brgy['Municipality_ID']); ?>"
                                  >
                                      <?php echo htmlspecialchars($brgy['Barangay_Name']); ?>
                                  </option>
                              <?php endforeach; ?>
                          </select>

                          <!-- Street / House -->
                          <label class="font-sigmar mb-2 text-sm mt-[10px]">Street / Building No.</label>
                          <input 
                            class="w-full max-w-[300px] py-2 text-center border border-gray-300 rounded-sm"
                            type="text" 
                            name="street_house_building_no" 
                            id="street_house_building_no"
                            placeholder="Street/Building No." 
                            required
                          />
                      </div>
                  </div>
                  
                  <button 
                    type="submit" 
                    class="p-[20px] border-2 bg-green-700 text-whiteshell mt-[20px]"
                  >
                    ENTER
                  </button>
                  <button 
                    type="button" 
                    onclick="updateCustomer()" 
                    class="p-[20px] border-2 bg-blue-700 text-whiteshell mt-[20px]"
                  >
                    UPDATE
                  </button>
              </form>
          </div>

          <!-- Right Column: Customer List -->
          <div class="w-[900px] border-l border-black p-4">
            <div class="mt-[20px]">
                <h1 class="text-2xl font-bold mb-4">Customers</h1>
                <table class="w-[1040px] bg-white">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b">Customer ID</th>
                            <th class="py-2 px-4 border-b">Customer Name</th>
                            <th class="py-2 px-4 border-b">Contact Number</th>
                            <th class="py-2 px-4 border-b">Street/House/Building No</th>
                            <th class="py-2 px-4 border-b">Barangay Name</th>
                            <th class="py-2 px-4 border-b">Municipality Name</th>
                        </tr>
                    </thead>
                    <tbody class="cursor-pointer font-rubik">
                        <?php if (!empty($customers)): ?>
                            <?php foreach ($customers as $customer): ?>
                                <tr data-customer='<?php echo htmlspecialchars(json_encode($customer)); ?>'>
                                    <td class="py-2 px-4 border-b"><?php echo $customer['Customer_ID']; ?></td>
                                    <td class="py-2 px-4 border-b"><?php echo $customer['Customer_Name']; ?></td>
                                    <td class="py-2 px-4 border-b"><?php echo $customer['Contact_Number']; ?></td>
                                    <td class="py-2 px-4 border-b"><?php echo $customer['Street_House_Building_No']; ?></td>
                                    <td class="py-2 px-4 border-b"><?php echo $customer['Barangay_Name']; ?></td>
                                    <td class="py-2 px-4 border-b"><?php echo $customer['Municipality_Name']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td class="py-2 px-4 border-b" colspan="6">No data found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
          </div>
      </div>
  </div>

  <!-- JavaScript to Cascade Filter Dropdowns and Populate Form -->
  <script>
  document.addEventListener("DOMContentLoaded", function(){
      const regionSelect = document.getElementById("region_id");
      const provinceSelect = document.getElementById("province_id");
      const municipalitySelect = document.getElementById("municipality_id");
      const barangaySelect = document.getElementById("barangay_id");
      
      function filterProvinces() {
          const selectedRegion = regionSelect.value;
          for (let option of provinceSelect.options) {
              option.style.display = (!option.value || option.dataset.region === selectedRegion) ? "" : "none";
          }
          provinceSelect.selectedIndex = 0;
          filterMunicipalities();
      }
      
      function filterMunicipalities() {
          const selectedProvince = provinceSelect.value;
          for (let option of municipalitySelect.options) {
              option.style.display = (!option.value || option.dataset.province === selectedProvince) ? "" : "none";
          }
          municipalitySelect.selectedIndex = 0;
          filterBarangays();
      }
      
      function filterBarangays() {
          const selectedMunicipality = municipalitySelect.value;
          for (let option of barangaySelect.options) {
              option.style.display = (!option.value || option.dataset.municipality === selectedMunicipality) ? "" : "none";
          }
          barangaySelect.selectedIndex = 0;
      }
      
      regionSelect.addEventListener("change", filterProvinces);
      provinceSelect.addEventListener("change", filterMunicipalities);
      municipalitySelect.addEventListener("change", filterBarangays);
      
      filterProvinces();
  });

  function populateForm(customer) {
    document.getElementById("customer_id").value = customer.Customer_ID;
    document.getElementById("address_id").value = customer.Address_ID;  // Ensure Address_ID is set
    document.getElementById("full_name").value = customer.Customer_Name;
    document.getElementById("contact_number").value = customer.Contact_Number;
    document.getElementById("street_house_building_no").value = customer.Street_House_Building_No;

    // Set dropdown values
    document.getElementById("region_id").value = customer.Region_ID;
    document.getElementById("province_id").value = customer.Province_ID;
    document.getElementById("municipality_id").value = customer.Municipality_ID;
    document.getElementById("barangay_id").value = customer.Barangay_ID;

    // Ensure cascading dropdowns update
    document.getElementById("region_id").dispatchEvent(new Event("change"));
    document.getElementById("province_id").dispatchEvent(new Event("change"));
    document.getElementById("municipality_id").dispatchEvent(new Event("change"));
}


  function updateCustomer() {
      document.forms[0].action = "update_customer.php";
      document.forms[0].submit();
  }

  document.querySelectorAll("tbody tr").forEach(row => {
      row.addEventListener("click", function() {
          const customer = JSON.parse(this.getAttribute("data-customer"));
          populateForm(customer);
      });
  });
</script>


</body>
</html>