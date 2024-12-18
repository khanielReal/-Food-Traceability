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

// Check if the profile picture is being uploaded
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profile_picture'])) {
    // Define the target directory to upload the file
    $target_dir = "../uploads/profile_pictures/";
    $target_file = $target_dir . basename($_FILES["profile_picture"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if the file is a valid image
    if (getimagesize($_FILES["profile_picture"]["tmp_name"])) {
        // Check if file already exists
        if (!file_exists($target_file)) {
            // Move the uploaded file to the target directory
            if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
                // Extract only the filename (not the full path) to store in the database
                $filename = basename($_FILES["profile_picture"]["name"]);

                // Update the database with the new profile picture filename (NOT the full path)
                $update_query = "UPDATE users SET profile_picture = ? WHERE id = ?";
                $stmt = $conn->prepare($update_query);
                $stmt->bind_param("si", $filename, $farmer_id);
                $stmt->execute();
                $farmer['profile_picture'] = $filename; // Update the farmer's profile picture in the session
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo "Sorry, file already exists.";
        }
    } else {
        echo "Sorry, only image files are allowed.";
    }
}

// Fetch farms
$farms_query = "SELECT id, farm_name, location, size, crop_type FROM farms WHERE user_id = ?";
$stmt = $conn->prepare($farms_query);
$stmt->bind_param("i", $farmer_id);
$stmt->execute();
$farms_result = $stmt->get_result();

// Fetch yearly data for analytics
$yearly_data_query = "SELECT year, total_production, revenue, expenses FROM yearly_data WHERE farm_id IN (SELECT id FROM farms WHERE user_id = ?)";
$stmt = $conn->prepare($yearly_data_query);
$stmt->bind_param("i", $farmer_id);
$stmt->execute();
$yearly_data_result = $stmt->get_result();

// Prepare data for charts
$years = [];
$production = [];
$revenue = [];

while ($row = $yearly_data_result->fetch_assoc()) {
    $years[] = $row['year'];
    $production[] = $row['total_production'];
    $revenue[] = $row['revenue'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmer Dashboard</title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="dashboard-container">
        <div class="sidebar">
            <div class="profile">
                <!-- Display the profile picture with the correct path -->
                <img src="../uploads/profile_pictures/<?php echo $farmer['profile_picture']; ?>" alt="Profile Picture">
                <p><?php echo $farmer['first_name'] . ' ' . $farmer['last_name']; ?></p>
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
                <div class="farm-name"><?php echo $farmer['first_name'] . ' ' . $farmer['last_name']; ?>'s Farm |</div>
                <select class="year-dropdown">
                    <?php foreach ($years as $year): ?>
                        <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="text" class="search-bar" placeholder="Search...">
                <button class="add-crop-btn">+ Add Crop</button>
            </div>

            <div class="analytics">
                <div class="chart-container">
                    <canvas id="productionChart"></canvas>
                </div>
                <div class="chart-container">
                    <canvas id="revenueChart"></canvas>
                </div>
                <div class="pie-chart-container">
                    <canvas id="pieChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script>
        const productionChart = new Chart(document.getElementById('productionChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: <?php echo json_encode($years); ?>,
                datasets: [{
                    label: 'Total Production',
                    data: <?php echo json_encode($production); ?>,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Year'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Total Production'
                        }
                    }
                }
            }
        });

        const revenueChart = new Chart(document.getElementById('revenueChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: <?php echo json_encode($years); ?>,
                datasets: [{
                    label: 'Revenue',
                    data: <?php echo json_encode($revenue); ?>,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Year'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Revenue ($)'
                        }
                    }
                }
            }
        });

        const pieChart = new Chart(document.getElementById('pieChart').getContext('2d'), {
            type: 'pie',
            data: {
                labels: ['Farm 1', 'Farm 2', 'Farm 3', 'Farm 4'],
                datasets: [{
                    data: [300, 50, 100, 150],
                    backgroundColor: ['#FF5733', '#33FF57', '#3357FF', '#FF33A6'],
                    borderColor: '#fff',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top'
                    }
                }
            }
        });
    </script>

    <?php include('../includes/footer.php'); ?>
</body>
</html>
