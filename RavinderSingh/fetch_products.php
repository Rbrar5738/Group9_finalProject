<?php
require_once("./DB/db_conn.php");

class fetchProductsClass {
  private $pdo;

  public function __construct($pdo) {
    $this->pdo = $pdo;
  }

  public function displayFetchProducts($categoryID = 'All') {
    $query = "SELECT * FROM Products";
    if ($categoryID !== 'All') {
      $query .= " WHERE CategoryID = :categoryID";
    }
    $stmt = $this->pdo->prepare($query);
    if ($categoryID !== 'All') {
      $stmt->bindParam(':categoryID', $categoryID);
    }
    $stmt->execute();

    while ($row = $stmt->fetch()) {
      echo '<div class="card">';
      echo '<div class="img">';
      echo '<img src="' . $row["ImageURL"] . '" class="card-img-top" alt="' . $row["ProductName"] . '">';
      echo '</div>';
      echo '<div class="card-body">';
      echo '<h5 class="card-title">' . $row["ProductName"] . '</h5>';
   
      echo '<table>';
      echo '<tr><td class="card-text"><b>ID</b></td> <td>:&nbsp;&nbsp;&nbsp;'.$row["ProductID"] . '</td></tr>';
      echo '<tr><td class="card-text"><b>Price</b></td> <td>:&nbsp;&nbsp;&nbsp;$' . $row["Price"] . '</td></tr>';
      echo '<tr><td  class="card-text"><b>Stock</b> </td> <td>:&nbsp;&nbsp;&nbsp;' . $row["Quantity"] . '</td></tr>';
      echo '</table>';
      echo '<p class="card-desc">' . $row["SmallDescription"] . '</p>';
      echo '</div>';
      echo '<div class="card-body">';
      echo "<a class='card-link' href='../AdityaShroff/detail.php?product_id={$row['ProductID']}'>View Details</a>";
      echo '</div>';
      echo '</div>';
    }
  }
}

if (isset($_POST['categoryID'])) {
  $categoryID = $_POST['categoryID'];
  $db = new Database();
  $pdo = $db->getConnection();
  $productClass = new fetchProductsClass ($pdo);
  $productClass->displayFetchProducts($categoryID);
}
?>
