<?php
session_start();

// Check if user is logged in and has the role of 'farmer'
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'farmer') {
    header('Location: ../login.php'); // Redirect to login page if not logged in or not a farmer
    exit();
}

include('../config.php'); // Database connection

$farmer_id = $_SESSION['user_id']; // Get logged-in user's ID

// Fetch farmer details
$farmer_query = "SELECT first_name, last_name, email, profile_picture FROM users WHERE id = ?";
$stmt = $conn->prepare($farmer_query);
$stmt->bind_param("i", $farmer_id);
$stmt->execute();
$farmer = $stmt->get_result()->fetch_assoc();

// Fetch farms
$farms_query = "SELECT id, farm_name, location, size, crop_type FROM farms WHERE user_id = ?";
$stmt = $conn->prepare($farms_query);
$stmt->bind_param("i", $farmer_id);
$stmt->execute();
$farms_result = $stmt->get_result();

// Fetch analytics data
$analytics_query = "SELECT year, production_data FROM analytics WHERE farm_id IN (SELECT id FROM farms WHERE user_id = ?)";
$stmt = $conn->prepare($analytics_query);
$stmt->bind_param("i", $farmer_id);
$stmt->execute();
$analytics_result = $stmt->get_result();

// Fetch yearly data
$yearly_data_query = "SELECT year, total_production, revenue, expenses FROM yearly_data WHERE farm_id IN (SELECT id FROM farms WHERE user_id = ?)";
$stmt = $conn->prepare($yearly_data_query);
$stmt->bind_param("i", $farmer_id);
$stmt->execute();
$yearly_data_result = $stmt->get_result();
?>

<link rel="stylesheet" href="../css/dashboard.css">

<div class="dashboard-container">
    <div class="sidebar">
        <div class="profile">
            <img src="../uploads/profile_pictures/<?php echo $farmer['profile_picture']; ?>" alt="Profile Picture">
            <p><?php echo $farmer['first_name'] . ' ' . $farmer['last_name']; ?></p> <!-- Display Farmer's Name -->
        </div>
        <ul class="nav-links">
            <li><a href="home.php">Home</a></li>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="all_farms.php">All Farms</a></li>
            <li class="dropdown">
                <a href="#">Sellers</a>
                <ul class="dropdown-menu">
                    <li><a href="logistics.php">Logistics</a></li>
                    <li><a href="suppliers.php">Suppliers</a></li>
                </ul>
            </li>
            <li><button class="add-farm-btn">+ Add Farm</button></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="top-navbar">
            <div class="farm-name"><?php echo $farmer['first_name'] . ' ' . $farmer['last_name']; ?>'s Farm |</div> <!-- Display Farmer's Full Name -->
            
            <!-- Year Dropdown -->
            <select class="year-dropdown">
                <?php while ($year = $yearly_data_result->fetch_assoc()): ?>
                    <option value="<?php echo $year['year']; ?>"><?php echo $year['year']; ?></option>
                <?php endwhile; ?>
            </select>
            
            <!-- Search Bar -->
            <input type="text" class="search-bar" placeholder="Search...">
            
            <!-- Add Crop Button -->
            <button class="add-crop-btn">+ Add Crop</button> <!-- Add Crop Button -->
        </div>

        <!-- Analytics Section -->
        <div class="analytics">
            <div class="chart-container">
                <canvas id="productionChart"></canvas> <!-- Chart.js chart -->
            </div>
        </div>
    </div>
</div>

<script src="js/dashboard.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<?php include('../includes/footer.php'); ?>
