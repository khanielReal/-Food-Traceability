<?php
// Include necessary files
include('includes/header.php');
include('includes/functions.php');

// Assuming you have a session or user ID to get the farmer's details
$farmer_name = get_farmer_name(); // Fetch farmer name from session or database
$farm_name = get_farm_name(); // Fetch farm name
$analytics_data = get_analytics_data(); // Fetch data for charts
?>

<div class="dashboard-container">
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="profile">
            <img src="path/to/profile-icon.jpg" alt="Profile Icon">
            <p class="farmer-name"><?php echo $farmer_name; ?></p> <!-- Display Farmer's Name -->
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

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        <div class="top-navbar">
            <div class="farm-name"><?php echo $farm_name; ?> |</div>
            <select class="year-dropdown">
                <option value="2023">2023</option>
                <option value="2022">2022</option>
                <option value="2021">2021</option>
            </select>
            <input type="text" class="search-bar" placeholder="Search...">
        </div>

        <!-- Analytics Section -->
        <div class="analytics">
            <div class="chart-container">
                <canvas id="productionChart"></canvas> <!-- Chart.js chart -->
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>

<!-- External JS Link -->
<script src="js/dashboard.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
