<?php include('includes/header.php'); ?>
<div class="container">
    <h2>Register</h2>
    <form action="register_process.php" method="post">
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
        
        <button type="submit">Register</button>
    </form>
</div>
<?php include('includes/footer.php'); ?>
