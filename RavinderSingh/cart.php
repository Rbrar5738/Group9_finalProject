<?php
require_once("./DB/db_conn.php");
require_once("./handleCart.php");
require_once("./redirect.php");
$redirect=new redirect();
$redirect->redirectIfNotLoggedIn();

try {
    $db = new Database();
    $pdo = $db->getConnection();

    $cart = new handleCart();
  

    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['action']) && isset($_POST['product_id'])) {
            $productID = $_POST['product_id'];
            $action = $_POST['action'];

            // Handle quantity updates
            $currentQuantity = 0;
            foreach ($cart->getCartItems() as $item) {
                if ($item['ProductID'] == $productID) {
                    $currentQuantity = $item['Quantity'];
                    break;
                }
            }

            if ($action === 'increase') {
                $cart->updateQuantity($productID, $currentQuantity + 1);
            } elseif ($action === 'decrease' && $currentQuantity > 1) {
                $cart->updateQuantity($productID, $currentQuantity - 1);
            }
        } elseif (isset($_POST['delete_product_id'])) {
            // Handle delete action
            $deleteProductID = $_POST['delete_product_id'];
            $cart->deleteFromCart($deleteProductID);
        }
    }

    // Fetch all cart items
    $cartItems = $cart->getCartItems();

    // Calculate total cost and total cost including tax
    $totalCost = 0;
    foreach ($cartItems as $item) {
        $totalCost += $item['Quantity'] * $item['Price'];
    }
    $tax = $totalCost * 0.13;
    $grandTotal = $totalCost + $tax;

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RAMT coffee_mug_insulated</title>
    <link rel="stylesheet" type="text/css" href="../HelperFiles/style.css">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php
    require_once("../HelperFiles/header.php");
  ?>
    <div class="container mt-5">
        <h1 id="myCartTitle">My Cart</h1>
        <?php if (!empty($cartItems)): ?>
            <div id="cartContairer">
            <table id="cartTable" class="table">
                <thead id="thead" class="thead">
                    <tr>
                        <th >Image</th>
                        <th >Product</th>
                        <th >Price</th>
                        <th >Total</th>
                       
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cartItems as $item): ?>
                        <tr>
                            <td rowspan="2"><img id="cartImage" src="<?php echo htmlspecialchars($item['ImageURL']); ?>" alt="<?php echo htmlspecialchars($item['ProductName']); ?>" width="100"></td>
                            <td><?php echo htmlspecialchars($item['ProductName']); ?></td>

                          
                            <td>$<?php echo number_format($item['Price'], 2); ?></td>
                            <td>$<?php echo number_format($item['Quantity'] * $item['Price'], 2); ?></td>
                    </tr>
                    <tr>
                            <td>
                                <form method="post" style="display: inline-block;">
                                    <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($item['ProductID']); ?>">
                                    <input type="hidden" name="action" value="decrease">
                                    <button type="submit" class="btn btn-secondary btn-sm">-</button>
                                </form>
                                <?php echo htmlspecialchars($item['Quantity']); ?>
                                <form method="post" style="display: inline-block;">
                                    <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($item['ProductID']); ?>">
                                    <input type="hidden" name="action" value="increase">
                                    <button id="cartBtn"type="submit" class="btn btn-secondary btn-sm">+</button>
                                </form>
                            </td>
                            <td></td>
                            <td >
                                <form method="post" style="display: inline-block;">
                                    <input type="hidden" name="delete_product_id" value="<?php echo htmlspecialchars($item['ProductID']); ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                                </form>
                            </td>
                           
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div id="cartTotal" class="row mt-4">
                        <h3>Cart Total</h3>
                    <h4>Subtotal: $</h4><h4><?php echo number_format($totalCost, 2); ?></h4>
                    <h4>Tax (13%): $</h4><h4><?php echo number_format($tax, 2); ?></h4>
                    <h4 id="grand">Grand Total: $</h4><h4 id="grand"><?php echo number_format($grandTotal, 2); ?></h4>
                    <a id="proceedToCheckOut" href="../TusharDagar/checkout.php">Proceed To Check Out</a>
            </div>
            </div>
         </div
        <?php else: ?>
            <p id="emptyCart" class="alert alert-warning">Your cart is empty.</p>
        <?php endif; ?>
    </div>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <?php
    require_once("../HelperFiles/footer.php");
  ?>
</body>
</html>
