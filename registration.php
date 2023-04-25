<!DOCTYPE html>
<html>

<head>
    <title>Registration Page</title>
</head>

<body>
    <h1>User Registration Form</h1>

    <?php
    include "dbconn.php";
    // Define variable errors as an empty array
    $errors = [];

    // Check if the form has been submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get form data and validate it
        $username = trim($_POST['username']);
        if (empty($username)) {
            $errors[] = 'Username is required';
        }

        $email = trim($_POST['email']);
        if (empty($email)) {
            $errors[] = 'Email is required';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email format';
        }

        $password = trim($_POST['hashed_password']);
        if (empty($password)) {
            $errors[] = 'Password is required';
        }

        // If no validation errors, insert data into database
        if (empty($errors)) {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Connect to database
            $connection = mysqli_connect('hostname', 'username', 'password', 'database_name');
            if (!$connection) {
                die("Connection failed: " . mysqli_connect_error());
            }

            // Prepare statement with named parameters
            $stmt = mysqli_prepare($connection, "INSERT INTO users (username, email, hashed_password) 
                                                 VALUES (?, ?, ?)");

            // Bind parameters to prepared statement
            mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashed_password);

            // Execute prepared statement
            if (mysqli_stmt_execute($stmt)) {
                echo 'User registered successfully!';
            } else {
                echo "Error: " . mysqli_error($connection);
            }

            // Close statement and connection
            mysqli_stmt_close($stmt);
            mysqli_close($connection);
        }

    }
    ?>

    <!-- Display any validation errors -->
    <?php if (!empty($errors)): ?>
        <ul style="color: red;">
            <?php foreach ($errors as $error): ?>
                <li>
                    <?= $error ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <!-- Registration form -->
    <form method="post">
        <label>Username:</label><br>
        <input type="text" name="username"><br><br>

        <label>Email:</label><br>
        <input type="email" name="email"><br><br>

        <label>Password:</label><br>
        <input type="password" name="password"><br><br>

        <input type="submit" value="Register">
    </form>
</body>

</html>