-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 28, 2025 at 03:35 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_pos_inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `Address_ID` int(11) NOT NULL,
  `Street_House_Building_No` varchar(255) DEFAULT NULL,
  `Barangay_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`Address_ID`, `Street_House_Building_No`, `Barangay_ID`) VALUES
(1, 'La verna hills Phase 3 BLK 11 LOT 11 St.Ignacio Street', 68);

-- --------------------------------------------------------

--
-- Table structure for table `barangay`
--

CREATE TABLE `barangay` (
  `Barangay_ID` int(11) NOT NULL,
  `Barangay_Name` varchar(255) DEFAULT NULL,
  `Municipality_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barangay`
--

INSERT INTO `barangay` (`Barangay_ID`, `Barangay_Name`, `Municipality_ID`) VALUES
(1, 'Acacia', 752),
(2, 'Agdao', 752),
(3, 'Alambre', 752),
(4, 'Alejandra Navarro', 752),
(5, 'Alfonso Angliongto Sr.', 752),
(6, 'Angalan', 752),
(7, 'Atan-awe', 752),
(8, 'Baganihan', 752),
(9, 'Bago Aplaya', 752),
(10, 'Bago Gallera', 752),
(11, 'Bago Oshiro', 752),
(12, 'Baguio', 752),
(13, 'Balengaeng', 752),
(14, 'Baliok', 752),
(15, 'Bangkas Heights', 752),
(16, 'Bantol', 752),
(17, 'Baracatan', 752),
(18, 'Barangay 10-A', 752),
(19, 'Barangay 11-B', 752),
(20, 'Barangay 12-B', 752),
(21, 'Barangay 13-B', 752),
(22, 'Barangay 14-B', 752),
(23, 'Barangay 15-B', 752),
(24, 'Barangay 16-B', 752),
(25, 'Barangay 17-B', 752),
(26, 'Barangay 18-B', 752),
(27, 'Barangay 19-B', 752),
(28, 'Barangay 1-A', 752),
(29, 'Barangay 20-B', 752),
(30, 'Barangay 21-C', 752),
(31, 'Barangay 22-C', 752),
(32, 'Barangay 23-C', 752),
(33, 'Barangay 24-C', 752),
(34, 'Barangay 25-C', 752),
(35, 'Barangay 26-C', 752),
(36, 'Barangay 27-C', 752),
(37, 'Barangay 28-C', 752),
(38, 'Barangay 29-C', 752),
(39, 'Barangay 2-A', 752),
(40, 'Barangay 30-C', 752),
(41, 'Barangay 31-D', 752),
(42, 'Barangay 32-D', 752),
(43, 'Barangay 33-D', 752),
(44, 'Barangay 34-D', 752),
(45, 'Barangay 35-D', 752),
(46, 'Barangay 36-D', 752),
(47, 'Barangay 37-D', 752),
(48, 'Barangay 38-D', 752),
(49, 'Barangay 39-D', 752),
(50, 'Barangay 3-A', 752),
(51, 'Barangay 40-D', 752),
(52, 'Barangay 4-A', 752),
(53, 'Barangay 5-A', 752),
(54, 'Barangay 6-A', 752),
(55, 'Barangay 7-A', 752),
(56, 'Barangay 8-A', 752),
(57, 'Barangay 9-A', 752),
(58, 'Bato', 752),
(59, 'Bayabas', 752),
(60, 'Biao Escuela', 752),
(61, 'Biao Guianga', 752),
(62, 'Biao Joaquin', 752),
(63, 'Binugao', 752),
(64, 'Bucana', 752),
(65, 'Buda', 752),
(66, 'Buhangin', 752),
(67, 'Bunawan', 752),
(68, 'Cabantian', 752),
(69, 'Cadalian', 752),
(70, 'Calinan', 752),
(71, 'Callawa', 752),
(72, 'Camansi', 752),
(73, 'Carmen', 752),
(74, 'Catalunan Grande', 752),
(75, 'Catalunan Pequeño', 752),
(76, 'Catigan', 752),
(77, 'Cawayan', 752),
(78, 'Centro', 752),
(79, 'Colosas', 752),
(80, 'Communal', 752),
(81, 'Crossing Bayabas', 752),
(82, 'Dacudao', 752),
(83, 'Dalag', 752),
(84, 'Dalagdag', 752),
(85, 'Daliao', 752),
(86, 'Daliaon Plantation', 752),
(87, 'Datu Salumay', 752),
(88, 'Dominga', 752),
(89, 'Dumoy', 752),
(90, 'Eden', 752),
(91, 'Fatima', 752),
(92, 'Gatungan', 752),
(93, 'Gov. Paciano Bangoy', 752),
(94, 'Gov. Vicente Duterte', 752),
(95, 'Gumalang', 752),
(96, 'Gumitan', 752),
(97, 'Ilang', 752),
(98, 'Inayangan', 752),
(99, 'Indangan', 752),
(100, 'Kap. Tomas Monteverde, Sr.', 752),
(101, 'Kilate', 752),
(102, 'Lacson', 752),
(103, 'Lamanan', 752),
(104, 'Lampianao', 752),
(105, 'Langub', 752),
(106, 'Lapu-lapu', 752),
(107, 'Leon Garcia, Sr.', 752),
(108, 'Lizada', 752),
(109, 'Los Amigos', 752),
(110, 'Lubogan', 752),
(111, 'Lumiad', 752),
(112, 'Ma-a', 752),
(113, 'Mabuhay', 752),
(114, 'Magsaysay', 752),
(115, 'Magtuod', 752),
(116, 'Mahayag', 752),
(117, 'Malabog', 752),
(118, 'Malagos', 752),
(119, 'Malamba', 752),
(120, 'Manambulan', 752),
(121, 'Mandug', 752),
(122, 'Manuel Guianga', 752),
(123, 'Mapula', 752),
(124, 'Marapangi', 752),
(125, 'Marilog', 752),
(126, 'Matina Aplaya', 752),
(127, 'Matina Biao', 752),
(128, 'Matina Crossing', 752),
(129, 'Matina Pangi', 752),
(130, 'Megkawayan', 752),
(131, 'Mintal', 752),
(132, 'Mudiang', 752),
(133, 'Mulig', 752),
(134, 'New Carmen', 752),
(135, 'New Valencia', 752),
(136, 'Pampanga', 752),
(137, 'Panacan', 752),
(138, 'Panalum', 752),
(139, 'Pandaitan', 752),
(140, 'Pangyan', 752),
(141, 'Paquibato', 752),
(142, 'Paradise Embak', 752),
(143, 'Rafael Castillo', 752),
(144, 'Riverside', 752),
(145, 'Salapawan', 752),
(146, 'Salaysay', 752),
(147, 'Saloy', 752),
(148, 'San Antonio', 752),
(149, 'San Isidro', 752),
(150, 'Santo Niño', 752),
(151, 'Sasa', 752),
(152, 'Sibulan', 752),
(153, 'Sirawan', 752),
(154, 'Sirib', 752),
(155, 'Suawan', 752),
(156, 'Subasta', 752),
(157, 'Sumimao', 752),
(158, 'Tacunan', 752),
(159, 'Tagakpan', 752),
(160, 'Tagluno', 752),
(161, 'Tagurano', 752),
(162, 'Talandang', 752),
(163, 'Talomo', 752),
(164, 'Talomo River', 752),
(165, 'Tamayong', 752),
(166, 'Tambobong', 752),
(167, 'Tamugan', 752),
(168, 'Tapak', 752),
(169, 'Tawan-tawan', 752),
(170, 'Tibuloy', 752),
(171, 'Tibungco', 752),
(172, 'Tigatto', 752),
(173, 'Toril', 752),
(174, 'Tugbok', 752),
(175, 'Tungakalan', 752),
(176, 'Ubalde', 752),
(177, 'Ula', 752),
(178, 'Vicente Hizon Sr.', 752),
(179, 'Waan', 752),
(180, 'Wangan', 752),
(181, 'Wilfredo Aquino', 752),
(182, 'Wines', 752);

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `Brand_ID` int(11) NOT NULL,
  `Brand_Name` varchar(255) DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`Brand_ID`, `Brand_Name`, `Description`) VALUES
(1, 'Nike', 'Top 1 brand'),
(2, 'Adidas', 'Decent');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `Category_ID` int(11) NOT NULL,
  `Category_Name` varchar(255) DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`Category_ID`, `Category_Name`, `Description`) VALUES
(1, 'Shirt', NULL),
(2, 'Pants', NULL),
(3, 'Long Sleeves', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `condition_item`
--

CREATE TABLE `condition_item` (
  `Condition_ID` int(11) NOT NULL,
  `Condition_Name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `condition_item`
--

INSERT INTO `condition_item` (`Condition_ID`, `Condition_Name`) VALUES
(1, 'Used'),
(2, 'Brand New'),
(3, 'Damaged');

-- --------------------------------------------------------

--
-- Table structure for table `courier`
--

CREATE TABLE `courier` (
  `Courier_ID` int(11) NOT NULL,
  `Name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courier`
--

INSERT INTO `courier` (`Courier_ID`, `Name`) VALUES
(1, 'Lalamove'),
(2, 'J&T Express'),
(3, 'AP Cargo'),
(4, 'LBC'),
(5, 'JRS Express'),
(6, '2GO');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `Customer_ID` int(11) NOT NULL,
  `Customer_Name` varchar(255) DEFAULT NULL,
  `Contact_Number` varchar(20) DEFAULT NULL,
  `Address_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`Customer_ID`, `Customer_Name`, `Contact_Number`, `Address_ID`) VALUES
(1, 'James Carballo', '099561053510', 1);

-- --------------------------------------------------------

--
-- Stand-in structure for view `customer_address_view`
-- (See below for the actual view)
--
CREATE TABLE `customer_address_view` (
`Customer_ID` int(11)
,`Customer_Name` varchar(255)
,`Contact_Number` varchar(20)
,`Street_House_Building_No` varchar(255)
,`Barangay_Name` varchar(255)
,`Municipality_Name` varchar(255)
,`Postal_Code` varchar(20)
,`Province_Name` varchar(255)
,`Region_Name` varchar(255)
);

-- --------------------------------------------------------

--
-- Table structure for table `delivery`
--

CREATE TABLE `delivery` (
  `Delivery_ID` int(11) NOT NULL,
  `Courier_ID` int(11) DEFAULT NULL,
  `Address_ID` int(11) DEFAULT NULL,
  `Delivery_Fee` int(11) DEFAULT NULL,
  `Sale_ID` int(11) DEFAULT NULL,
  `Date` date DEFAULT NULL,
  `Status_ID` int(11) DEFAULT NULL,
  `Tracking_Number` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `delivery_view`
-- (See below for the actual view)
--
CREATE TABLE `delivery_view` (
`Delivery_ID` int(11)
,`Courier_ID` int(11)
,`Address_ID` int(11)
,`Delivery_Fee` int(11)
,`Sale_ID` int(11)
,`Date` date
,`Status_ID` int(11)
,`Tracking_Number` varchar(255)
,`Customer_ID` int(11)
,`User_ID` int(11)
,`Total_Amount` int(11)
,`Payment_Type` varchar(255)
,`Sale_Date` date
);

-- --------------------------------------------------------

--
-- Table structure for table `merchant`
--

CREATE TABLE `merchant` (
  `Merchant_ID` int(11) NOT NULL,
  `Title` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `merchant`
--

INSERT INTO `merchant` (`Merchant_ID`, `Title`) VALUES
(1, 'Paypal'),
(2, 'Gcash'),
(3, 'DragonPay'),
(4, 'Bank Transfer');

-- --------------------------------------------------------

--
-- Table structure for table `mode_payment`
--

CREATE TABLE `mode_payment` (
  `Payment_ID` int(11) NOT NULL,
  `Merchant_ID` int(11) DEFAULT NULL,
  `Sale_ID` int(11) DEFAULT NULL,
  `Ref_Num` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `municipality`
--

CREATE TABLE `municipality` (
  `Municipality_ID` int(11) NOT NULL,
  `Municipality_Name` varchar(255) DEFAULT NULL,
  `Postal_Code` varchar(20) DEFAULT NULL,
  `Province_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `municipality`
--

INSERT INTO `municipality` (`Municipality_ID`, `Municipality_Name`, `Postal_Code`, `Province_ID`) VALUES
(1, 'Jolo', '7400', 85),
(2, 'Patikul', '7401', 85),
(3, 'Old Panamao', '7402', 85),
(4, 'Talipao', '7403', 85),
(5, 'Luuk (Omar)', '7404', 85),
(6, 'Pata', '7405', 85),
(7, 'Banguingui (Tongkil)', '7406', 85),
(8, 'Indanan', '7407', 85),
(9, 'Parang', '7408', 85),
(10, 'Maimbung', '7409', 85),
(11, 'Tapul', '7410', 85),
(12, 'Lugus', '7411', 85),
(13, 'Siasi', '7412', 85),
(14, 'Hadji Panglima Tahil', '7413', 85),
(15, 'Pangutaran', '7414', 85),
(16, 'Panglima Estino (New Panamao)', '7415', 85),
(17, 'Kalingalan Calauang', '7416', 85),
(18, 'Bongao', '7500', 86),
(19, 'Panglima Sugala (Balimbing)', '7501', 86),
(20, 'Tandubas', '7502', 86),
(21, 'Sapa-Sapa', '7503', 86),
(22, 'South Ubian', '7504', 86),
(23, 'Simunul', '7505', 86),
(24, 'Sitangkai', '7506', 86),
(25, 'Turtle Islands (Taganak)', '7507', 86),
(26, 'Mapun (Cagayan de Sulu)', '7508', 86),
(27, 'Languyan', '7509', 86),
(28, 'Sibutu', '7510', 86),
(29, 'Pantar', '9218', 84),
(30, 'Picong (Sultan Gumander)', '9301', 84),
(31, 'Balabagan', '9302', 84),
(32, 'Marogong', '9303', 84),
(33, 'Tubaran', '9304', 84),
(34, 'Butig', '9305', 84),
(35, 'Lumbayanague', '9306', 84),
(36, 'Lumbatan', '9307', 84),
(37, 'Lumbaca-Unayan and Macadar Andong', '9308', 84),
(38, 'Bayang', '9309', 84),
(39, 'Binidayan', '9310', 84),
(40, 'Ganassi', '9311', 84),
(41, 'Pagayawan', '9312', 84),
(42, 'Pualas', '9313', 84),
(43, 'Madamba', '9314', 84),
(44, 'Madalum', '9315', 84),
(45, 'Bacolod-Kalawi (Bacolod Grande)', '9316', 84),
(46, 'Tugaya', '9317', 84),
(47, 'Balindong', '9318', 84),
(48, 'Calanogas', '9319', 84),
(49, 'Amai Manabilang (Bumbaran)', '9320', 84),
(50, 'Kapatagan', '9322', 84),
(51, 'Malabang', '9300', 87),
(52, 'Cotabato City', '9600', 87),
(53, 'Datu Odin Sinsuat (Dinaig)', '9601', 87),
(54, 'Upi', '9602', 87),
(55, 'South Upi', '9603', 87),
(56, 'Parang', '9604', 87),
(57, 'Sultan Kudarat', '9605', 87),
(58, 'Kabuntalan', '9606', 87),
(59, 'Datu Piang', '9607', 87),
(60, 'Shariff Aguak (Maganoy)', '9608', 87),
(61, 'Ampatuan', '9609', 87),
(62, 'Pagalungan', '9610', 87),
(63, 'Sultan sa Barongis', '9611', 87),
(64, 'Talayan', '9612', 87),
(65, 'Matanog', '9613', 87),
(66, 'Barira', '9614', 87),
(67, 'Buldon', '9615', 87),
(68, 'Buluan', '9616', 87),
(69, 'Datu Paglas', '9617', 87),
(70, 'Gen. S.K. Pendatun', '9618', 87),
(71, 'Mangudadatu', '9620', 87),
(72, 'Datu Abdullah Sangki', '9621', 87),
(73, 'Datu Anggal Midtimbang', '9622', 87),
(74, 'Datu Blah T. Sinsuat', '9623', 87),
(75, 'Datu Hoffer Ampatuan', '9624', 87),
(76, 'Datu Salibo', '9625', 87),
(77, 'Datu Saudi-Ampatuan', '9626', 87),
(78, 'Datu Unsay', '9627', 87),
(79, 'Guindulungan', '9628', 87),
(80, 'Mamasapano', '9629', 87),
(81, 'Northern Kabuntalan', '9630', 87),
(82, 'Datu Montawal (Pagagawan)', '9631', 87),
(83, 'Paglat', '9632', 87),
(84, 'Pandag', '9633', 87),
(85, 'Rajah Buayan', '9634', 87),
(86, 'Shariff Saydona Mustapha', '9635', 87),
(87, 'Sultan Mastura', '9636', 87),
(88, 'Sultan Sumagka (Talitay)', '9637', 87),
(89, 'Kapatagan', '9700', 84),
(90, 'Saguiaran', '9701', 84),
(91, 'Mulondo', '9702', 84),
(92, 'Lumba-Bayabao', '9703', 84),
(93, 'Tamparan', '9704', 84),
(94, 'Poona Bayabao', '9705', 84),
(95, 'Masiu', '9706', 84),
(96, 'Bubong', '9708', 84),
(97, 'Kapai', '9709', 84),
(98, 'Piagapo', '9710', 84),
(99, 'Marantao', '9711', 84),
(100, 'Taraka', '9712', 84),
(101, 'Ditsaan-Ramain', '9713', 84),
(102, 'Buadiposo-Buntong', '9714', 84),
(103, 'Maguing', '9715', 84),
(104, 'Wao', '9716', 84),
(105, 'Naga', '4400', 26),
(106, 'Camaligan', '4401', 26),
(107, 'Canaman', '4402', 26),
(108, 'Magarao', '4403', 26),
(109, 'Bombon', '4404', 26),
(110, 'Calabanga', '4405', 26),
(111, 'Cabusao', '4406', 26),
(112, 'Libmanan', '4407', 26),
(113, 'Sipocot', '4408', 26),
(114, 'Lupi', '4409', 26),
(115, 'Ragay', '4410', 26),
(116, 'Del Gallego', '4411', 26),
(117, 'Gainza', '4412', 26),
(118, 'Milaor', '4413', 26),
(119, 'Minalabac', '4414', 26),
(120, 'San Fernando', '4415', 26),
(121, 'Pamplona', '4416', 26),
(122, 'Pasacao', '4417', 26),
(123, 'Pili', '4418', 26),
(124, 'Ocampo', '4419', 26),
(125, 'Tigaon', '4420', 26),
(126, 'Sagñay', '4421', 26),
(127, 'Goa', '4422', 26),
(128, 'San Jose', '4423', 26),
(129, 'Presentacion', '4424', 26),
(130, 'Lagonoy', '4425', 26),
(131, 'Tinambac', '4426', 26),
(132, 'Siruma', '4427', 26),
(133, 'Garchitorena', '4428', 26),
(134, 'Caramoan', '4429', 26),
(135, 'Bula', '4430', 26),
(136, 'Iriga', '4431', 26),
(137, 'Baao', '4432', 26),
(138, 'Buhi', '4433', 26),
(139, 'Nabua', '4434', 26),
(140, 'Bato', '4435', 26),
(141, 'Balatan', '4436', 26),
(142, 'Legazpi', '4500', 24),
(143, 'Daraga (Locsin)', '4501', 24),
(144, 'Camalig', '4502', 24),
(145, 'Guinobatan', '4503', 24),
(146, 'Ligao', '4504', 24),
(147, 'Oas', '4505', 24),
(148, 'Polangui', '4506', 24),
(149, 'Libon', '4507', 24),
(150, 'Santo Domingo', '4508', 24),
(151, 'Bacacay', '4509', 24),
(152, 'Malilipot', '4510', 24),
(153, 'Tabaco', '4511', 24),
(154, 'Malinao', '4512', 24),
(155, 'Tiwi', '4513', 24),
(156, 'Manito', '4514', 24),
(157, 'Jovellar', '4515', 24),
(158, 'Pio Duran (Malacbalac)', '4516', 24),
(159, 'Rapu-Rapu', '4517', 24),
(160, 'Daet', '4600', 25),
(161, 'Mercedes', '4601', 25),
(162, 'Talisay', '4602', 25),
(163, 'Vinzons', '4603', 25),
(164, 'Labo', '4604', 25),
(165, 'Paracale', '4605', 25),
(166, 'Jose Panganiban', '4606', 25),
(167, 'Capalonga', '4607', 25),
(168, 'Basud', '4608', 25),
(169, 'San Vicente', '4609', 25),
(170, 'San Lorenzo Ruiz', '4610', 25),
(171, 'Santa Elena', '4611', 25),
(172, 'Tulay-na-Lupa', '4612', 25),
(173, 'Sorsogon City', '4700', 29),
(174, 'Bacon', '4701', 29),
(175, 'Casiguran', '4702', 29),
(176, 'Juban', '4703', 29),
(177, 'Bulusan', '4704', 29),
(178, 'Magallanes', '4705', 29),
(179, 'Bulan', '4706', 29),
(180, 'Irosin', '4707', 29),
(181, 'Matnog', '4708', 29),
(182, 'Santa Magdalena', '4709', 29),
(183, 'Gubat', '4710', 29),
(184, 'Prieto Diaz', '4711', 29),
(185, 'Barcelona', '4712', 29),
(186, 'Castilla', '4713', 29),
(187, 'Pilar', '4714', 29),
(188, 'Donsol', '4715', 29),
(189, 'Virac', '4800', 27),
(190, 'Bato', '4801', 27),
(191, 'San Miguel', '4802', 27),
(192, 'Baras', '4803', 27),
(193, 'Gigmoto', '4804', 27),
(194, 'Viga', '4805', 27),
(195, 'Panganiban', '4806', 27),
(196, 'Bagamanoc', '4807', 27),
(197, 'Caramoran', '4808', 27),
(198, 'Pandan', '4809', 27),
(199, 'San Andres', '4810', 27),
(200, 'Masbate City', '5400', 28),
(201, 'Mobo', '5401', 28),
(202, 'Uson', '5402', 28),
(203, 'Dimasalang', '5403', 28),
(204, 'Palanas', '5404', 28),
(205, 'Cataingan', '5405', 28),
(206, 'Pio V. Corpuz', '5406', 28),
(207, 'Esperanza', '5407', 28),
(208, 'Placer', '5408', 28),
(209, 'Cawayan', '5409', 28),
(210, 'Milagros', '5410', 28),
(211, 'Mandaon', '5411', 28),
(212, 'Balud', '5412', 28),
(213, 'Baleno', '5413', 28),
(214, 'Aroroy', '5414', 28),
(215, 'Batuan', '5415', 28),
(216, 'San Fernando', '5416', 28),
(217, 'San Jacinto', '5417', 28),
(218, 'Monreal', '5418', 28),
(219, 'Claveria', '5419', 28),
(220, 'San Pascual', '5420', 28),
(221, 'Buenavista', '5421', 28),
(222, 'Ilagan', '3300', 7),
(223, 'Gamu', '3301', 7),
(224, 'Naguillan', '3302', 7),
(225, 'Reina Mercedes', '3303', 7),
(226, 'Luna', '3304', 7),
(227, 'Cauayan', '3305', 7),
(228, 'Alicia', '3306', 7),
(229, 'Angadanan', '3307', 7),
(230, 'San Guillermo', '3308', 7),
(231, 'Echague', '3309', 7),
(232, 'San Isidro', '3310', 7),
(233, 'Santiago', '3311', 7),
(234, 'Cordon', '3312', 7),
(235, 'Jones', '3313', 7),
(236, 'San Agustin', '3314', 7),
(237, 'Cabatuan', '3315', 7),
(238, 'Aurora', '3316', 7),
(239, 'San Manuel (Callang)', '3317', 7),
(240, 'San Mateo', '3318', 7),
(241, 'Ramon', '3319', 7),
(242, 'Roxas', '3320', 7),
(243, 'Quirino', '3321', 7),
(244, 'Burgos', '3322', 7),
(245, 'Mallig', '3323', 7),
(246, 'Quezon', '3324', 7),
(247, 'Tumauini', '3325', 7),
(248, 'Delfin Albano', '3326', 7),
(249, 'Santo Tomas', '3327', 7),
(250, 'Cabagan', '3328', 7),
(251, 'San Pablo', '3329', 7),
(252, 'Santa Maria', '3330', 7),
(253, 'Benito Soliven', '3331', 7),
(254, 'San Mariano', '3332', 7),
(255, 'Maconacon', '3333', 7),
(256, 'Palanan', '3334', 7),
(257, 'Divilacan', '3335', 7),
(258, 'Dinapigue', '3336', 7),
(259, 'Cabarroguis', '3400', 9),
(260, 'Diffun', '3401', 9),
(261, 'Saguday', '3402', 9),
(262, 'Aglipay', '3403', 9),
(263, 'Maddela', '3404', 9),
(264, 'Nagtipunan (Abbag)', '3405', 9),
(265, 'Tuguegarao', '3500', 6),
(266, 'Enrile', '3501', 6),
(267, 'Peñablanca', '3502', 6),
(268, 'Solana', '3503', 6),
(269, 'Iguig', '3504', 6),
(270, 'Amulung', '3505', 6),
(271, 'Baggao', '3506', 6),
(272, 'Alcala', '3507', 6),
(273, 'Gattaran', '3508', 6),
(274, 'Lal-Lo', '3509', 6),
(275, 'Camalaniugan', '3510', 6),
(276, 'Buguey', '3511', 6),
(277, 'Santa Teresita', '3512', 6),
(278, 'City of Bacoor', '1775', 20),
(279, 'San Mateo', '1850', 23),
(280, 'Rodriguez', '1860', 23),
(281, 'Antipolo', '1870', 23),
(282, 'Teresa', '1880', 23),
(283, 'Cainta', '1900', 23),
(284, 'Pililla', '1910', 23),
(285, 'Taytay', '1920', 23),
(286, 'Angono', '1930', 23),
(287, 'Binangonan', '1940', 23),
(288, 'Cardona', '1950', 23),
(289, 'Morong', '1960', 23),
(290, 'Baras', '1970', 23),
(291, 'Tanay', '1980', 23),
(292, 'Jalajala', '1990', 23),
(293, 'San Pablo', '4000', 21),
(294, 'Alaminos', '4001', 21),
(295, 'Nagcarlan', '4002', 21),
(296, 'Rizal', '4003', 21),
(297, 'Liliw', '4004', 21),
(298, 'Majayjay', '4005', 21),
(299, 'Botocan', '4006', 21),
(300, 'Magdalena', '4007', 21),
(301, 'Pagsanjan', '4008', 21),
(302, 'Santa Cruz', '4009', 21),
(303, 'Pila', '4010', 21),
(304, 'Victoria', '4011', 21),
(305, 'Calauan', '4012', 21),
(306, 'Cavinti', '4013', 21),
(307, 'Lumban', '4014', 21),
(308, 'Kalayaan', '4015', 21),
(309, 'Paete', '4016', 21),
(310, 'Pakil', '4017', 21),
(311, 'Pangil', '4018', 21),
(312, 'Siniloan', '4019', 21),
(313, 'Mabitac', '4020', 21),
(314, 'Famy', '4021', 21),
(315, 'Santa Maria', '4022', 21),
(316, 'San Pedro', '4023', 21),
(317, 'Biñan', '4024', 21),
(318, 'Cabuyao', '4025', 21),
(319, 'Santa Rosa', '4026', 21),
(320, 'Calamba', '4027', 21),
(321, 'Canlubang', '4028', 21),
(322, 'Camp Vicente Lim', '4029', 21),
(323, 'Los Baños', '4030', 21),
(324, 'University of the Philippines Los Baños', '4031', 21),
(325, 'Luisiana', '4032', 21),
(326, 'Bay', '4033', 21),
(327, 'Cavite City', '4100', 20),
(328, 'Sangley Point Naval Base', '4101', 20),
(329, 'Bacoor', '4102', 20),
(330, 'Imus', '4103', 20),
(331, 'Kawit', '4104', 20),
(332, 'Noveleta', '4105', 20),
(333, 'Rosario', '4106', 20),
(334, 'General Trias', '4107', 20),
(335, 'Tanza', '4108', 20),
(336, 'Trece Martires', '4109', 20),
(337, 'Naic', '4110', 20),
(338, 'Ternate', '4111', 20),
(339, 'Maragondon', '4112', 20),
(340, 'Magallanes', '4113', 20),
(341, 'Dasmariñas', '4114', 20),
(342, 'Dasmariñas Resettlement Area', '4115', 20),
(343, 'Carmona', '4116', 20),
(344, 'General Mariano Alvarez', '4117', 20),
(345, 'Silang', '4118', 20),
(346, 'Amadeo', '4119', 20),
(347, 'Tagaytay', '4120', 20),
(348, 'Mendez (Mendez-Nuñez)', '4121', 20),
(349, 'Indang', '4122', 20),
(350, 'Alfonso', '4123', 20),
(351, 'General Emilio Aguinaldo (Bailen)', '4124', 20),
(352, 'Corregidor Island', '4125', 20),
(353, 'First Cavite Industrial Estate', '4126', 20),
(354, 'Batangas City', '4200', 19),
(355, 'Bauan', '4201', 19),
(356, 'Mabini', '4202', 19),
(357, 'Tingloy', '4203', 19),
(358, 'San Pascual', '4204', 19),
(359, 'Alitagtag', '4205', 19),
(360, 'Santa Teresita', '4206', 19),
(361, 'San Nicolas', '4207', 19),
(362, 'Taal', '4208', 19),
(363, 'Lemery', '4209', 19),
(364, 'San Luis', '4210', 19),
(365, 'Agoncillo', '4211', 19),
(366, 'Calaca', '4212', 19),
(367, 'Balayan', '4213', 19),
(368, 'Tuy', '4214', 19),
(369, 'Calatagan', '4215', 19),
(370, 'Lian', '4216', 19),
(371, 'Lipa', '4217', 19),
(372, 'Fernando Air Base', '4218', 19),
(373, 'Balete', '4219', 19),
(374, 'Talisay', '4220', 19),
(375, 'Laurel', '4221', 19),
(376, 'Cuenca', '4222', 19),
(377, 'Mataas na Kahoy', '4223', 19),
(378, 'Padre Garcia', '4224', 19),
(379, 'Rosario', '4225', 19),
(380, 'San Juan', '4226', 19),
(381, 'San Jose', '4227', 19),
(382, 'Taysan', '4228', 19),
(383, 'Lobo', '4229', 19),
(384, 'Ibaan', '4230', 19),
(385, 'Nasugbu', '4231', 19),
(386, 'Tanauan', '4232', 19),
(387, 'Malvar', '4233', 19),
(388, 'Santo Tomas', '4234', 19),
(389, 'Lucena', '4301', 22),
(390, 'Pagbilao', '4302', 22),
(391, 'Padre Burgos', '4303', 22),
(392, 'Agdangan', '4304', 22),
(393, 'Unisan', '4305', 22),
(394, 'Plaridel', '4306', 22),
(395, 'Gumaca', '4307', 22),
(396, 'Pitogo', '4308', 22),
(397, 'Macalelon', '4309', 22),
(398, 'General Luna', '4310', 22),
(399, 'Catanauan', '4311', 22),
(400, 'Mulanay', '4312', 22),
(401, 'San Narciso', '4313', 22),
(402, 'San Fernando', '2000', 12),
(403, 'Bacolor', '2001', 12),
(404, 'Santa Rita', '2002', 12),
(405, 'Guagua', '2003', 12),
(406, 'Sasmuan', '2004', 12),
(407, 'Lubao', '2005', 12),
(408, 'Floridablanca', '2006', 12),
(409, 'Basa Airbase', '2007', 12),
(410, 'Porac', '2008', 12),
(411, 'Angeles', '2009', 12),
(412, 'Mabalacat', '2010', 12),
(413, 'Magalang', '2011', 12),
(414, 'Arayat', '2012', 12),
(415, 'Candaba', '2013', 12),
(416, 'San Luis', '2014', 12),
(417, 'San Simon', '2015', 12),
(418, 'Apalit', '2016', 12),
(419, 'Masantol', '2017', 12),
(420, 'Macabebe', '2018', 12),
(421, 'Minalin', '2019', 12),
(422, 'Santo Tomas', '2020', 12),
(423, 'Mexico', '2021', 12),
(424, 'Santa Ana', '2022', 12),
(425, 'Balibago', '2024', 12),
(426, 'Balanga', '2100', 10),
(427, 'Pilar', '2101', 10),
(428, 'Orion', '2102', 10),
(429, 'Limay', '2103', 10),
(430, 'Lamao', '2104', 10),
(431, 'Mariveles', '2105', 10),
(432, 'Mariveles', '2106', 10),
(433, 'Bagac', '2107', 10),
(434, 'Morong', '2108', 10),
(435, 'Dinalupihan', '2110', 10),
(436, 'Hermosa', '2111', 10),
(437, 'Orani', '2112', 10),
(438, 'Samal', '2113', 10),
(439, 'Abucay', '2114', 10),
(440, 'Olongapo', '2200', 13),
(441, 'Iba', '2201', 13),
(442, 'Botolan', '2202', 13),
(443, 'Cabangan', '2203', 13),
(444, 'San Felipe', '2204', 13),
(445, 'San Narciso', '2205', 13),
(446, 'San Antonio', '2206', 13),
(447, 'San Marcelino', '2207', 13),
(448, 'Castillejos', '2208', 13),
(449, 'Subic', '2209', 13),
(450, 'Palauig and Scarborough Shoal', '2210', 13),
(451, 'Masinloc', '2211', 13),
(452, 'Candelaria', '2212', 13),
(453, 'Santa Cruz', '2213', 13),
(454, 'Tarlac City', '2300', 16),
(455, 'San Miguel', '2301', 16),
(456, 'Gerona', '2302', 16),
(457, 'Santa Ignacia', '2303', 16),
(458, 'Mayantoc', '2304', 16),
(459, 'San Clemente', '2305', 16),
(460, 'Camiling', '2306', 16),
(461, 'Paniqui', '2307', 16),
(462, 'Moncada', '2308', 16),
(463, 'San Manuel', '2309', 16),
(464, 'Anao', '2310', 16),
(465, 'Ramos', '2311', 16),
(466, 'Pura', '2312', 16),
(467, 'Victoria', '2313', 16),
(468, 'La Paz', '2314', 16),
(469, 'Capas', '2315', 16),
(470, 'Concepcion', '2316', 16),
(471, 'Bamban', '2317', 16),
(472, 'San Jose', '2318', 16),
(473, 'Malolos', '3000', 11),
(474, 'Paombong', '3001', 11),
(475, 'Hagonoy', '3002', 11),
(476, 'Calumpit', '3003', 11),
(477, 'Plaridel', '3004', 11),
(478, 'Pulilan', '3005', 11),
(479, 'Baliuag', '3006', 11),
(480, 'Bustos', '3007', 11),
(481, 'San Rafael', '3008', 11),
(482, 'Doña Remedios Trinidad', '3009', 11),
(483, 'San Ildefonso', '3010', 11),
(484, 'San Miguel', '3011', 11),
(485, 'Angat', '3012', 11),
(486, 'Norzagaray', '3013', 11),
(487, 'Pandi', '3014', 11),
(488, 'Guiguinto', '3015', 11),
(489, 'Balagtas (Bigaa)', '3016', 11),
(490, 'Bulacan', '3017', 11),
(491, 'Bocaue', '3018', 11),
(492, 'Marilao', '3019', 11),
(493, 'Meycauayan', '3020', 11),
(494, 'Obando', '3021', 11),
(495, 'Santa Maria', '3022', 11),
(496, 'San Jose del Monte', '3023', 11),
(497, 'Sapang Palay', '3024', 11),
(498, 'Cabanatuan', '3100', 14),
(499, 'Santa Rosa', '3101', 14),
(500, 'San Leonardo', '3102', 14),
(501, 'Peñaranda', '3103', 14),
(502, 'General Tinio', '3104', 14),
(503, 'Gapan', '3105', 14),
(504, 'San Isidro', '3106', 14),
(505, 'Cabiao', '3107', 14),
(506, 'San Antonio', '3108', 14),
(507, 'Jaen', '3109', 14),
(508, 'Zaragoza', '3110', 14),
(509, 'Aliaga', '3111', 14),
(510, 'Licab', '3112', 14),
(511, 'Quezon', '3113', 14),
(512, 'Talavera', '3114', 14),
(513, 'Guimba', '3115', 14),
(514, 'Nampicuan', '3116', 14),
(515, 'Cuyapo', '3117', 14),
(516, 'Talugtug', '3118', 14),
(517, 'Muñoz', '3119', 14),
(518, 'Central Luzon State University', '3120', 14),
(519, 'San Jose', '3121', 14),
(520, 'Lupao', '3122', 14),
(521, 'Carrangalan', '3123', 14),
(522, 'Pantabangan', '3124', 14),
(523, 'General Mamerto Natividad', '3125', 14),
(524, 'Llanera', '3126', 14),
(525, 'Rizal', '3127', 14),
(526, 'Bongabon', '3128', 14),
(527, 'Laur', '3129', 14),
(528, 'Fort Magsaysay', '3130', 14),
(529, 'Gabaldon', '3131', 14),
(530, 'Palayan', '3132', 14),
(531, 'Santo Domingo', '3133', 14),
(532, 'Baler', '3200', 18),
(533, 'San Luis', '3201', 18),
(534, 'Maria Aurora', '3202', 18),
(535, 'Dipaculao', '3203', 18),
(536, 'Casiguran', '3204', 18),
(537, 'Dilasag', '3205', 18),
(538, 'Dinalungan', '3206', 18),
(539, 'Dingalan', '3207', 18),
(540, 'Cebu City', '6000', 37),
(541, 'Consolacion', '6001', 37),
(542, 'Liloan', '6002', 37),
(543, 'Compostela', '6003', 37),
(544, 'Danao', '6004', 37),
(545, 'Carmen', '6005', 37),
(546, 'Catmon', '6006', 37),
(547, 'Sogod', '6007', 37),
(548, 'Borbon', '6008', 37),
(549, 'Tabogon', '6009', 37),
(550, 'Bogo', '6010', 37),
(551, 'San Remigio', '6011', 37),
(552, 'Medellin', '6012', 37),
(553, 'Daanbantayan', '6013', 37),
(554, 'Mandaue', '6014', 37),
(555, 'Lapu-Lapu (Opon)', '6015', 37),
(556, 'Mactan Airport', '6016', 37),
(557, 'Cordova', '6017', 37),
(558, 'San Fernando', '6018', 37),
(559, 'Carcar', '6019', 37),
(560, 'Sibonga', '6020', 37),
(561, 'Argao', '6021', 37),
(562, 'Dalaguete', '6022', 37),
(563, 'Alcoy', '6023', 37),
(564, 'Boljoon', '6024', 37),
(565, 'Oslob', '6025', 37),
(566, 'Santander', '6026', 37),
(567, 'Samboan', '6027', 37),
(568, 'Ginatilan', '6028', 37),
(569, 'Malabuyoc', '6029', 37),
(570, 'Alegria', '6030', 37),
(571, 'Badian', '6031', 37),
(572, 'Moalboal', '6032', 37),
(573, 'Alcantara', '6033', 37),
(574, 'Ronda', '6034', 37),
(575, 'Dumanjug', '6035', 37),
(576, 'Barili', '6036', 37),
(577, 'Naga', '6037', 37),
(578, 'Toledo', '6038', 37),
(579, 'Pinamungajan', '6039', 37),
(580, 'Aloguinsan', '6040', 37),
(581, 'Balamban', '6041', 37),
(582, 'Asturias', '6042', 37),
(583, 'Tuburan', '6043', 37),
(584, 'Tabuelan', '6044', 37),
(585, 'Talisay', '6045', 37),
(586, 'Minglanilla', '6046', 37),
(587, 'Santa Fe', '6047', 37),
(588, 'Pilar', '6048', 37),
(589, 'Poro', '6049', 37),
(590, 'San Francisco', '6050', 37),
(591, 'Tudela', '6051', 37),
(592, 'Bantayan', '6052', 37),
(593, 'Madridejos', '6053', 37),
(594, 'Dumaguete', '6200', 38),
(595, 'Sibulan', '6201', 38),
(596, 'San Jose', '6202', 38),
(597, 'Amlan', '6203', 38),
(598, 'Tanjay', '6204', 38),
(599, 'Pamplona', '6205', 38),
(600, 'Bais', '6206', 38),
(601, 'Mabinay', '6207', 38),
(602, 'Manjuyod', '6208', 38),
(603, 'Bindoy', '6209', 38),
(604, 'Ayungon', '6210', 38),
(605, 'Tayasan', '6211', 38),
(606, 'Jimalalud', '6212', 38),
(607, 'La Libertad', '6213', 38),
(608, 'Guihulngan', '6214', 38),
(609, 'Valencia', '6215', 38),
(610, 'Bacong', '6216', 38),
(611, 'Dauin', '6217', 38),
(612, 'Zamboanguita', '6218', 38),
(613, 'Siaton', '6219', 38),
(614, 'Santa Catalina', '6220', 38),
(615, 'Bayawan', '6221', 38),
(616, 'Basay', '6222', 38),
(617, 'Canlaon', '6223', 38),
(618, 'Vallehermoso', '6224', 38),
(619, 'Siquijor', '6225', 39),
(620, 'Larena', '6226', 39),
(621, 'San Juan', '6227', 39),
(622, 'Lazi', '6228', 39),
(623, 'Maria', '6229', 39),
(624, 'Enrique Villanueva', '6230', 39),
(625, 'Tagbilaran', '6300', 36),
(626, 'Baclayon', '6301', 36),
(627, 'Alburquerque', '6302', 36),
(628, 'Loay', '6303', 36),
(629, 'Lila', '6304', 36),
(630, 'Dimiao', '6305', 36),
(631, 'Valencia', '6306', 36),
(632, 'Garcia Hernandez', '6307', 36),
(633, 'Jagna', '6308', 36),
(634, 'Duero', '6309', 36),
(635, 'Guindulman', '6310', 36),
(636, 'Anda', '6311', 36),
(637, 'Candijay', '6312', 36),
(638, 'Mabini', '6313', 36),
(639, 'Alicia', '6314', 36),
(640, 'Ubay', '6315', 36),
(641, 'Loboc', '6316', 36),
(642, 'Bilar', '6317', 36),
(643, 'Batuan', '6318', 36),
(644, 'Carmen', '6319', 36),
(645, 'Sierra Bullones', '6320', 36),
(646, 'Pilar', '6321', 36),
(647, 'Dagohoy', '6322', 36),
(648, 'San Miguel', '6323', 36),
(649, 'Trinidad', '6324', 36),
(650, 'Talibon', '6325', 36),
(651, 'Bien Unido', '6326', 36),
(652, 'Loon', '6327', 36),
(653, 'Calape', '6328', 36),
(654, 'Tubigon', '6329', 36),
(655, 'Clarin', '6330', 36),
(656, 'Sagbayan', '6331', 36),
(657, 'Inabanga', '6332', 36),
(658, 'Buenavista', '6333', 36),
(659, 'Jetafe', '6334', 36),
(660, 'Antequera', '6335', 36),
(661, 'Maribojoc', '6336', 36),
(662, 'Corella', '6337', 36),
(663, 'Sikatuna', '6338', 36),
(664, 'Dauis', '6339', 36),
(665, 'Panglao', '6340', 36),
(666, 'Cortes', '6341', 36),
(667, 'Balilihan', '6342', 36),
(668, 'Catigbian', '6343', 36),
(669, 'Danao', '6344', 36),
(670, 'San Isidro', '6345', 36),
(671, 'Pres. Carlos P. Garcia (Pitogo)', '6346', 36),
(672, 'Sevilla', '6347', 36),
(673, 'Baguio', '2600', 70),
(674, 'La Trinidad', '2601', 70),
(675, 'Philippine Military Academy', '2602', 70),
(676, 'Tuba', '2603', 70),
(677, 'Itogon', '2604', 70),
(678, 'Bokod', '2605', 70),
(679, 'Kabayan', '2606', 70),
(680, 'Buguias', '2607', 70),
(681, 'Mankayan', '2608', 70),
(682, 'Lepanto', '2609', 70),
(683, 'Bakun', '2610', 70),
(684, 'Kibungan', '2611', 70),
(685, 'Atok', '2612', 70),
(686, 'Kapangan', '2613', 70),
(687, 'Sablan', '2614', 70),
(688, 'Tublay', '2615', 70),
(689, 'Bontoc', '2616', 73),
(690, 'Sadanga', '2617', 73),
(691, 'Besao', '2618', 73),
(692, 'Sagada', '2619', 73),
(693, 'Tadian', '2620', 73),
(694, 'Bauko', '2621', 73),
(695, 'Sabangan', '2622', 73),
(696, 'Barlig', '2623', 73),
(697, 'Natonin', '2624', 73),
(698, 'Paracelis', '2625', 73),
(699, 'Bangued', '2800', 69),
(700, 'Dolores', '2801', 69),
(701, 'Lagangilang', '2802', 69),
(702, 'Tayum', '2803', 69),
(703, 'Peñarrubia', '2804', 69),
(704, 'Bucay', '2805', 69),
(705, 'Pidigan', '2806', 69),
(706, 'Langiden', '2807', 69),
(707, 'San Quintin', '2808', 69),
(708, 'San Isidro', '2809', 69),
(709, 'Manabo', '2810', 69),
(710, 'Villaviciosa', '2811', 69),
(711, 'Pilar', '2812', 69),
(712, 'Luba', '2813', 69),
(713, 'Tubo', '2814', 69),
(714, 'Boliney', '2815', 69),
(715, 'Daguioman', '2816', 69),
(716, 'Bucloc', '2817', 69),
(717, 'Sallapadan', '2818', 69),
(718, 'Licuan-Baay', '2819', 69),
(719, 'Malibcong', '2820', 69),
(720, 'Lacub', '2821', 69),
(721, 'Tineg', '2822', 69),
(722, 'San Juan', '2823', 69),
(723, 'Lagayan', '2824', 69),
(724, 'Danglas', '2825', 69),
(725, 'La Paz', '2826', 69),
(726, 'Lagawe', '3600', 72),
(727, 'Banaue', '3601', 72),
(728, 'Mayoyao (Mayaoyao)', '3602', 72),
(729, 'Hungduan', '3603', 72),
(730, 'Kiangan', '3604', 72),
(731, 'Lamut', '3605', 72),
(732, 'Aguinaldo', '3606', 72),
(733, 'Hingyon', '3607', 72),
(734, 'Alfonso Lista (Potia)', '3608', 72),
(735, 'Tinoc', '3609', 72),
(736, 'Asipulo', '3610', 72),
(737, 'Tabuk', '3800', 72),
(738, 'Balbalan', '3801', 72),
(739, 'Lubuagan', '3802', 72),
(740, 'Pasil', '3803', 72),
(741, 'Tinglayan', '3804', 72),
(742, 'Tanudan', '3805', 72),
(743, 'Pinukpuk', '3806', 72),
(744, 'Conner', '3807', 74),
(745, 'Rizal (Liwan)', '3808', 72),
(746, 'Kabugao', '3809', 74),
(747, 'Flora', '3810', 74),
(748, 'Santa Marcela', '3811', 74),
(749, 'Pudtol', '3812', 74),
(750, 'Luna', '3813', 74),
(751, 'Calanasan (Bayag)', '3814', 74),
(752, 'Davao City', '8000', 56),
(753, 'Santa Cruz', '8001', 56),
(754, 'Digos', '8002', 56),
(755, 'Matanao', '8003', 56),
(756, 'Magsaysay', '8004', 56),
(757, 'Bansalan', '8005', 56),
(758, 'Hagonoy', '8006', 56),
(759, 'Padada', '8007', 56),
(760, 'Kiblawan', '8008', 56),
(761, 'Sulop', '8009', 56),
(762, 'Malalag', '8010', 56),
(763, 'Santa Maria', '8011', 59),
(764, 'Malita', '8012', 59),
(765, 'Don Marcelino', '8013', 59),
(766, 'Jose Abad Santos', '8014', 59),
(767, 'Sarangani', '8015', 59),
(768, 'Tagum', '8100', 55),
(769, 'Carmen', '8101', 55),
(770, 'Asuncion', '8102', 55),
(771, 'New Corella', '8104', 55),
(772, 'Panabo', '8105', 55),
(773, 'Santo Tomas', '8112', 55),
(774, 'Kapalong', '8113', 55),
(775, 'Babak', '8118', 55),
(776, 'Samal', '8119', 55),
(777, 'Kaputian', '8120', 55),
(778, 'Mati', '8200', 57),
(779, 'Tarragona', '8201', 57),
(780, 'Manay', '8202', 57),
(781, 'Caraga', '8203', 57),
(782, 'Baganga', '8204', 57),
(783, 'Cateel', '8205', 57),
(784, 'Boston', '8206', 57),
(785, 'Lupon', '8207', 57),
(786, 'Banaybanay', '8208', 57),
(787, 'San Isidro', '8209', 57),
(788, 'Governor Generoso', '8210', 57),
(789, 'Nabunturan', '8800', 57),
(790, 'Montevista', '8801', 57),
(791, 'Mawab', '8802', 57),
(792, 'Compostela', '8803', 57),
(793, 'New Bataan', '8804', 57),
(794, 'Monkayo', '8805', 57),
(795, 'Maco', '8806', 57),
(796, 'Mabini (Doña Alicia)', '8807', 57),
(797, 'Maragusan (San Mariano)', '8808', 57),
(798, 'Pantukan', '8809', 57),
(799, 'Laak (San Vicente)', '8810', 57),
(800, 'Catarman', '6400', 42),
(801, 'Bobon', '6401', 42),
(802, 'San Jose', '6402', 42),
(803, 'Lope de Vega', '6403', 42),
(804, 'Lavezares', '6404', 42),
(805, 'Allen', '6405', 42),
(806, 'Victoria', '6406', 42),
(807, 'San Antonio', '6407', 42),
(808, 'Capul', '6408', 42),
(809, 'San Isidro', '6409', 42),
(810, 'Biri', '6410', 42),
(811, 'Laoang', '6411', 42),
(812, 'Mapanas', '6412', 42),
(813, 'Pambujan', '6413', 42),
(814, 'Silvino Lobos', '6414', 42),
(815, 'San Roque', '6415', 42),
(816, 'Rosario', '6416', 42),
(817, 'Mondragon', '6417', 42),
(818, 'Catubig', '6418', 42),
(819, 'San Vicente', '6419', 42),
(820, 'Las Navas', '6420', 42),
(821, 'Palapag', '6421', 42),
(822, 'Gamay', '6422', 42),
(823, 'Lapinig', '6423', 42),
(824, 'Tacloban', '6500', 41),
(825, 'Palo', '6501', 41),
(826, 'Tanauan', '6502', 41),
(827, 'Tolosa', '6503', 41),
(828, 'Tabontabon', '6504', 41),
(829, 'Dulag', '6505', 41),
(830, 'Julita', '6506', 41),
(831, 'Mayorga', '6507', 41),
(832, 'La Paz', '6508', 41),
(833, 'MacArthur', '6509', 41),
(834, 'Abuyog', '6510', 41),
(835, 'Javier', '6511', 41),
(836, 'Mahaplag', '6512', 41),
(837, 'Santa Fe', '6513', 41),
(838, 'Pastrana', '6514', 41),
(839, 'Dagami', '6515', 41),
(840, 'Burauen', '6516', 41),
(841, 'Alangalang', '6517', 41),
(842, 'San Miguel', '6518', 41),
(843, 'Barugo', '6519', 41),
(844, 'Babatngon', '6520', 41),
(845, 'Baybay', '6521', 41),
(846, 'Inopacan', '6522', 41),
(847, 'Hindang', '6523', 41),
(848, 'Hilongos', '6524', 41),
(849, 'Bato', '6525', 41),
(850, 'Matalom', '6526', 41),
(851, 'Jaro', '6527', 41),
(852, 'Tunga', '6528', 41),
(853, 'Carigara', '6529', 41),
(854, 'Capoocan', '6530', 41),
(855, 'Kananga', '6531', 41),
(856, 'Matag-ob', '6532', 41),
(857, 'Leyte', '6533', 41),
(858, 'Calubian', '6534', 41),
(859, 'San Isidro', '6535', 41),
(860, 'Tabango', '6536', 41),
(861, 'Villaba', '6537', 41),
(862, 'Palompon', '6538', 41),
(863, 'Isabel', '6539', 41),
(864, 'Merida', '6540', 41),
(865, 'Ormoc', '6541', 41),
(866, 'Albuera', '6542', 41),
(867, 'Naval', '6543', 45),
(868, 'Almeria', '6544', 45),
(869, 'Kawayan', '6545', 45),
(870, 'Maripipi', '6546', 45),
(871, 'Culaba', '6547', 45),
(872, 'Caibiran', '6548', 45),
(873, 'Biliran', '6549', 45),
(874, 'Cabucgayan', '6550', 45),
(875, 'Maasin', '6600', 44),
(876, 'Macrohon', '6601', 44),
(877, 'Padre Burgos', '6602', 44),
(878, 'Malitbog', '6603', 44),
(879, 'Bontoc', '6604', 44),
(880, 'Tomas Oppus', '6605', 44),
(881, 'Sogod', '6606', 44),
(882, 'Silago', '6607', 44),
(883, 'Hinunangan', '6608', 44),
(884, 'Hinundayan', '6609', 44),
(885, 'Anahawan', '6610', 44),
(886, 'San Juan (Cabalian)', '6611', 44),
(887, 'Liloan', '6612', 44),
(888, 'San Francisco', '6613', 44),
(889, 'Pintuyan', '6614', 44),
(890, 'Libagon', '6615', 44),
(891, 'Saint Bernard', '6616', 44),
(892, 'San Ricardo', '6617', 44),
(893, 'Limasawa', '6618', 44),
(894, 'Catbalogan', '6700', 43),
(895, 'Jiabong', '6701', 43),
(896, 'Motiong', '6702', 43),
(897, 'Paranas (Wright)', '6703', 43),
(898, 'Tarangnan', '6704', 43),
(899, 'Pagsanghan', '6705', 43),
(900, 'Gandara', '6706', 43),
(901, 'San Jorge', '6707', 43),
(902, 'Matuguinao', '6708', 43),
(903, 'Santa Margarita', '6709', 43),
(904, 'Calbayog', '6710', 43),
(905, 'Santo Niño', '6711', 43),
(906, 'Tagapul-an', '6712', 43),
(907, 'Hinabangan', '6713', 43),
(908, 'San Sebastian', '6714', 43),
(909, 'Calbiga', '6715', 43),
(910, 'Pinabacdao', '6716', 43),
(911, 'Villareal', '6717', 43),
(912, 'Santa Rita', '6718', 43),
(913, 'Talalora', '6719', 43),
(914, 'Basey', '6720', 43),
(915, 'Marabut', '6721', 43),
(916, 'Daram', '6722', 43),
(917, 'San Jose De Buan', '6723', 43),
(918, 'Almagro', '6724', 43),
(919, 'Zumarraga', '6725', 43),
(920, 'Borongan', '6800', 40),
(921, 'Balangkayan', '6801', 40),
(922, 'Maydolong', '6802', 40),
(923, 'Llorente', '6803', 40),
(924, 'Hernani', '6804', 40),
(925, 'General MacArthur', '6805', 40),
(926, 'Can-avid', '6806', 40),
(927, 'Salcedo', '6807', 40),
(928, 'Mercedes', '6808', 40),
(929, 'Guiuan', '6809', 40),
(930, 'Quinapondan', '6810', 40),
(931, 'Giporlos', '6811', 40),
(932, 'Balangiga', '6812', 40),
(933, 'Lawaan', '6813', 40),
(934, 'San Julian', '6814', 40),
(935, 'Sulat', '6815', 40),
(936, 'Taft', '6816', 40),
(937, 'Dolores', '6817', 40),
(938, 'Oras', '6818', 40),
(939, 'Jipapad', '6819', 40),
(940, 'Maslog', '6820', 40),
(941, 'San Policarpo', '6821', 40),
(942, 'Arteche', '6822', 40),
(943, 'Dagupan', '2400', 4),
(944, 'Lingayen', '2401', 4),
(945, 'Labrador', '2402', 4),
(946, 'Sual', '2403', 4),
(947, 'Alaminos', '2404', 4),
(948, 'Anda', '2405', 4),
(949, 'Bolinao', '2406', 4),
(950, 'Bani', '2407', 4),
(951, 'Agno', '2408', 4),
(952, 'Mabini', '2409', 4),
(953, 'Burgos', '2410', 4),
(954, 'Dasol', '2411', 4),
(955, 'Infanta', '2412', 4),
(956, 'Mangatarem', '2413', 4),
(957, 'Urbiztondo', '2414', 4),
(958, 'Aguilar', '2415', 4),
(959, 'Bugallon', '2416', 4),
(960, 'Binmaley', '2417', 4),
(961, 'Calasiao', '2418', 4),
(962, 'Santa Barbara', '2419', 4),
(963, 'San Carlos', '2420', 4),
(964, 'Malasiqui', '2421', 4),
(965, 'Basista', '2422', 4),
(966, 'Bayambang', '2423', 4),
(967, 'Bautista', '2424', 4),
(968, 'Alcala', '2425', 4),
(969, 'Santo Tomas', '2426', 4),
(970, 'Villasis', '2427', 4),
(971, 'Urdaneta', '2428', 4),
(972, 'Mapandan', '2429', 4),
(973, 'Manaoag', '2430', 4),
(974, 'San Jacinto', '2431', 4),
(975, 'Mangaldan', '2432', 4),
(976, 'San Fabian', '2433', 4),
(977, 'Sison', '2434', 4),
(978, 'Pozorrubio', '2435', 4),
(979, 'Binalonan', '2436', 4),
(980, 'Laoac', '2437', 4),
(981, 'San Manuel', '2438', 4),
(982, 'Asingan', '2439', 4),
(983, 'Santa Maria', '2440', 4),
(984, 'Rosales', '2441', 4),
(985, 'Balungao', '2442', 4),
(986, 'Umingan', '2443', 4),
(987, 'San Quintin', '2444', 4),
(988, 'Tayug', '2445', 4),
(989, 'Natividad', '2446', 4),
(990, 'San Nicolas', '2447', 4),
(991, 'San Fernando', '2500', 3),
(992, 'Bauang', '2501', 3),
(993, 'Caba', '2502', 3),
(994, 'Aringay', '2503', 3),
(995, 'Agoo', '2504', 3),
(996, 'Santo Tomas', '2505', 3),
(997, 'Rosario', '2506', 3),
(998, 'Rosario', '2507', 3),
(999, 'Pugo', '2508', 3),
(1000, 'Tubao', '2509', 3),
(1001, 'Burgos', '2510', 3),
(1002, 'Naguilian', '2511', 3),
(1003, 'Bagulin', '2512', 3),
(1004, 'San Gabriel', '2513', 3),
(1005, 'San Juan', '2514', 3),
(1006, 'Bacnotan', '2515', 3),
(1007, 'Santol', '2516', 3),
(1008, 'Balaoan', '2517', 3),
(1009, 'Luna', '2518', 3),
(1010, 'Bangar', '2519', 3),
(1011, 'Sudipen', '2520', 3),
(1012, 'Vigan', '2700', 2),
(1013, 'Santa Catalina', '2701', 2),
(1014, 'Caoayan', '2702', 2),
(1015, 'Santa', '2703', 2),
(1016, 'Narvacan', '2704', 2),
(1017, 'Santa Maria', '2705', 2),
(1018, 'San Esteban', '2706', 2),
(1019, 'Santiago', '2707', 2),
(1020, 'Banayoyo', '2708', 2),
(1021, 'Galimuyod', '2709', 2),
(1022, 'Candon', '2710', 2),
(1023, 'Salcedo (Baugen)', '2711', 2),
(1024, 'Santa Lucia', '2712', 2),
(1025, 'Santa Cruz', '2713', 2),
(1026, 'Tagudin', '2714', 2),
(1027, 'Suyo', '2715', 2),
(1028, 'Alilem', '2716', 2),
(1029, 'Sugpon', '2717', 2),
(1030, 'Cervantes', '2718', 2),
(1031, 'Sigay', '2719', 2),
(1032, 'Gregorio del Pilar', '2720', 2),
(1033, 'Quirino (Angkaki)', '2721', 2),
(1034, 'San Emilio', '2722', 2),
(1035, 'Lidlidda', '2723', 2),
(1036, 'Burgos', '2724', 2),
(1037, 'Nagbukel', '2725', 2),
(1038, 'San Vicente', '2726', 2),
(1039, 'Bantay', '2727', 2),
(1040, 'San Ildefonso', '2728', 2),
(1041, 'Santo Domingo', '2729', 2),
(1042, 'Magsingal', '2730', 2),
(1043, 'San Juan (Lapog)', '2731', 2),
(1044, 'Cabugao', '2732', 2),
(1045, 'Sinait', '2733', 2),
(1046, 'Laoag', '2900', 1),
(1047, 'San Nicolas', '2901', 1),
(1048, 'Paoay', '2902', 1),
(1049, 'Currimao', '2903', 1),
(1050, 'Badoc', '2904', 1),
(1051, 'Pinili', '2905', 1),
(1052, 'Batac', '2906', 1),
(1053, 'Marcos', '2907', 1),
(1054, 'Banna (Espiritu)', '2908', 1),
(1055, 'Nueva Era', '2909', 1),
(1056, 'Solsona', '2910', 1),
(1057, 'Carasi', '2911', 1),
(1058, 'Piddig', '2912', 1),
(1059, 'Dingras', '2913', 1),
(1060, 'Sarrat', '2914', 1),
(1061, 'Vintar', '2915', 1),
(1062, 'Bacarra', '2916', 1),
(1063, 'Pasuquin', '2917', 1),
(1064, 'Burgos', '2918', 1),
(1065, 'Pagudpud', '2919', 1),
(1066, 'Bangui', '2920', 1),
(1067, 'Dumalneg', '2921', 1),
(1068, 'Adams', '2922', 1),
(1069, 'Boac', '4900', 75),
(1070, 'Mogpog', '4901', 75),
(1071, 'Santa Cruz', '4902', 75),
(1072, 'Torrijos', '4903', 75),
(1073, 'Buenavista', '4904', 75),
(1074, 'Gasan', '4905', 75),
(1075, 'San Jose', '5100', 76),
(1076, 'Magsaysay', '5101', 76),
(1077, 'Calintaan', '5102', 76),
(1078, 'Rizal', '5103', 76),
(1079, 'Sablayan', '5104', 76),
(1080, 'Santa Cruz', '5105', 76),
(1081, 'Mamburao', '5106', 76),
(1082, 'Paluan', '5107', 76),
(1083, 'Abra de Ilog', '5108', 76),
(1084, 'Lubang', '5109', 76),
(1085, 'Tilik', '5110', 76),
(1086, 'Looc', '5111', 76),
(1087, 'Calapan', '5200', 77),
(1088, 'Baco', '5201', 77),
(1089, 'San Teodoro', '5202', 77),
(1090, 'Puerto Galera', '5203', 77),
(1091, 'Naujan', '5204', 77),
(1092, 'Victoria', '5205', 77),
(1093, 'Pola', '5206', 77),
(1094, 'Socorro', '5207', 77),
(1095, 'Pinamalayan', '5208', 77),
(1096, 'Gloria', '5209', 77),
(1097, 'Bansud', '5210', 77),
(1098, 'Bongabong', '5211', 77),
(1099, 'Roxas', '5212', 77),
(1100, 'Mansalay', '5213', 77),
(1101, 'Bulalacao', '5214', 77),
(1102, 'Puerto Princesa', '5300', 78),
(1103, 'Iwahig Penal Colony', '5301', 78),
(1104, 'Aborlan', '5302', 78),
(1105, 'Narra (Panacan)', '5303', 78),
(1106, 'Quezon', '5304', 78),
(1107, 'Brookes Point', '5305', 78),
(1108, 'Bataraza', '5306', 78),
(1109, 'Balabac', '5307', 78),
(1110, 'Roxas', '5308', 78),
(1111, 'San Vicente', '5309', 78),
(1112, 'Dumaran', '5310', 78),
(1113, 'Araceli', '5311', 78),
(1114, 'Taytay', '5312', 78),
(1115, 'El Nido (Bacuit)', '5313', 78),
(1116, 'Linapacan', '5314', 78),
(1117, 'Culion', '5315', 78),
(1118, 'Coron', '5316', 78),
(1119, 'Busuanga', '5317', 78),
(1120, 'Cuyo', '5318', 78),
(1121, 'Magsaysay', '5319', 78),
(1122, 'Agutaya', '5320', 78),
(1123, 'Cagayancillo', '5321', 78),
(1124, 'Kalayaan (Spratly Islands)', '5322', 78),
(1125, 'Rizal (Marcos)', '5323', 78),
(1126, 'Sofronio Española', '5324', 78),
(1127, 'Romblon', '5500', 79),
(1128, 'San Agustin', '5501', 79),
(1129, 'Santa Maria (Imelda)', '5502', 79),
(1130, 'Calatrava', '5503', 79),
(1131, 'San Andres', '5504', 79),
(1132, 'Odiongan', '5505', 79),
(1133, 'Ferrol', '5506', 79),
(1134, 'Looc', '5507', 79),
(1135, 'Santa Fe', '5508', 79),
(1136, 'Alcantara', '5509', 79),
(1137, 'San Jose', '5510', 79),
(1138, 'Magdiwang', '5511', 79),
(1139, 'Cajidiocan', '5512', 79),
(1140, 'San Fernando', '5513', 79),
(1141, 'Corcuera', '5514', 79),
(1142, 'Banton (Jones)', '5515', 79),
(1143, 'Concepcion', '5516', 79),
(1144, 'Manila Central Post Office', '1000', 65),
(1145, 'Quiapo', '1001', 65),
(1146, 'Intramuros', '1002', 65),
(1147, 'Santa Cruz (South)', '1003', 65),
(1148, 'Malate', '1004', 65),
(1149, 'San Miguel', '1005', 65),
(1150, 'Binondo', '1006', 65),
(1151, 'Paco', '1007', 65),
(1152, 'Sampaloc (East)', '1008', 65),
(1153, 'Santa Ana', '1009', 65),
(1154, 'San Nicolas', '1010', 65),
(1155, 'Pandacan', '1011', 65),
(1156, 'Tondo (South)', '1012', 65),
(1157, 'Tondo (North)', '1013', 65),
(1158, 'Santa Cruz (North)', '1014', 65),
(1159, 'Sampaloc (West)', '1015', 65),
(1160, 'Santa Mesa', '1016', 65),
(1161, 'San Andres', '1017', 65),
(1162, 'Port Area (South)', '1018', 65),
(1163, 'Central', '1100', 65),
(1164, 'Botocan', '1101', 65),
(1165, 'Amihan', '1102', 65),
(1166, 'Kamuning', '1103', 65),
(1167, 'Damayan', '1104', 65),
(1168, 'Alicia', '1105', 65),
(1169, 'Apolonio Samson', '1106', 65),
(1170, 'New Era', '1107', 65),
(1171, 'Loyola Heights', '1108', 65),
(1172, 'Bagumbuhay', '1109', 65),
(1173, 'Bagumbayan', '1110', 65),
(1174, 'Bagong Lipunan', '1111', 65),
(1175, 'Damayang Lagi', '1112', 65),
(1176, 'Don Manuel', '1113', 65),
(1177, 'N.S Amoranto (Gintong Silahis)', '1114', 65),
(1178, 'Balingasa', '1115', 65),
(1179, 'Bagbag', '1116', 65),
(1180, 'Capri', '1117', 65),
(1181, 'Fairview', '1118', 65),
(1182, 'Bagong Silangan', '1119', 65),
(1183, 'BF Homes', '1120', 65),
(1184, 'Commonwealth', '1121', 65),
(1185, 'Fairview (South)', '1122', 65),
(1186, 'Damong Maliit', '1123', 65),
(1187, 'Kaligayahan', '1124', 65),
(1188, 'Doña Faustina Subdivision', '1125', 65),
(1189, 'Batasan Hills', '1126', 65),
(1190, 'Holy Spirit', '1127', 65),
(1191, 'Culiat', '1128', 65),
(1192, 'San Antonio Village', '1203', 65),
(1193, 'La Paz', '1204', 65),
(1194, 'Santa Cruz', '1205', 65),
(1195, 'Kasilawan', '1206', 65),
(1196, 'Carmona–Olympia', '1207', 65),
(1197, 'Valenzuela', '1208', 65),
(1198, 'Bel-Air', '1209', 65),
(1199, 'Poblacion', '1210', 65),
(1200, 'Guadalupe Viejo', '1211', 65),
(1201, 'Guadalupe Nuevo', '1212', 65),
(1202, 'Pinagkaisahan–Pitogo', '1213', 65),
(1203, 'Cembo and South Cembo', '1214', 65),
(1204, 'West Rembo', '1215', 65),
(1205, 'East Rembo–Malapad na Bato', '1216', 65),
(1206, 'Comembo', '1217', 65),
(1207, 'Pembo', '1218', 65),
(1208, 'Forbes Park North', '1219', 65),
(1209, 'Forbes Park South', '1220', 65),
(1210, 'Dasmariñas Village North', '1221', 65),
(1211, 'Dasmariñas Village South', '1222', 65),
(1212, 'San Lorenzo Village', '1223', 65),
(1213, 'Urdaneta Village', '1225', 65),
(1214, 'Ayala Avenue–Paseo de Roxas', '1226', 65),
(1215, 'Salcedo Village', '1227', 65),
(1216, 'Greenbelt', '1228', 65),
(1217, 'Legaspi Village', '1229', 65),
(1218, 'Pio del Pilar', '1230', 65),
(1219, 'Magallanes Village', '1232', 65),
(1220, 'Bangkal', '1233', 65),
(1221, 'San Isidro', '1234', 65),
(1222, 'Palanan', '1235', 65),
(1223, 'San Rafael', '1302', 65),
(1224, 'San Roque', '1303', 65),
(1225, 'Santa Clara', '1304', 65),
(1226, 'San Jose', '1305', 65),
(1227, 'San Isidro', '1306', 65),
(1228, 'Villamor Airbase', '1309', 65),
(1229, 'Baesa', '1401', 65),
(1230, 'Santa Quiteria', '1402', 65),
(1231, 'Grace Park East', '1403', 65),
(1232, 'San Jose', '1404', 65),
(1233, 'First Avenue–Seventh Avenue West', '1405', 65),
(1234, 'Grace Park West', '1406', 65),
(1235, 'University Hills', '1407', 65),
(1236, 'Sangandaan', '1408', 65),
(1237, 'Kaunlaran Village', '1409', 65),
(1238, 'Maypajo', '1410', 65),
(1239, 'Kapitbahayan', '1413', 65),
(1240, 'Laguna', '1420', 65),
(1241, 'Bagumbong–Villa Crystal', '1421', 65),
(1242, 'Novaliches', '1422', 65),
(1243, 'Lilles Ville Subdivision', '1423', 65),
(1244, 'Capitol Parkland Subdivision', '1424', 65),
(1245, 'Amparo Subdivision and Dela Costa Homes II Subdivision', '1425', 65),
(1246, 'Bankers Village', '1426', 65),
(1247, 'Tala Leprosarium–Victory Heights', '1427', 65),
(1248, 'Bagong Silang', '1428', 65),
(1249, 'Karuhatan–Parada', '1441', 65),
(1250, 'Fortune Village', '1442', 65),
(1251, 'Dalandanan–West Canumay', '1443', 65),
(1252, 'Arkong Bato', '1444', 65),
(1253, 'Balangkas–Coloong', '1445', 65),
(1254, 'Lingunan', '1446', 65),
(1255, 'East Canumay–Lawang Bato Punturin', '1447', 65),
(1256, 'Mapulang Lupa', '1448', 65),
(1257, 'Malabon', '1470', 65),
(1258, 'Catmon', '1471', 65),
(1259, 'Longos', '1472', 65),
(1260, 'Tonsuya', '1473', 65),
(1261, 'Acacia', '1474', 65),
(1262, 'Potrero', '1475', 65),
(1263, 'Araneta Subdivision', '1476', 65),
(1264, 'Maysilo', '1477', 65),
(1265, 'Santolan', '1478', 65),
(1266, 'Muzon', '1479', 65),
(1267, 'Dampalit', '1480', 65),
(1268, 'Navotas', '1485', 65),
(1269, 'Tangos', '1489', 65),
(1270, 'Tanza', '1490', 65),
(1271, 'San Juan Central Post Office', '1500', 65),
(1272, 'Greenhills (North)', '1503', 65),
(1273, 'Eisenhower–Crame', '1504', 65),
(1274, 'Vergara', '1551', 65),
(1275, 'Shaw Boulevard', '1552', 65),
(1276, 'National Center for Mental Health', '1553', 65),
(1277, 'EDSA', '1554', 65),
(1278, 'Wack Wack', '1555', 65),
(1279, 'Greenhills South', '1556', 65),
(1280, 'San Joaquin', '1601', 65),
(1281, 'Pinagbuhatan', '1602', 65),
(1282, 'Kapitolyo', '1603', 65),
(1283, 'Ugong', '1604', 65),
(1284, 'Caniogan', '1606', 65),
(1285, 'Maybunga', '1607', 65),
(1286, 'Santa Lucia', '1608', 65),
(1287, 'Rosario', '1609', 65),
(1288, 'Santolan', '1610', 65),
(1289, 'Manggahan', '1611', 65),
(1290, 'Green Park', '1612', 65),
(1291, 'Aguhos', '1620', 65),
(1292, 'Santa Ana', '1621', 65),
(1293, 'Bagumbayan–Pinagsama', '1630', 65),
(1294, 'Bicutan', '1631', 65),
(1295, 'Lower Bicutan–Ususan', '1632', 65),
(1296, 'Upper Bicutan', '1633', 65),
(1297, 'Nichols–McKinley (Bonifacio Global City)', '1634', 65),
(1298, 'Bay Breeze Executive Village', '1636', 65),
(1299, 'Ibayo–Tipas', '1637', 65),
(1300, 'Ligid', '1638', 65),
(1301, 'Tambulig', '7025', 53),
(1302, 'Ozamiz', '7200', 53),
(1303, 'Clarin', '7201', 53),
(1304, 'Tudela', '7202', 53),
(1305, 'Sinacaban', '7203', 53),
(1306, 'Jimenez', '7204', 53),
(1307, 'Panaon', '7205', 53),
(1308, 'Aloran', '7206', 53),
(1309, 'Oroquieta', '7207', 53),
(1310, 'Lopez Jaena', '7208', 53),
(1311, 'Plaridel', '7209', 53),
(1312, 'Calamba', '7210', 53),
(1313, 'Baliangao', '7211', 53),
(1314, 'Sapang Dalaga', '7212', 53),
(1315, 'Concepcion', '7213', 53),
(1316, 'Tangub', '7214', 53),
(1317, 'Bonifacio', '7215', 53),
(1318, 'Malaybalay', '8700', 50),
(1319, 'Sumilao', '8701', 50),
(1320, 'Impasugong', '8702', 50),
(1321, 'Manolo Fortich', '8703', 50),
(1322, 'Malitbog', '8704', 50),
(1323, 'Camp Phillips', '8705', 50),
(1324, 'Libona', '8706', 50),
(1325, 'Baungon', '8707', 50),
(1326, 'Talakag', '8708', 50),
(1327, 'Valencia', '8709', 50),
(1328, 'Musuan', '8710', 50),
(1329, 'San Fernando', '8711', 50),
(1330, 'Don Carlos', '8712', 50),
(1331, 'Kadingilan', '8713', 50),
(1332, 'Maramag', '8714', 50),
(1333, 'Quezon', '8715', 50),
(1334, 'Kitaotao', '8716', 50),
(1335, 'Pangantucan', '8717', 50),
(1336, 'Kalilangan', '8718', 50),
(1337, 'Dangcagan', '8719', 50),
(1338, 'Kibawe', '8720', 50),
(1339, 'Damulog', '8721', 50),
(1340, 'Lantapan', '8722', 50),
(1341, 'Cabanglasan', '8723', 50),
(1342, 'Cagayan de Oro', '9000', 50),
(1343, 'Tagoloan', '9001', 54),
(1344, 'Villanueva', '9002', 54),
(1345, 'Jasaan', '9003', 54),
(1346, 'Claveria', '9004', 54),
(1347, 'Balingasag', '9005', 54),
(1348, 'Lagonglong', '9006', 54),
(1349, 'Salay', '9007', 54),
(1350, 'Binuangan', '9008', 54),
(1351, 'Sugbongcogon', '9009', 54),
(1352, 'Kinoguitan', '9010', 54),
(1353, 'Balingoan', '9011', 54),
(1354, 'Talisayan', '9012', 54),
(1355, 'Medina', '9013', 54),
(1356, 'Gingoog', '9014', 54),
(1357, 'Magsaysay', '9015', 54),
(1358, 'Opol', '9016', 54),
(1359, 'El Salvador', '9017', 54),
(1360, 'Alubijid', '9018', 54),
(1361, 'Laguindingan', '9019', 54),
(1362, 'Gitagum', '9020', 54),
(1363, 'Libertad', '9021', 54),
(1364, 'Initao', '9022', 54),
(1365, 'Naawan', '9023', 54),
(1366, 'Manticao', '9024', 54),
(1367, 'Lugait', '9025', 54),
(1368, 'Mambajao', '9100', 51),
(1369, 'Mahinog', '9101', 51),
(1370, 'Guinsiliban', '9102', 51),
(1371, 'Sagay', '9103', 51),
(1372, 'Catarman', '9104', 51),
(1373, 'Iligan', '9200', 52),
(1374, 'Linamon', '9201', 52),
(1375, 'Kauswagan', '9202', 52),
(1376, 'Matungao', '9203', 52),
(1377, 'Poona Piagapo', '9204', 52),
(1378, 'Bacolod', '9205', 52),
(1379, 'Maigo', '9206', 52),
(1380, 'Kolambugan', '9207', 52),
(1381, 'Pantao Ragat', '9208', 52),
(1382, 'Tubod', '9209', 52),
(1383, 'Baroy', '9210', 52),
(1384, 'Lala', '9211', 52),
(1385, 'Salvador', '9212', 52),
(1386, 'Sapad', '9213', 52),
(1387, 'Kapatagan', '9214', 52),
(1388, 'Sultan Naga Dimaporo (Karomatan)', '9215', 52),
(1389, 'Nunungan', '9216', 52),
(1390, 'Baloi', '9217', 52),
(1391, 'Munai', '9219', 52),
(1392, 'Tangcal', '9220', 52),
(1393, 'Magsaysay', '9221', 52),
(1394, 'Tagoloan', '9222', 52),
(1395, 'Tagoloan II', '9321', 52),
(1396, 'Kidapawan', '9400', 60),
(1397, 'Makilala', '9401', 60),
(1398, 'M Lang', '9402', 60),
(1399, 'Tulunan', '9403', 60),
(1400, 'Magpet', '9404', 60),
(1401, 'President Roxas', '9405', 60),
(1402, 'Matalam', '9406', 60),
(1403, 'Kabacan', '9407', 60),
(1404, 'Carmen', '9408', 60),
(1405, 'Pikit', '9409', 60),
(1406, 'Midsayap', '9410', 60),
(1407, 'Libungan', '9411', 60),
(1408, 'Pigkawayan', '9412', 60),
(1409, 'Alamada', '9413', 60),
(1410, 'Antipas', '9414', 60),
(1411, 'Aleosan', '9415', 60),
(1412, 'Banisilan', '9416', 60),
(1413, 'Arakan', '9417', 60),
(1414, 'General Santos (Dadiangas)', '9500', 61),
(1415, 'Alabel', '9501', 63),
(1416, 'Maasim', '9502', 63),
(1417, 'Malungon', '9503', 63),
(1418, 'Polomolok', '9504', 61),
(1419, 'Tupi', '9505', 61),
(1420, 'Koronadal', '9506', 61),
(1421, 'Tampakan', '9507', 61),
(1422, 'Norala', '9508', 61),
(1423, 'Santo Niño', '9509', 61),
(1424, 'Tantangan', '9510', 61),
(1425, 'Banga', '9511', 61),
(1426, 'Surallah', '9512', 61),
(1427, 'T Boli', '9513', 61),
(1428, 'Kiamba', '9514', 63),
(1429, 'Maitum', '9515', 63),
(1430, 'Malapatan', '9516', 63),
(1431, 'Glan', '9517', 63),
(1432, 'Tacurong', '9800', 62),
(1433, 'Columbio', '9801', 62),
(1434, 'Lambayong', '9802', 62),
(1435, 'Lutayan', '9803', 62),
(1436, 'President Quirino', '9804', 62),
(1437, 'Isulan', '9805', 62),
(1438, 'Esperanza', '9806', 62),
(1439, 'Lebak', '9807', 62),
(1440, 'Kalamansig', '9808', 62),
(1441, 'Palimbang', '9809', 62),
(1442, 'Bagumbayan', '9810', 62),
(1443, 'Senator Ninoy Aquino', '9811', 62),
(1444, 'Iloilo City', '5000', 33),
(1445, 'Pavia', '5001', 33),
(1446, 'Santa Barbara', '5002', 33),
(1447, 'Leganes', '5003', 33),
(1448, 'Zarraga', '5004', 33),
(1449, 'New Lucena', '5005', 33),
(1450, 'Dumangas', '5006', 33),
(1451, 'Barotac Nuevo', '5007', 33),
(1452, 'Pototan', '5008', 33),
(1453, 'Anilao', '5009', 33),
(1454, 'Banate', '5010', 33),
(1455, 'Barotac Viejo', '5011', 33),
(1456, 'Ajuy', '5012', 33),
(1457, 'Concepcion', '5013', 33),
(1458, 'Sara', '5014', 33),
(1459, 'San Dionisio', '5015', 33),
(1460, 'Batad', '5016', 33),
(1461, 'Estancia', '5017', 33),
(1462, 'Balasan', '5018', 33),
(1463, 'Carles', '5019', 33),
(1464, 'Oton', '5020', 33),
(1465, 'Tigbauan', '5021', 33),
(1466, 'Guimbal', '5022', 33),
(1467, 'Miagao', '5023', 33),
(1468, 'San Joaquin', '5024', 33),
(1469, 'San Miguel', '5025', 33),
(1470, 'Leon', '5026', 33),
(1471, 'Tubungan', '5027', 33),
(1472, 'Alimodian', '5028', 33),
(1473, 'Igbaras', '5029', 33),
(1474, 'Maasin', '5030', 33),
(1475, 'Cabatuan', '5031', 33),
(1476, 'Mina', '5032', 33),
(1477, 'Badiangan', '5033', 33),
(1478, 'Janiuay', '5034', 33),
(1479, 'Dingle', '5035', 33),
(1480, 'San Enrique', '5036', 33),
(1481, 'Passi', '5037', 33),
(1482, 'Duenas', '5038', 33),
(1483, 'San Rafael', '5039', 33),
(1484, 'Calinog', '5040', 33),
(1485, 'Bingawan', '5041', 33),
(1486, 'Lambunao', '5042', 33),
(1487, 'Lemery', '5043', 33),
(1488, 'Buenavista', '5044', 32),
(1489, 'Jordan', '5045', 32),
(1490, 'Nueva Valencia', '5046', 32),
(1491, 'San Lorenzo', '5047', 32),
(1492, 'Sibunag', '5048', 32),
(1493, 'Kalibo', '5600', 30),
(1494, 'Banga', '5601', 30),
(1495, 'Libacao', '5602', 30),
(1496, 'Madalag', '5603', 30),
(1497, 'Numancia', '5604', 30),
(1498, 'Lezo', '5605', 30),
(1499, 'Malinao', '5606', 30),
(1500, 'Nabas', '5607', 30),
(1501, 'Malay', '5608', 30),
(1502, 'Buruanga', '5609', 30),
(1503, 'New Washington', '5610', 30),
(1504, 'Makato', '5611', 30),
(1505, 'Tangalan', '5612', 30),
(1506, 'Ibajay', '5613', 30),
(1507, 'Balete', '5614', 30),
(1508, 'Batan', '5615', 30),
(1509, 'Altavas', '5616', 30),
(1510, 'San Jose', '5700', 31),
(1511, 'Belison', '5701', 31),
(1512, 'Patnongon', '5702', 31),
(1513, 'Valderrama', '5703', 31),
(1514, 'Bugasong', '5704', 31),
(1515, 'Laua-an', '5705', 31),
(1516, 'Barbaza', '5706', 31),
(1517, 'Tibiao', '5707', 31),
(1518, 'Culasi', '5708', 31),
(1519, 'Sebaste', '5709', 31),
(1520, 'Libertad', '5710', 31),
(1521, 'Caluya', '5711', 31),
(1522, 'Pandan', '5712', 31),
(1523, 'Sibalom', '5713', 31),
(1524, 'San Remigio', '5714', 31),
(1525, 'Hamtic', '5715', 31),
(1526, 'Tobias Fornier (Dao)', '5716', 31),
(1527, 'Anini-y', '5717', 31),
(1528, 'Roxas', '5800', 32),
(1529, 'Pan-ay', '5801', 32),
(1530, 'Pontevedra', '5802', 32),
(1531, 'President Roxas', '5803', 32),
(1532, 'Pilar', '5804', 32),
(1533, 'Ivisan', '5805', 32),
(1534, 'Sapian', '5806', 32),
(1535, 'Mambusao', '5807', 32),
(1536, 'Jamindan', '5808', 32),
(1537, 'Ma-ayon', '5809', 32),
(1538, 'Dao', '5810', 32),
(1539, 'Cuartero', '5811', 32),
(1540, 'Dumarao', '5812', 32),
(1541, 'Dumalag', '5813', 32),
(1542, 'Tapaz', '5814', 32),
(1543, 'Panitan', '5815', 32),
(1544, 'Sigma', '5816', 32),
(1545, 'Bacolod', '6100', 34),
(1546, 'Bago', '6101', 34),
(1547, 'Pulupandan', '6102', 34),
(1548, 'Valladolid', '6103', 34),
(1549, 'San Enrique', '6104', 34),
(1550, 'Pontevedra', '6105', 34),
(1551, 'Hinigaran', '6106', 34),
(1552, 'Binalbagan', '6107', 34),
(1553, 'Himamaylan', '6108', 34),
(1554, 'Ilog', '6109', 34),
(1555, 'Candoni', '6110', 34),
(1556, 'Kabankalan', '6111', 34),
(1557, 'Cauayan', '6112', 34),
(1558, 'Sipalay', '6113', 34),
(1559, 'Hinoba-an', '6114', 34),
(1560, 'Talisay', '6115', 34),
(1561, 'Silay', '6116', 34),
(1562, 'Enrique B. Magalona', '6118', 34),
(1563, 'Victorias', '6119', 34),
(1564, 'Manapla', '6120', 34),
(1565, 'Cadiz', '6121', 34),
(1566, 'Sagay', '6122', 34),
(1567, 'Paraiso (Fabrica)', '6123', 34),
(1568, 'Escalante', '6124', 34),
(1569, 'Toboso', '6125', 34),
(1570, 'Calatrava', '6126', 34),
(1571, 'San Carlos', '6127', 34),
(1572, 'Isabela', '6128', 34),
(1573, 'Murcia', '6129', 34),
(1574, 'La Carlota', '6130', 34),
(1575, 'La Castellana', '6131', 34),
(1576, 'Moises Padilla', '6132', 34),
(1577, 'Zamboanga City', '7000', 47),
(1578, 'Ipil', '7001', 48),
(1579, 'Roseller T. Lim', '7002', 48),
(1580, 'Titay', '7003', 48),
(1581, 'Naga', '7004', 48),
(1582, 'Kabasalan', '7005', 48),
(1583, 'Siay', '7006', 48),
(1584, 'Imelda', '7007', 48),
(1585, 'Payao', '7008', 48),
(1586, 'Buug', '7009', 48),
(1587, 'Mabuhay', '7010', 48),
(1588, 'Bayog', '7011', 47),
(1589, 'Talusan', '7012', 48),
(1590, 'Kumalarang', '7013', 47),
(1591, 'Lakewood', '7014', 47),
(1592, 'Dumalinao', '7015', 47),
(1593, 'Pagadian', '7016', 47),
(1594, 'Labangan', '7017', 47),
(1595, 'Tungawan', '7018', 48),
(1596, 'Tukuran', '7019', 47),
(1597, 'Aurora', '7020', 47),
(1598, 'Midsalip', '7021', 47),
(1599, 'Sominot (Don Mariano Marcos)', '7022', 47),
(1600, 'Molave', '7023', 47),
(1601, 'Ramon Magsaysay (Liargo)', '7024', 47),
(1602, 'Mahayag', '7026', 47),
(1603, 'Josefina', '7027', 47),
(1604, 'Dumingag', '7028', 47),
(1605, 'San Miguel', '7029', 47),
(1606, 'Dinas', '7030', 47),
(1607, 'San Pablo', '7031', 47),
(1608, 'Dimataling', '7032', 47),
(1609, 'Pitogo', '7033', 47),
(1610, 'Tabina', '7034', 47),
(1611, 'Margosatubig', '7035', 47),
(1612, 'Vincenzo A. Sagun', '7036', 47),
(1613, 'Lapuyan', '7037', 47),
(1614, 'Malangas', '7038', 48),
(1615, 'Diplahan', '7039', 48),
(1616, 'Alicia', '7040', 48),
(1617, 'Olutanga', '7041', 48),
(1618, 'Guipos', '7042', 47),
(1619, 'Tigbao', '7043', 47),
(1620, 'Dipolog', '7100', 46),
(1621, 'Dapitan', '7101', 46),
(1622, 'Pres. Manuel A. Roxas', '7102', 46),
(1623, 'Sibutad', '7103', 46),
(1624, 'Rizal', '7104', 46),
(1625, 'Piñan', '7105', 46),
(1626, 'Polanco', '7106', 46),
(1627, 'Mutia', '7107', 46),
(1628, 'Sergio Osmeña Sr.', '7108', 46),
(1629, 'Katipunan', '7109', 46),
(1630, 'Manukan', '7110', 46),
(1631, 'Jose Dalman (Ponot)', '7111', 46),
(1632, 'Sindangan', '7112', 46),
(1633, 'Siayan', '7113', 46),
(1634, 'Salug', '7114', 46),
(1635, 'Liloy', '7115', 46),
(1636, 'Tampilisan', '7116', 46),
(1637, 'Labason', '7117', 46),
(1638, 'Gutalac', '7118', 46),
(1639, 'La Libertad', '7119', 46),
(1640, 'Siocon', '7120', 46),
(1641, 'Sirawai', '7121', 46),
(1642, 'Sibuco', '7122', 46),
(1643, 'Baliguian', '7123', 46),
(1644, 'Kalawit', '7124', 46),
(1645, 'Leon B. Postigo', '7125', 46),
(1646, 'Godod', '7126', 46),
(1647, 'Isabela City', '7300', 83);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `Product_ID` int(11) NOT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `Brand_ID` int(11) DEFAULT NULL,
  `Category_ID` int(11) DEFAULT NULL,
  `Purchase_Price` int(11) DEFAULT NULL,
  `Selling_Price` int(11) DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`Product_ID`, `Name`, `Description`, `Brand_ID`, `Category_ID`, `Purchase_Price`, `Selling_Price`, `Quantity`) VALUES
(1, 'Nike Dryfit Shirt', 'OFF-WHITE', 1, 1, 1000, 1200, 10),
(2, 'Travis Scott', 'Lucid Dreams', 2, 1, 50000, 60000, 10);

-- --------------------------------------------------------

--
-- Table structure for table `province`
--

CREATE TABLE `province` (
  `Province_ID` int(11) NOT NULL,
  `Province_Name` varchar(255) DEFAULT NULL,
  `Region_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `province`
--

INSERT INTO `province` (`Province_ID`, `Province_Name`, `Region_ID`) VALUES
(1, 'Ilocos Norte', 1),
(2, 'Ilocos Sur', 1),
(3, 'La Union', 1),
(4, 'Pangasinan', 1),
(5, 'Batanes', 1),
(6, 'Cagayan', 1),
(7, 'Isabela', 1),
(8, 'Nueva Vizcaya', 1),
(9, 'Quirino', 1),
(10, 'Bataan', 1),
(11, 'Bulacan', 1),
(12, 'Pampanga', 1),
(13, 'Zambales', 1),
(14, 'Nueva Ecija', 1),
(15, 'Pampanga', 1),
(16, 'Tarlac', 1),
(18, 'Aurora', 1),
(19, 'Batangas', 1),
(20, 'Cavite', 1),
(21, 'Laguna', 1),
(22, 'Quezon', 1),
(23, 'Rizal', 1),
(24, 'Albay', 1),
(25, 'Camarines Norte', 1),
(26, 'Camarines Sur', 1),
(27, 'Catanduanes', 1),
(28, 'Masbate', 1),
(29, 'Sorsogon', 1),
(30, 'Aklan', 2),
(31, 'Antique', 2),
(32, 'Capiz', 2),
(33, 'Iloilo', 2),
(34, 'Negros Occidental', 2),
(35, 'Guimaras', 2),
(36, 'Bohol', 2),
(37, 'Cebu', 2),
(38, 'Negros Oriental', 2),
(39, 'Siquijor', 2),
(40, 'Eastern Samar', 2),
(41, 'Leyte', 2),
(42, 'Northern Samar', 2),
(43, 'Samar (Western Samar)', 2),
(44, 'Southern Leyte', 2),
(45, 'Biliran', 2),
(46, 'Zamboanga del Norte', 3),
(47, 'Zamboanga del Sur', 3),
(48, 'Zamboanga Sibugay', 3),
(50, 'Bukidnon', 3),
(51, 'Camiguin', 3),
(52, 'Lanao del Norte', 3),
(53, 'Misamis Occidental', 3),
(54, 'Misamis Oriental', 3),
(55, 'Davao del Norte', 3),
(56, 'Davao del Sur', 3),
(57, 'Davao Oriental', 3),
(58, 'Davao de Oro', 3),
(59, 'Davao Occidental', 3),
(60, 'North Cotabato', 3),
(61, 'South Cotabato', 3),
(62, 'Sultan Kudarat', 3),
(63, 'Sarangani', 3),
(65, 'City of Manila', 1),
(69, 'Abra', 1),
(70, 'Benguet', 1),
(71, 'Ifugao', 1),
(72, 'Kalinga', 1),
(73, 'Mountain Province', 1),
(74, 'Apayao', 1),
(75, 'Marinduque', 1),
(76, 'Occidental Mindoro', 1),
(77, 'Oriental Mindoro', 1),
(78, 'Palawan', 1),
(79, 'Romblon', 1),
(80, 'Negros Occidental', 2),
(81, 'Negros Oriental', 2),
(82, 'Siquijor', 2),
(83, 'Basilan', 3),
(84, 'Lanao del Sur', 3),
(85, 'Sulu', 3),
(86, 'Tawi-tawi', 3),
(87, 'Maguindanao del Norte', 3),
(88, 'Maguindanao del Sur', 3);

-- --------------------------------------------------------

--
-- Table structure for table `region`
--

CREATE TABLE `region` (
  `Region_ID` int(11) NOT NULL,
  `Region_Name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `region`
--

INSERT INTO `region` (`Region_ID`, `Region_Name`) VALUES
(1, 'Luzon'),
(2, 'Visayas'),
(3, 'Mindanao');

-- --------------------------------------------------------

--
-- Table structure for table `return_item`
--

CREATE TABLE `return_item` (
  `Return_ID` int(11) NOT NULL,
  `Sale_ID` int(11) DEFAULT NULL,
  `Product_ID` int(11) DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL,
  `Reason` varchar(255) DEFAULT NULL,
  `Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role_type`
--

CREATE TABLE `role_type` (
  `Role_ID` int(11) NOT NULL,
  `Title` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role_type`
--

INSERT INTO `role_type` (`Role_ID`, `Title`) VALUES
(1, 'Admin'),
(2, 'Secretary'),
(3, 'User Employee');

-- --------------------------------------------------------

--
-- Table structure for table `sale`
--

CREATE TABLE `sale` (
  `Sale_ID` int(11) NOT NULL,
  `Customer_ID` int(11) DEFAULT NULL,
  `User_ID` int(11) DEFAULT NULL,
  `Total_Amount` int(11) DEFAULT NULL,
  `Payment_Type` varchar(255) DEFAULT NULL,
  `Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `sales_performance_view`
-- (See below for the actual view)
--
CREATE TABLE `sales_performance_view` (
`User_ID` int(11)
,`Total_Sales` bigint(21)
,`Total_Revenue` decimal(32,0)
,`Average_Sale_Amount` decimal(14,4)
);

-- --------------------------------------------------------

--
-- Table structure for table `sale_details`
--

CREATE TABLE `sale_details` (
  `Sale_Detail_ID` int(11) NOT NULL,
  `Sale_ID` int(11) DEFAULT NULL,
  `Product_ID` int(11) DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL,
  `Selling_Price` int(11) DEFAULT NULL,
  `Sub_total` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `status_type`
--

CREATE TABLE `status_type` (
  `Status_ID` int(11) NOT NULL,
  `Title` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `Supplier_ID` int(11) NOT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `Contact_Number` varchar(20) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`Supplier_ID`, `Name`, `Contact_Number`, `Address`) VALUES
(1, 'Roxas Ukay Shop', '09253525345', 'Davao City');

-- --------------------------------------------------------

--
-- Table structure for table `supplier_email`
--

CREATE TABLE `supplier_email` (
  `Email_ID` int(11) NOT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Supplier_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `supply`
--

CREATE TABLE `supply` (
  `Supply_ID` int(11) NOT NULL,
  `User_ID` int(11) DEFAULT NULL,
  `Supplier_ID` int(11) DEFAULT NULL,
  `Total` int(11) DEFAULT NULL,
  `Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supply`
--

INSERT INTO `supply` (`Supply_ID`, `User_ID`, `Supplier_ID`, `Total`, `Date`) VALUES
(1, 1, 1, 510000, '2025-02-19');

-- --------------------------------------------------------

--
-- Table structure for table `supply_details`
--

CREATE TABLE `supply_details` (
  `Supply_ID` int(11) NOT NULL,
  `Product_ID` int(11) NOT NULL,
  `Quantity` int(11) DEFAULT NULL,
  `SubTotal` decimal(10,0) DEFAULT NULL,
  `Price` int(11) DEFAULT NULL,
  `Receipt_number` varchar(11) DEFAULT NULL,
  `Condition_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supply_details`
--

INSERT INTO `supply_details` (`Supply_ID`, `Product_ID`, `Quantity`, `SubTotal`, `Price`, `Receipt_number`, `Condition_ID`) VALUES
(1, 1, 10, 10000, 1000, 'OR-00001', 1),
(1, 2, 10, 500000, 50000, 'RN123456', 1);

--
-- Triggers `supply_details`
--
DELIMITER $$
CREATE TRIGGER `update_supply_total` AFTER INSERT ON `supply_details` FOR EACH ROW BEGIN
    UPDATE supply
    SET Total = (SELECT COALESCE(SUM(SubTotal), 0) FROM supply_details WHERE Supply_ID = NEW.Supply_ID)
    WHERE Supply_ID = NEW.Supply_ID;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `total_deliveries_view`
-- (See below for the actual view)
--
CREATE TABLE `total_deliveries_view` (
`Total_Deliveries` bigint(21)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `total_sales_revenue_view`
-- (See below for the actual view)
--
CREATE TABLE `total_sales_revenue_view` (
`Total_Revenue` decimal(32,0)
,`Total_Sales` bigint(21)
);

-- --------------------------------------------------------

--
-- Table structure for table `user_employee`
--

CREATE TABLE `user_employee` (
  `User_ID` int(11) NOT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `Username` varchar(255) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `Role_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_employee`
--

INSERT INTO `user_employee` (`User_ID`, `Name`, `Username`, `Password`, `Role_ID`) VALUES
(1, 'James Paul U. Carballo', 'james43233', '1234', 1);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_product_details`
-- (See below for the actual view)
--
CREATE TABLE `view_product_details` (
`Product_ID` int(11)
,`Product_Name` varchar(255)
,`Category_Name` varchar(255)
,`Brand_Name` varchar(255)
,`Purchase_Price` int(11)
,`Selling_Price` int(11)
,`Quantity` int(11)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_sales_details`
-- (See below for the actual view)
--
CREATE TABLE `view_sales_details` (
`Sale_ID` int(11)
,`Customer_ID` int(11)
,`Customer_Contact` varchar(20)
,`User_ID` int(11)
,`Employee_Name` varchar(255)
,`Total_Amount` int(11)
,`Payment_Type` varchar(255)
,`Date` date
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_supplier_deliveries`
-- (See below for the actual view)
--
CREATE TABLE `view_supplier_deliveries` (
`Supply_ID` int(11)
,`Supplier_Name` varchar(255)
,`Product_Name` varchar(255)
,`Quantity` int(11)
,`Price` int(11)
,`SubTotal` decimal(10,0)
,`Receipt_number` varchar(11)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_users_with_roles`
-- (See below for the actual view)
--
CREATE TABLE `view_users_with_roles` (
`User_ID` int(11)
,`User_Name` varchar(255)
,`Username` varchar(255)
,`Role` varchar(255)
);

-- --------------------------------------------------------

--
-- Structure for view `customer_address_view`
--
DROP TABLE IF EXISTS `customer_address_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `customer_address_view`  AS SELECT `c`.`Customer_ID` AS `Customer_ID`, `c`.`Customer_Name` AS `Customer_Name`, `c`.`Contact_Number` AS `Contact_Number`, `a`.`Street_House_Building_No` AS `Street_House_Building_No`, `b`.`Barangay_Name` AS `Barangay_Name`, `m`.`Municipality_Name` AS `Municipality_Name`, `m`.`Postal_Code` AS `Postal_Code`, `p`.`Province_Name` AS `Province_Name`, `r`.`Region_Name` AS `Region_Name` FROM (((((`customer` `c` join `address` `a` on(`c`.`Address_ID` = `a`.`Address_ID`)) join `barangay` `b` on(`a`.`Barangay_ID` = `b`.`Barangay_ID`)) join `municipality` `m` on(`b`.`Municipality_ID` = `m`.`Municipality_ID`)) join `province` `p` on(`m`.`Province_ID` = `p`.`Province_ID`)) join `region` `r` on(`p`.`Region_ID` = `r`.`Region_ID`)) ;

-- --------------------------------------------------------

--
-- Structure for view `delivery_view`
--
DROP TABLE IF EXISTS `delivery_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `delivery_view`  AS SELECT `d`.`Delivery_ID` AS `Delivery_ID`, `d`.`Courier_ID` AS `Courier_ID`, `d`.`Address_ID` AS `Address_ID`, `d`.`Delivery_Fee` AS `Delivery_Fee`, `d`.`Sale_ID` AS `Sale_ID`, `d`.`Date` AS `Date`, `d`.`Status_ID` AS `Status_ID`, `d`.`Tracking_Number` AS `Tracking_Number`, `s`.`Customer_ID` AS `Customer_ID`, `s`.`User_ID` AS `User_ID`, `s`.`Total_Amount` AS `Total_Amount`, `s`.`Payment_Type` AS `Payment_Type`, `s`.`Date` AS `Sale_Date` FROM (`delivery` `d` join `sale` `s` on(`d`.`Sale_ID` = `s`.`Sale_ID`)) ;

-- --------------------------------------------------------

--
-- Structure for view `sales_performance_view`
--
DROP TABLE IF EXISTS `sales_performance_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `sales_performance_view`  AS SELECT `sale`.`User_ID` AS `User_ID`, count(`sale`.`Sale_ID`) AS `Total_Sales`, sum(`sale`.`Total_Amount`) AS `Total_Revenue`, avg(`sale`.`Total_Amount`) AS `Average_Sale_Amount` FROM `sale` GROUP BY `sale`.`User_ID` ;

-- --------------------------------------------------------

--
-- Structure for view `total_deliveries_view`
--
DROP TABLE IF EXISTS `total_deliveries_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `total_deliveries_view`  AS SELECT count(`delivery`.`Delivery_ID`) AS `Total_Deliveries` FROM `delivery` ;

-- --------------------------------------------------------

--
-- Structure for view `total_sales_revenue_view`
--
DROP TABLE IF EXISTS `total_sales_revenue_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `total_sales_revenue_view`  AS SELECT sum(`sale`.`Total_Amount`) AS `Total_Revenue`, count(`sale`.`Sale_ID`) AS `Total_Sales` FROM `sale` ;

-- --------------------------------------------------------

--
-- Structure for view `view_product_details`
--
DROP TABLE IF EXISTS `view_product_details`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_product_details`  AS SELECT `p`.`Product_ID` AS `Product_ID`, `p`.`Name` AS `Product_Name`, `c`.`Category_Name` AS `Category_Name`, `b`.`Brand_Name` AS `Brand_Name`, `p`.`Purchase_Price` AS `Purchase_Price`, `p`.`Selling_Price` AS `Selling_Price`, `p`.`Quantity` AS `Quantity` FROM ((`product` `p` join `category` `c` on(`p`.`Category_ID` = `c`.`Category_ID`)) join `brand` `b` on(`p`.`Brand_ID` = `b`.`Brand_ID`)) ;

-- --------------------------------------------------------

--
-- Structure for view `view_sales_details`
--
DROP TABLE IF EXISTS `view_sales_details`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_sales_details`  AS SELECT `s`.`Sale_ID` AS `Sale_ID`, `c`.`Customer_ID` AS `Customer_ID`, `c`.`Contact_Number` AS `Customer_Contact`, `u`.`User_ID` AS `User_ID`, `u`.`Name` AS `Employee_Name`, `s`.`Total_Amount` AS `Total_Amount`, `s`.`Payment_Type` AS `Payment_Type`, `s`.`Date` AS `Date` FROM ((`sale` `s` join `customer` `c` on(`s`.`Customer_ID` = `c`.`Customer_ID`)) join `user_employee` `u` on(`s`.`User_ID` = `u`.`User_ID`)) ;

-- --------------------------------------------------------

--
-- Structure for view `view_supplier_deliveries`
--
DROP TABLE IF EXISTS `view_supplier_deliveries`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_supplier_deliveries`  AS SELECT `sd`.`Supply_ID` AS `Supply_ID`, `s`.`Name` AS `Supplier_Name`, `p`.`Name` AS `Product_Name`, `sd`.`Quantity` AS `Quantity`, `sd`.`Price` AS `Price`, `sd`.`SubTotal` AS `SubTotal`, `sd`.`Receipt_number` AS `Receipt_number` FROM ((`supply_details` `sd` join `supplier` `s` on(`sd`.`Supply_ID` = `s`.`Supplier_ID`)) join `product` `p` on(`sd`.`Product_ID` = `p`.`Product_ID`)) ;

-- --------------------------------------------------------

--
-- Structure for view `view_users_with_roles`
--
DROP TABLE IF EXISTS `view_users_with_roles`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_users_with_roles`  AS SELECT `u`.`User_ID` AS `User_ID`, `u`.`Name` AS `User_Name`, `u`.`Username` AS `Username`, `r`.`Title` AS `Role` FROM (`user_employee` `u` join `role_type` `r` on(`u`.`Role_ID` = `r`.`Role_ID`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`Address_ID`),
  ADD KEY `Barangay_ID` (`Barangay_ID`);

--
-- Indexes for table `barangay`
--
ALTER TABLE `barangay`
  ADD PRIMARY KEY (`Barangay_ID`),
  ADD KEY `Municipality_ID` (`Municipality_ID`);

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`Brand_ID`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`Category_ID`);

--
-- Indexes for table `condition_item`
--
ALTER TABLE `condition_item`
  ADD PRIMARY KEY (`Condition_ID`);

--
-- Indexes for table `courier`
--
ALTER TABLE `courier`
  ADD PRIMARY KEY (`Courier_ID`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`Customer_ID`),
  ADD KEY `Address_ID` (`Address_ID`);

--
-- Indexes for table `delivery`
--
ALTER TABLE `delivery`
  ADD PRIMARY KEY (`Delivery_ID`),
  ADD KEY `Courier_ID` (`Courier_ID`),
  ADD KEY `Address_ID` (`Address_ID`),
  ADD KEY `Sale_ID` (`Sale_ID`),
  ADD KEY `Status_ID` (`Status_ID`);

--
-- Indexes for table `merchant`
--
ALTER TABLE `merchant`
  ADD PRIMARY KEY (`Merchant_ID`);

--
-- Indexes for table `mode_payment`
--
ALTER TABLE `mode_payment`
  ADD PRIMARY KEY (`Payment_ID`),
  ADD KEY `Merchant_ID` (`Merchant_ID`),
  ADD KEY `Sale_ID` (`Sale_ID`);

--
-- Indexes for table `municipality`
--
ALTER TABLE `municipality`
  ADD PRIMARY KEY (`Municipality_ID`),
  ADD KEY `Province_ID` (`Province_ID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`Product_ID`),
  ADD KEY `Brand_ID` (`Brand_ID`),
  ADD KEY `Category_ID` (`Category_ID`);

--
-- Indexes for table `province`
--
ALTER TABLE `province`
  ADD PRIMARY KEY (`Province_ID`),
  ADD KEY `Region_ID` (`Region_ID`);

--
-- Indexes for table `region`
--
ALTER TABLE `region`
  ADD PRIMARY KEY (`Region_ID`);

--
-- Indexes for table `return_item`
--
ALTER TABLE `return_item`
  ADD PRIMARY KEY (`Return_ID`),
  ADD KEY `Sale_ID` (`Sale_ID`);

--
-- Indexes for table `role_type`
--
ALTER TABLE `role_type`
  ADD PRIMARY KEY (`Role_ID`);

--
-- Indexes for table `sale`
--
ALTER TABLE `sale`
  ADD PRIMARY KEY (`Sale_ID`),
  ADD KEY `Customer_ID` (`Customer_ID`),
  ADD KEY `User_ID` (`User_ID`);

--
-- Indexes for table `sale_details`
--
ALTER TABLE `sale_details`
  ADD PRIMARY KEY (`Sale_Detail_ID`),
  ADD KEY `Sale_ID` (`Sale_ID`);

--
-- Indexes for table `status_type`
--
ALTER TABLE `status_type`
  ADD PRIMARY KEY (`Status_ID`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`Supplier_ID`);

--
-- Indexes for table `supplier_email`
--
ALTER TABLE `supplier_email`
  ADD PRIMARY KEY (`Email_ID`),
  ADD KEY `Supplier_ID` (`Supplier_ID`);

--
-- Indexes for table `supply`
--
ALTER TABLE `supply`
  ADD PRIMARY KEY (`Supply_ID`),
  ADD KEY `User_ID` (`User_ID`),
  ADD KEY `Supplier_ID` (`Supplier_ID`);

--
-- Indexes for table `supply_details`
--
ALTER TABLE `supply_details`
  ADD PRIMARY KEY (`Supply_ID`,`Product_ID`),
  ADD KEY `Product_ID` (`Product_ID`),
  ADD KEY `Condition_ID` (`Condition_ID`);

--
-- Indexes for table `user_employee`
--
ALTER TABLE `user_employee`
  ADD PRIMARY KEY (`User_ID`),
  ADD KEY `Role_ID` (`Role_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `Address_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `barangay`
--
ALTER TABLE `barangay`
  MODIFY `Barangay_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=183;

--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `Brand_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `Category_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `condition_item`
--
ALTER TABLE `condition_item`
  MODIFY `Condition_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `courier`
--
ALTER TABLE `courier`
  MODIFY `Courier_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `Customer_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `delivery`
--
ALTER TABLE `delivery`
  MODIFY `Delivery_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `merchant`
--
ALTER TABLE `merchant`
  MODIFY `Merchant_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `mode_payment`
--
ALTER TABLE `mode_payment`
  MODIFY `Payment_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `municipality`
--
ALTER TABLE `municipality`
  MODIFY `Municipality_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1648;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `Product_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `province`
--
ALTER TABLE `province`
  MODIFY `Province_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `region`
--
ALTER TABLE `region`
  MODIFY `Region_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `return_item`
--
ALTER TABLE `return_item`
  MODIFY `Return_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `role_type`
--
ALTER TABLE `role_type`
  MODIFY `Role_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sale`
--
ALTER TABLE `sale`
  MODIFY `Sale_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sale_details`
--
ALTER TABLE `sale_details`
  MODIFY `Sale_Detail_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `status_type`
--
ALTER TABLE `status_type`
  MODIFY `Status_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `Supplier_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `supplier_email`
--
ALTER TABLE `supplier_email`
  MODIFY `Email_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_employee`
--
ALTER TABLE `user_employee`
  MODIFY `User_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `address_ibfk_1` FOREIGN KEY (`Barangay_ID`) REFERENCES `barangay` (`Barangay_ID`);

--
-- Constraints for table `barangay`
--
ALTER TABLE `barangay`
  ADD CONSTRAINT `barangay_ibfk_1` FOREIGN KEY (`Municipality_ID`) REFERENCES `municipality` (`Municipality_ID`);

--
-- Constraints for table `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `customer_ibfk_1` FOREIGN KEY (`Address_ID`) REFERENCES `address` (`Address_ID`);

--
-- Constraints for table `delivery`
--
ALTER TABLE `delivery`
  ADD CONSTRAINT `delivery_ibfk_1` FOREIGN KEY (`Courier_ID`) REFERENCES `courier` (`Courier_ID`),
  ADD CONSTRAINT `delivery_ibfk_2` FOREIGN KEY (`Address_ID`) REFERENCES `address` (`Address_ID`),
  ADD CONSTRAINT `delivery_ibfk_3` FOREIGN KEY (`Sale_ID`) REFERENCES `sale` (`Sale_ID`),
  ADD CONSTRAINT `delivery_ibfk_4` FOREIGN KEY (`Status_ID`) REFERENCES `status_type` (`Status_ID`);

--
-- Constraints for table `mode_payment`
--
ALTER TABLE `mode_payment`
  ADD CONSTRAINT `mode_payment_ibfk_1` FOREIGN KEY (`Merchant_ID`) REFERENCES `merchant` (`Merchant_ID`),
  ADD CONSTRAINT `mode_payment_ibfk_2` FOREIGN KEY (`Sale_ID`) REFERENCES `sale` (`Sale_ID`);

--
-- Constraints for table `municipality`
--
ALTER TABLE `municipality`
  ADD CONSTRAINT `municipality_ibfk_1` FOREIGN KEY (`Province_ID`) REFERENCES `province` (`Province_ID`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`Brand_ID`) REFERENCES `brand` (`Brand_ID`),
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`Category_ID`) REFERENCES `category` (`Category_ID`);

--
-- Constraints for table `province`
--
ALTER TABLE `province`
  ADD CONSTRAINT `province_ibfk_1` FOREIGN KEY (`Region_ID`) REFERENCES `region` (`Region_ID`);

--
-- Constraints for table `return_item`
--
ALTER TABLE `return_item`
  ADD CONSTRAINT `return_item_ibfk_1` FOREIGN KEY (`Sale_ID`) REFERENCES `sale` (`Sale_ID`);

--
-- Constraints for table `sale`
--
ALTER TABLE `sale`
  ADD CONSTRAINT `sale_ibfk_1` FOREIGN KEY (`Customer_ID`) REFERENCES `customer` (`Customer_ID`),
  ADD CONSTRAINT `sale_ibfk_2` FOREIGN KEY (`User_ID`) REFERENCES `user_employee` (`User_ID`);

--
-- Constraints for table `sale_details`
--
ALTER TABLE `sale_details`
  ADD CONSTRAINT `sale_details_ibfk_1` FOREIGN KEY (`Sale_ID`) REFERENCES `sale` (`Sale_ID`);

--
-- Constraints for table `supplier_email`
--
ALTER TABLE `supplier_email`
  ADD CONSTRAINT `supplier_email_ibfk_1` FOREIGN KEY (`Supplier_ID`) REFERENCES `supplier` (`Supplier_ID`);

--
-- Constraints for table `supply`
--
ALTER TABLE `supply`
  ADD CONSTRAINT `supply_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `user_employee` (`User_ID`),
  ADD CONSTRAINT `supply_ibfk_2` FOREIGN KEY (`Supplier_ID`) REFERENCES `supplier` (`Supplier_ID`);

--
-- Constraints for table `supply_details`
--
ALTER TABLE `supply_details`
  ADD CONSTRAINT `supply_details_ibfk_1` FOREIGN KEY (`Supply_ID`) REFERENCES `supply` (`Supply_ID`),
  ADD CONSTRAINT `supply_details_ibfk_2` FOREIGN KEY (`Product_ID`) REFERENCES `product` (`Product_ID`),
  ADD CONSTRAINT `supply_details_ibfk_3` FOREIGN KEY (`Condition_ID`) REFERENCES `condition_item` (`Condition_ID`);

--
-- Constraints for table `user_employee`
--
ALTER TABLE `user_employee`
  ADD CONSTRAINT `user_employee_ibfk_1` FOREIGN KEY (`Role_ID`) REFERENCES `role_type` (`Role_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
