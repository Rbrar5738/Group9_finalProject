<?php
session_start();
require_once("../RavinderSingh/DB/db_conn.php");

class ProductDetail {
    private $pdo;
    
    public function __construct() {
        $db = new Database();
        $this->pdo = $db->getConnection();
    }
    
    public function getProductDetails($productID) {
        $stmt = $this->pdo->prepare("SELECT * FROM Products WHERE ProductID = :ProductID");
        $stmt->execute([':ProductID' => $productID]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addToCart($productID, $quantity) {
        try {
            $stmt = $this->pdo->prepare("SELECT Quantity FROM Cart WHERE ProductID = :ProductID");
            $stmt->execute([':ProductID' => $productID]);
            
            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $newQuantity = $row['Quantity'] + $quantity;

                $stmt = $this->pdo->prepare("UPDATE Cart SET Quantity = :Quantity WHERE ProductID = :ProductID");
                $stmt->execute([':Quantity' => $newQuantity, ':ProductID' => $productID]);
            } else {
                $userID = filter_var($_SESSION["UserId"], FILTER_VALIDATE_INT);
                $productDetails = $this->getProductDetails($productID);
                $price = $productDetails['Price'];

                $stmt = $this->pdo->prepare("INSERT INTO Cart (UserID, ProductID, Quantity, Price) VALUES (:UserID, :ProductID, :Quantity, :Price)");
                $stmt->execute([':UserID' => $userID, ':ProductID' => $productID, ':Quantity' => $quantity, ':Price' => $price]);
            }
        } catch (Exception $e) {
            throw $e;
        }
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_cart'])) {
    $productID = filter_var(trim($_POST['product_id']), FILTER_VALIDATE_INT);
    $quantity = trim($_POST['quantity']);

    // Validate quantity to ensure it contains only digits
    if (!preg_match('/^\d+$/', $quantity)) {
        // Set an error message and redirect back
        $_SESSION['cart_message'] = 'Invalid quantity. Only digits are allowed.';
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }

    $quantity = intval($quantity); // Convert to integer after validation

    // Check if the quantity is between 1 and 50
    if ($quantity < 1 || $quantity > 50) {
        $_SESSION['cart_message'] = 'Invalid quantity. Please enter a quantity between 1 and 50.';
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }

    $productDetail = new ProductDetail();
    $productDetail->addToCart($productID, $quantity);

    // Set a session variable to indicate success
    $_SESSION['cart_message'] = 'Product added to cart';
    
    // Redirect back to the product detail page
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}


?>
