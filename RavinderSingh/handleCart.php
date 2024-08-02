<?php
session_start();
require_once("./DB/db_conn.php");

class handleCart
{
  private $userID;
  private $productID;
  private $quantity;
  private $price;
  private $pdo;

  //Initializing the database object using constructor
  public function __construct() {
    $db = new Database();
    $this->pdo = $db->getConnection();
    
    // Set the userID from session if available
    if (isset( $_SESSION["UserId"])) {
      $this->userID =filter_var( $_SESSION["UserId"],FILTER_VALIDATE_INT);
      
    }
  }

  //Setting the value for UserId
  public function setUserID($userID) {
    $this->userID = trim(htmlspecialchars($userID));
     $_SESSION["UserId"] = $this->userID; // Store in session
  }

  //Getting the value of UserId
  public function getUserID() {
    return $this->userID;
  }

  //Setting the value for Product Id
  public function setProductID($productID) {
    $this->productID = trim(htmlspecialchars($productID));
  }

  //Getting the value of Product Id
  public function getProductID() {
    return $this->productID;
  }

  //Setting the value for Quantity
  public function setQuantity($quantity) {
    $this->quantity = trim(htmlspecialchars($quantity));
  }

  //Getting the value of Quantity
  public function getQuantity() {
    return $this->quantity;
  }

  //Setting the value for Price
  public function setPrice($price) {
    $this->price = trim(htmlspecialchars($price));
  }

  //Getting the value of Price
  public function getPrice() {
    return $this->price;
  }

  //Function to handle insert data into cart
  public function insertIntoCart() {
    try {
      // Check if the product already exists in the cart for the specific user
      $sql = "SELECT Quantity FROM Cart WHERE UserID = :UserID AND ProductID = :ProductID";
      $stmt = $this->pdo->prepare($sql);
      $stmt->execute([
        ':UserID' => $this->userID,
        ':ProductID' => $this->productID
      ]);

      if ($stmt->rowCount() > 0) {
        // Product exists in the cart, update the quantity
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $newQuantity = $row['Quantity'] + $this->quantity;

        $sql = "UPDATE Cart SET Quantity = :Quantity WHERE UserID = :UserID AND ProductID = :ProductID";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
          ':Quantity' => $newQuantity,
          ':UserID' => $this->userID,
          ':ProductID' => $this->productID
        ]);
      } else {
        // Product does not exist in the cart, insert a new record
        $sql = "INSERT INTO Cart (UserID, ProductID, Quantity, Price) VALUES (:UserID, :ProductID, :Quantity, :Price)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
          ':UserID' => $this->userID,
          ':ProductID' => $this->productID,
          ':Quantity' => $this->quantity,
          ':Price' => $this->price
        ]);
      }
    } catch (Exception $e) {
      throw $e;
    }
  }

  public function getCartItems() {
    $sql = "SELECT Cart.ProductID, Cart.Quantity, Cart.Price, Products.ProductName, Products.ImageURL 
            FROM Cart 
            JOIN Products ON Cart.ProductID = Products.ProductID
            WHERE Cart.UserID = :UserID";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([':UserID' => $this->userID]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  //Function to handle delete data into cart based on product id
  public function deleteFromCart($productID) {
    $sql = "DELETE FROM Cart WHERE UserID = :UserID AND ProductID = :ProductID";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([
      ':UserID' => $this->userID,
      ':ProductID' => $productID
    ]);
  }

  //Function to handle update quantity of a product
  public function updateQuantity($productID, $newQuantity) {
    $sql = "UPDATE Cart SET Quantity = :Quantity WHERE UserID = :UserID AND ProductID = :ProductID";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([
      ':Quantity' => trim(htmlspecialchars($newQuantity)),
      ':UserID' => $this->userID,
      ':ProductID' => $productID
    ]);
  }

  //Function to handle cart empty
  public function emptyCart() {
    $sql = "DELETE FROM Cart WHERE UserID = :UserID";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([':UserID' => $this->userID]);
  }
}
?>
