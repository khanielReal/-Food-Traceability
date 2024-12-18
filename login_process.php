<?php
session_start();
include('config.php'); // Include database connection
include('includes/header.php'); // Include header

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and fetch user inputs
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    // Query to check if the user exists
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Store necessary user information in the session
            $_SESSION['user_id'] = $user['id']; // Store user_id for further database operations
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Redirect to the appropriate dashboard based on role
            switch ($user['role']) {
                case 'farmer':
                    header('Location: dashboards/farmer.php');
                    exit();
                case 'manufacturer':
                    header('Location: dashboards/manufacturer_dashboard.php');
                    exit();
                case 'consumer':
                    header('Location: dashboards/consumer_dashboard.php');
                    exit();
                // Add other roles as needed
                default:
                    echo "<p>Invalid role!</p>";
            }
        } else {
            echo "<p>Invalid password!</p>";
        }
    } else {
        echo "<p>User not found!</p>";
    }
}
include('includes/footer.php'); // Include footer
?>
