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
<body class="h-screen m-0 flex-col justify-center  bg-gradient-to-r from-pink-400 via-purple-200 to-indigo-400 font-sigmar">
    <div class="bg-yellow-300 h-[90px] flex flex-row">
        <div class="flex items-center h-full font-sigmar text-2xl text-green-900 w-[460px] justify-center">
            <a href="Index.html">Urban Mis<span class="text-rose-400">Fits</span></a>
        </div>
        <div class="flex justify-start items-center flex-1 h-full font-sigmar gap-[70px] text-rose-400">
            <a href="index.php">Point of Sales</a>
            <a href="Sales.html">Sales</a> 
            <a href="Inventory.html">Inventory </a>
            <a href="Dashboard.html">Dashboard</a>
            <a href="Delivery.html">Delivery</a>
            <a href="Product.html">Product</a>
            <div class="relative group">
                <a href="#" class="font-sigmar mb-2 text-lg cursor-pointer">More </a>
                <div class="absolute hidden bg-white shadow-lg rounded-lg group-hover:block">
                    <a href="Customer.html" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Customers</a>
                    <a href="Supplier.html" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Supplier</a>
                    <a href="Register.php" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Register An Employee</a>
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
            <div class="flex flex-col w-[350px] h-screen bg-whiteshell border-r-2 border-black">
                <div class="flex flex-row justify-center items-center mt-[20px]">
                    <span class="font-sigmar mb-2 text-lg mr-[20px]">Sale ID : </span>
                    <input class="w-full max-w-[200px] py-2 text-left border border-gray-300 rounded-sm text-black placeholder-black font-serif" 
                           type="text" name="contact_number" placeholder="">
                </div>
                <div class="w-[330px] h-[300px] bg-white mx-auto mt-[20px] border border-black">
                    SALE TABLE
                </div>
                <div class="flex justify-evenly gap-2 mt-[20px]">
                    <button class="border-2 w-full bg-green-700">
                        Delete
                    </button>
                    <button class="border-2 w-full bg-green-700">
                        ADD
                    </button>
                    <button class="border-2 w-full bg-green-700">
                        ENTER
                    </button>
                </div>
                <div class="grid grid-cols-1 gap-y-4 w-full max-w-[300px] mx-auto mt-[20px]">
                    <!-- Full Name -->
                    <div class="flex flex-col items-start">
                        <span class="font-sigmar mb-2 text-lg">Product Name</span>
                        <input class="w-full max-w-[300px] py-2 text-center border border-gray-300 rounded-sm text-black placeholder-black font-serif"  
                               type="text" name="full_name" placeholder="">
                    </div>
                    <!-- Contact Number -->
                    <div class="flex flex-col items-start">
                        <span class="font-sigmar mb-2 text-lg">Quantity</span>
                        <input class="w-full max-w-[300px] py-2 text-center border border-gray-300 rounded-sm text-black placeholder-black font-serif" 
                               type="text" name="contact_number" placeholder="">
                    </div>
                </div>

            </div>
            <div  class="flex w-[650px] h-screen bg-whiteshell flex-col">
                <div class="mt-[20px] border-black w-full">
                    <div class="mb-[10px] flex items-center justify-center">
                        <button class="flex items-center bg-Black border border-gray-300 rounded-full px-4 py-2 shadow-sm hover:shadow-md focus-within:ring-2 focus-within:ring-green-700">
                            <input type="text" placeholder="Search..." class="w-[500px] outline-none bg-transparent text-black placeholder-black font-serif">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-gray-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1118 10.5a7.5 7.5 0 01-1.35 6.15z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="mt-[20px] mx-auto">
                    Show tables
                </div>
                
            </div>

        </div>

    </div>
    
      
</body>
</html>