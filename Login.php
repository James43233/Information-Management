<?php
session_start();
include 'database.php';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Regular login
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM user_employee WHERE username = ? AND password = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $_SESSION['username'] = $username;
            $_SESSION['role_id'] = $user['Role_ID'];
            header("Location: sales.php");
            exit();
        } else {
            echo "<script>alert('Invalid username or password!'); window.location.href='Login.php';</script>";
        }
        $stmt->close();
    }
    
    // Check admin credentials for register access
    if (isset($_POST['check_admin'])) {
        $admin_username = $_POST['admin_username'];
        $admin_password = $_POST['admin_password'];

        $sql = "SELECT * FROM user_employee WHERE username = ? AND password = ? AND Role_ID = 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $admin_username, $admin_password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            header("Location: Register.php");
            exit();
        } else {
            echo "<script>alert('Invalid admin credentials!'); window.location.href='Login.php';</script>";
        }
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Inventory System</title>
    <link rel="stylesheet" href="output.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-screen m-0 flex flex-col items-center justify-center bg-gradient-to-r from-pink-400 via-purple-200 to-indigo-400 font-sigmar">
    <!-- Current Date/Time and User Info -->
    <div class="absolute top-4 left-4 text-sm font-rubik text-gray-700">
        <?php
        date_default_timezone_set('UTC');
        echo "<p>Current Date and Time (UTC): " . date('Y-m-d H:i:s') . "</p>";
        echo "<p>Current User's Login: James43233</p>";
        ?>
    </div>

    <div class="w-[700px] h-[700px] bg-whiteshell shadow-lg rounded-lg flex justify-center">
        <div class="flex flex-col mt-[70px]">
            <div class="flex items-center font-sigmar text-2xl text-green-900 w-[460px] justify-center mt-[50px]">
                <a href="#">Urban Mis<span class="text-rose-400">Fits</span></a>
            </div>

            <form method="POST" action="" class="grid-row-1 mt-[50px] flex flex-col items-center">
                <div class="flex flex-col items-center mt-[20px]">
                    <span class="font-sigmar text-left self-start">Username</span>
                    <input
                        class="p-[15px] border-2 border-gray-300 text-black mt-[20px] w-[300px] mx-auto"
                        type="text"
                        name="username"
                        placeholder="USERNAME"
                        required
                    />
                </div>
                <div class="flex flex-col items-center mt-[20px]">
                    <span class="font-sigmar text-left self-start">Password</span>
                    <input
                        class="p-[15px] border-2 border-gray-300 text-black mt-[20px] w-[300px] mx-auto"
                        type="password"
                        name="password"
                        placeholder="PASSWORD"
                        required
                    />
                </div>
                <button
                    type="submit"
                    class="p-[15px] border-2 bg-green-700 text-whiteshell mt-[20px] w-[300px] mx-auto"
                >
                    Login
                </button>
            </form>
            
            <!-- Always show the Register link -->
            <a href="#" onclick="checkAdmin(event)" class="text-center mt-[100px] text-blue-400 hover:text-blue-600">Register an Employee</a>
        </div>
    </div>

    <script>
      function checkAdmin() {
          var admin_username = prompt("Please enter admin username:");
          if (admin_username != null) {
              var admin_password = prompt("Please enter admin password:");
              if (admin_password != null) {
                  var form = document.createElement("form");
                  form.method = "POST";
                  form.action = "";

                  // Add admin username
                  var username_input = document.createElement("input");
                  username_input.type = "hidden";
                  username_input.name = "admin_username";
                  username_input.value = admin_username;
                  form.appendChild(username_input);

                  // Add admin password
                  var password_input = document.createElement("input");
                  password_input.type = "hidden";
                  password_input.name = "admin_password";
                  password_input.value = admin_password;
                  form.appendChild(password_input);

                  // Add check_admin flag
                  var check_admin = document.createElement("input");
                  check_admin.type = "hidden";
                  check_admin.name = "check_admin";
                  check_admin.value = "1";
                  form.appendChild(check_admin);

                  document.body.appendChild(form);
                  form.submit();
              }
          }
      }
      </script>

</body>
</html>