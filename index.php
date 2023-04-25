<!DOCTYPE html>
<html>

<head>
    <title>My E-Commerce Site</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        .panel {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #f2f2f2;
            padding: 10px 20px;
        }

        .cart-icon img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <header>
        <nav>

        </nav>
    </header>

    <body>
        <div class="panel">
            <a href="cart.php" class="cart-icon">
                <img src="cart-image.jpg" alt="Cart">
                <span class="fas fa-shopping-cart"></span>
                Cart
            </a>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Shop</a></li>
                <li><a href="#">About Us</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </div>
    </body>
    <?php
    session_start();
    // Connect to database
    include 'dbconn.php';


    // Retrieve data from "products" table
    $sql = "SELECT * FROM products";
    $result = $conn->query($sql);

    // Display product information on the index page
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            echo "<div>";
            echo "<h3>" . $row["item_name"] . "</h3>";

            echo "<p>$" . $row["item_price"] . "</p>";
            echo "<form method='post' action='cart.php'>";
            echo "<input type='hidden' name='id' value='" . $row["item_id"] . "'>";
            echo "<input type='hidden' name='name' value='" . $row["item_name"] . "'>";
            echo "<input type='hidden' name='price' value='" . $row["item_price"] . "'>";
            echo "<input type='submit' name='add_to_cart' value='Add to Cart'>";
            echo "</form>";
            echo "</div>";
        }
    } else {
        echo "No products found.";
    }
    session_start();

    if (isset($_POST['add_to_cart'])) {
        // Get the product ID and quantity values from the form.
        $product_id = $_POST['item_id'];
        $quantity = $_POST['item_quantity'];

        // Check if a cart exists in the session.
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }

        // Add the product ID and quantity to the cart.
        $_SESSION['cart'][$product_id] = $quantity;

        // Redirect the user to the shopping cart page or show a success message.
        header('Location: index.php');
        exit;
    }


    // Close database connection
    $conn->close();
    ?>