<?php
require_once("detailClass.php");

$productDetail = new ProductDetail();
if (isset($_GET['product_id'])) {
    $product = $productDetail->getProductDetails($_GET['product_id']);
}

// Check for the cart message and clear it afterward
$cartMessage = '';
if (isset($_SESSION['cart_message'])) {
    $cartMessage = $_SESSION['cart_message'];
    unset($_SESSION['cart_message']); // Clear the message after displaying
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>RAMT Coffee Mug Insulated</title>
    <link rel="stylesheet" type="text/css" href="../HelperFiles/style.css">
    <style>
        .container {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 16px;
            padding: 16px;
            width: 80%;
            margin: 0 auto;
        }
        .card {
            display: flex;
            flex-direction: column;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 16px;
        }
        .img {
            border: 1px solid #ddd;
            border-radius: 4px;
            overflow: hidden;
        }
        .img img {
            width: 80%;
            margin: 10%;
            height: auto;
        }
        .img img:hover {
            transform: scale(1.1);
            transition: 1s;
        }
        #detailTitleText {
            font-size: 2.2rem;
            font-weight: 1000;
            text-align: center;
            background-color: rgb(221, 238, 223);
            padding: 10px;
        }
        table{
            margin-top:20px
        }
        .details {
            display: flex;
            flex-direction: column;
            padding: 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .card-body {
            margin-bottom: 16px;
        }
        .quantity-controls {
            display: flex;
            justify-content: flex-start;          
            margin-bottom: 16px;
        }
        .quantity-controls input {
            width: 200px;
            text-align: center;
            border: 1px solid black;
            margin: 0 10px;
            
        }
        .card-link {
            background-color: #1b834f;
            color: white;
            padding: 10px 100px;
            text-decoration: none;
            border-radius: 4px;
            cursor: pointer;
            display: inline-block;
            border-radius:10px;
        }
        .card-text, .card-desc {
            margin-top:20px;
            font-size: 1.2rem;
        }
        button {
            border: 1.5px solid #1b834f;
            background-color: transparent;
            cursor: pointer;
            padding: 5px 10px;
            margin-left: 5px;
        }
        button:hover {
            background-color: rgb(221, 238, 223);
            color: #1b834f;
            border: 1.5px solid #1b834f;
        }
        .notification {
            background-color: #d4edda;
            color: red;
            padding: 10px;
            border: 1px solid #c3e6cb;
            border-radius: 4px;
            text-align: center;
            margin-bottom: 16px;
        }
        .card-desc {
            font-size: 1.2rem;
        }
        #card-desc {
            font-size: 1.2rem;
            text-align: center;
        }
    </style>
</head>
<body>
    <?php require_once("../HelperFiles/header.php"); ?>

    <?php if ($cartMessage): ?>
        <div class="notification"><?php echo $cartMessage; ?></div> <!-- Notification message -->
    <?php endif; ?>

    <?php if (isset($product)) : ?>
        <div class="container">
            <div class="img">
                <img src="<?php echo $product["ImageURL"]; ?>" alt="<?php echo $product["ProductName"]; ?>">
                <p class="card-desc" id="card-desc" style="color: #1b834f;"><?php echo $product["SmallDescription"]; ?></p>
            </div>
            <div class="details">
                <div class="card-body">
                    <h5 class="card-title" id="detailTitleText" style="color: #1b834f;"><?php echo $product["ProductName"]; ?></h5>
                    <br>
                    <table>
                        <tr><td class="card-text" style="color: #1b834f;"><b>ID</b></td><td style="color: #1b834f;">:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $product["ProductID"]; ?></td></tr>
                        <tr><td class="card-text" style="color: #1b834f;"><b>Price</b></td><td style="color: #1b834f;">:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $<?php echo number_format($product["Price"], 2); ?></td></tr>
                        <tr><td class="card-text" style="color: #1b834f;"><b>Stock</b></td><td style="color: #1b834f;">:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $product["Quantity"]; ?></td></tr>
                    </table>
                    <p class="card-desc" style="color: #1b834f; text-align:left;"><?php echo $product["LargeDescription"]; ?></p>
                </div>
                <div class="card-body">
                    <form id="add-to-cart-form" method="POST" action="detailClass.php">
                        <input type="hidden" name="product_id" value="<?php echo $product['ProductID']; ?>">
                        <div class="quantity-controls">
                            <label for="quantity">Quantity:</label>
                            <input type="text" id="quantity" name="quantity" value="1">
                        </div>
                        <button type="submit" class="card-link" name="add_to_cart">Add to Cart</button>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php require_once("../HelperFiles/footer.php"); ?>
</body>
</html>
