<?php include('includes/header.php'); ?>
<div class="container">
    <h2>Register</h2>
    <form action="register_process.php" method="post" enctype="multipart/form-data">
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" required><br><br>
        
        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" required><br><br>
        
        <label for="email">Email:</label>
        <input type="email" name="email" required><br><br>
        
        <label for="phone">Phone Number:</label>
        <input type="text" name="phone"><br><br>
        
        <label for="username">Username:</label>
        <input type="text" name="username" required><br><br>
        
        <label for="password">Password:</label>
        <input type="password" name="password" required><br><br>
        
        <label for="role">Register as:</label>
        <select name="role" required>
            <option value="farmer">Farmer</option>
            <option value="manufacturer">Manufacturer</option>
            <option value="supermarket">Supermarket</option>
            <option value="retailer">Retailer</option>
            <option value="wholesaler">Wholesaler</option>
            <option value="supplier">Supplier</option>
            <option value="consumer">Consumer</option>
        </select><br><br>
        
        <label for="profile_picture">Profile Picture:</label>
        <input type="file" name="profile_picture"><br><br>
        
        <button type="submit">Register</button>
    </form>
</div>
<?php include('includes/footer.php'); ?>
