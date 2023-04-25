<!DOCTYPE html>
<html>

<head>
    <title>Login Page</title>
</head>

<body>
    <h2>Login to your account</h2>
    <?php if (isset($_GET['error'])) { ?>
        <p style="color:red;">
            <?php echo $_GET['error']; ?>
        </p>
    <?php } ?>
    <form action="login.php" method="POST">
        <label>Username:</label><br>
        <input type="text" name="username" required><br>
        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>
        <button type="submit">Login</button>
    </form>
</body>

</html>
<?php
session_start();
include "dbconn.php";

if (isset($_POST['username']) && isset($_POST['hashed_password'])) {
    $username = $_POST['username'];
    $password = $_POST['hashed_password'];

    // Check if the entered username and password exist in the database
    $stmt = $conn->prepare("SELECT * FROM users WHERE username=? AND hashed_password=?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // The user is authenticated
        $_SESSION['username'] = $username;
        header("Location: index.php"); // Redirect to homepage
        exit();
    } else {
        // Invalid username or password
        header("Location: login.php?error=Invalid username or password.");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
?>