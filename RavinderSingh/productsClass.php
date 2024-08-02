<?php
require_once("./DB/db_conn.php");

class ProductsClass {
  private $pdo;

  public function __construct() {
    $db = new Database();
    $this->pdo = $db->getConnection();
  }

  public function displayCategories() {
    $stmt = $this->pdo->prepare("SELECT * FROM Categories");
    $stmt->execute();
    
    echo '<div class="select_container">';
    echo "<span>Select Products for Sorting</span>";
    echo '<select id="categorySelect">';
    echo "<option value='All'>All</option>";
    while ($row = $stmt->fetch()) {     
      echo "<option value='" . $row['CategoryID'] . "'>" . $row['CategoryName'] . "</option>";
    }
    echo '</select>';
    echo '</div>'; 
  }

  public function displayProducts() {
    $query = "SELECT * FROM Products";
  
    $stmt = $this->pdo->prepare($query);
    $stmt->execute();

    echo '<div class="products-container">';
    while ($row = $stmt->fetch()) {
   
      echo '<div class="card">';
      echo '<div class="img">';
      echo "<a  href='../AdityaShroff/detail.php?product_id={$row['ProductID']}'>
      <img src='" . $row["ImageURL"] . "' class='card-img-top' alt='" . $row["ProductName"] . "'>
    </a>";

      echo '</div>';
      echo '<div class="card-body">';
      echo '<h5 class="card-title" style="color: #1b834f;">' . $row["ProductName"] . '</h5>';
      echo '<table>';
      echo '<tr><td class="card-text" style="color: #1b834f;"><b>ID</b></td> <td style="color: #1b834f;">:&nbsp;&nbsp;&nbsp;'.$row["ProductID"] . '</td></tr>';
      echo '<tr><td class="card-text" style="color: #1b834f;"><b>Price</b></td> <td style="color: #1b834f;">:&nbsp;&nbsp;&nbsp; $' . $row["Price"] . '</td></tr>';
      echo '<tr><td  class="card-text" style="color: #1b834f;"><b>Stock</b> </td> <td style="color: #1b834f;">:&nbsp;&nbsp;&nbsp;' . $row["Quantity"] . '</td></tr>';
      echo '</table>';
      echo '<p class="card-desc" style="color: #1b834f;">' . $row["SmallDescription"] . '</p>';
      echo '</div>';
      echo '<div class="card-body">';
      echo "<a id='productBtn' class='card-link' href='../AdityaShroff/detail.php?product_id={$row['ProductID']}'>View Full Details Of Product</a>";
      echo '</div>';
      echo '</div>';
     
    }
    echo '</div>'; 
  }
}
?>
