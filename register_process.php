<?php
// Include database connection
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Secure password hashing
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $status = 'active'; // Default status

    // Handle profile picture upload
    $profile_picture = null;
    if (!empty($_FILES['profile_picture']['name'])) {
        $target_dir = "uploads/profile_pictures/";
        $target_file = $target_dir . basename($_FILES['profile_picture']['name']);
        $profile_picture = $target_file;
        
        // Move uploaded file
        if (!move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_file)) {
            die("Error uploading profile picture.");
        }
    }

    // Check for duplicate email
    $check_email_query = "SELECT * FROM users WHERE email = '$email'";
    $check_email_result = mysqli_query($conn, $check_email_query);

    if (mysqli_num_rows($check_email_result) > 0) {
        die("Email already exists. Please use a different email.");
    }

    // Insert data into the users table
    $insert_query = "
        INSERT INTO users (first_name, last_name, email, phone, username, password, role, profile_picture, status)
        VALUES ('$first_name', '$last_name', '$email', '$phone', '$username', '$password', '$role', '$profile_picture', '$status')
    ";

    if (mysqli_query($conn, $insert_query)) {
        echo "Registration successful! You can now log in.";
        header("Location: login.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
