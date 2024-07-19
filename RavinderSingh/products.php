<!DOCTYPE html>
<html>
<head>
  <title>RAMT Coffee and Accessories</title>
  <link rel="stylesheet" type="text/css" href="../HelperFiles/style.css">
  <style>
    .products-container {
      padding:20px 0;
      display: grid;
      grid-template-columns: repeat(4, 22%);
      justify-content:center;
      gap: 20px;
      background-color: rgb(221, 238, 223);
      color:#1b834f;
    }
    .card {
      color:#1b834f;
      width: 100%;
      box-sizing: border-box;
      padding:20px;
      border-radius:30px;
      box-shadow:0 0 10px rgba(0,0,0,0.5);
     
    }
    .card .img{
      width: 100%;
      height:20rem;
      overflow:hidden;
    }

     .card .img img{
      width: 100%;
      height:100%
     }
    .card .img img:hover{
      transform:scale(1.05);
      transition:all 0.5s;
    }
    .card-title{
      text-align:center;
      font-weight:600;
      font-size:1.3rem;
      color:#1b834f;
      
    }
    .card-text{
      font-size:1rem;
      
    }
    .card-desc{
      font-size:1rem;
     
    }
    .card-link{
      background-color: #1b834f;
      padding:10px 20px;
      text-decoration:none;
      color:white;
      border-radius:10px;
    }
    .card-link:hover{
      color:#1b834f;
      border:2px solid #1b834f;
      background-color:white;
      box-shadow:0 0 5px rgba(0,0,0,0.5);
    }
  </style>
</head>
<body>
  <?php
    require_once("../HelperFiles/header.php");
    require_once("./DB/db_conn.php");

    class ProductsClass {
      private $pdo;

      public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->displayProducts();
      }

      private function displayProducts() {
        $result = $this->pdo->prepare("SELECT * FROM Products");
        $result->execute();
        echo '<div class="products-container">';
        while ($row = $result->fetch()) {
          echo '<div class="card">';
          echo '<div class="img">';
          echo '<img src="' . $row["ImageURL"] . '" class="card-img-top" alt="' . $row["ProductName"] . '">';
          echo '</div>';
          echo '<div class="card-body">';
          
          echo '<h5 class="card-title">' . $row["ProductName"] . '</h5>';
          echo '<p class="card-text"><b>Product ID:</b>' . $row["ProductID"] . '</p>';
         
          echo '<p class="card-text"><b>Price:</b> $' . $row["Price"] . '</p>';
          echo '<p class="card-text"><b>Stock:</b> $' . $row["Quantity"] . '</p>';
          echo '<p class="card-desc">' . $row["SmallDescription"] . '</p>';
          echo '</div>';
       
          echo '<div class="card-body">';
          echo "<a  class='card-link' href='../AdityaShroff/detail.php?product_id={$row['ProductID']}'>View Details</a>";
          echo '</div>';
          echo '</div>';
        }
        echo '</div>'; // Close products-container
      }
    }

    // Create a Database object and get the PDO connection
    $db = new Database();
    $pdo = $db->getConnection();
    new ProductsClass($pdo);
  ?>

  <main>
    <!-- Additional content if needed -->
  </main>

  <?php
    require_once("../HelperFiles/footer.php");
  ?>
</body>
</html>
