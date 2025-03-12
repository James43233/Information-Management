<?php
session_start();
include 'database.php';

// Process registration form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve and sanitize form data
    $fullName = $conn->real_escape_string(trim($_POST['fullName']));
    $username = $conn->real_escape_string(trim($_POST['Username']));
    $password = trim($_POST['password']); // Raw password, not hashed
    $role     = $conn->real_escape_string(trim($_POST['role']));

    // Insert the new employee into the user_employee table using a prepared statement
    $stmt = $conn->prepare("INSERT INTO user_employee (User_Name, Username, password, Role_ID) VALUES (?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("ssss", $fullName, $username, $password, $role);
        if ($stmt->execute()) {
            echo "<script>
                alert('Employee registered successfully!');
                window.location.href = 'Login.php';
            </script>";
            exit();
        } else {
            $message = "Error inserting employee: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $message = "Prepare failed: " . $conn->error;
    }
}


// Retrieve all roles from the dedicated roles table
$roles = [];
$roleResult = $conn->query("SELECT Role_ID, Title FROM role_type");
if ($roleResult) {
    while ($row = $roleResult->fetch_assoc()) {
        $roles[] = $row;
    }
    $roleResult->free();
}

// Retrieve all employees for display (if needed)
$employees = [];
$result = $conn->query("SELECT * FROM user_employee");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $employees[] = $row;
    }
    $result->free();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Inventory System - Register Employee</title>
  <link rel="stylesheet" href="output.css">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-pink-400 via-purple-200 to-indigo-400 font-sigmar flex items-center justify-center min-h-screen">
    <div class="w-[700px] h-[700px] bg-yellow-400 shadow-lg rounded-lg flex justify-center">
        <div class="flex flex-col mt-[70px]">
            <div class="flex items-center font-sigmar text-2xl text-green-900 w-[460px] justify-center">
                <a href="#">Urban Mis<span class="text-rose-400">Fits</span></a>
            </div>
            <form method="POST" action="" class="mx-auto py-10">
                <?php if(isset($message)): ?>
                    <?php if($message === "Employee registered successfully!"): ?>
                    <script>
                        alert("Employee registered successfully!");
                    </script>
                    <?php else: ?>
                    <p class="text-red-600 mb-4 text-center"><?php echo htmlspecialchars($message); ?></p>
                    <?php endif; ?>
                <?php endif; ?>
                <div class="pb-[20px] text-center">
                    <span class="text-xl">Register an Employee</span>
                </div>
                <div class="grid grid-cols-1 gap-y-2 w-full max-w-[300px] mx-auto">
                    <!-- Full Name -->
                    <div class="flex flex-col items-start">
                        <label class="font-sigmar mb-[10px]">FULL NAME</label>
                        <input class="w-full py-2 border border-gray-300 rounded-sm font-rubik" type="text" name="fullName" placeholder="" required>
                    </div>
                    <!-- Username -->
                    <div class="flex flex-col items-start mt-[20px]">
                        <label class="font-sigmar mb-[10px]">Username</label>
                        <input class="w-full py-2 border border-gray-300 rounded-sm font-rubik"" type="text" name="Username" placeholder="" required>
                    </div>
                    <!-- Password -->
                    <div class="flex flex-col items-start mt-[20px]">
                        <label class="font-sigmar mb-[10px]">Password</label>
                        <input class="w-full py-2 border border-gray-300 rounded-sm font-rubik"" type="password" name="password" placeholder="" required>
                    </div>
                    <!-- Role -->
                    <div class="flex flex-col items-start mt-[20px]">
                        <label class="font-sigmar mb-[10px]">Role</label>
                        <select name="role" class="w-full py-2 border border-gray-300 rounded-sm font-rubik"">
                            <?php if (!empty($roles)): ?>
                                <?php foreach ($roles as $roleItem): ?>
                                    <option value="<?php echo htmlspecialchars($roleItem['Role_ID']); ?>">
                                        <?php echo htmlspecialchars($roleItem['Title']); ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value="">No roles available</option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <button type="submit" class="p-[20px] border-2 bg-green-700 text-white mt-[20px]">ENTER</button>
                </div>
            </form>               
        </div>
    </div>
</body>
</html>
