<!DOCTYPE html>
<html>
<head>
  <title>RAMT Coffee and Accessories</title>
  <link rel="stylesheet" type="text/css" href="../HelperFiles/style.css">
  <style>
    .products-container {
      padding: 20px 0;
      display: grid;
      grid-template-columns: repeat(4, 22%);
      justify-content: center;
      gap: 20px;
      background-color: rgb(221, 238, 223);
      color: #1b834f;
    }
    .card {
      color: #1b834f;
      width: 100%;
      box-sizing: border-box;
      padding: 20px;
      border-radius: 30px;
      box-shadow: 0 0 10px rgba(0,0,0,0.5);
    }
    .card .img {
      width: 100%;
      height: 20rem;
      overflow: hidden;
    }
    .card .img img {
      width: 100%;
      height: 100%;
    }
    .card .img img:hover {
      transform: scale(1.05);
      transition: all 0.5s linear;
    }
    .card-title {
      text-align: center;
      font-weight: 600;
      font-size: 1.3rem;
      color: #1b834f;
    }
    .card-text {
      font-size: 1rem;
      padding:0 10px;
      color: #1b834f;
    }
    .card-desc {
      font-size: 1rem;
      margin:10px;
    }
    .card-link {
      background-color: #1b834f;
      padding: 10px 20px;
      text-decoration: none;
      color: white;
      border-radius: 10px;
    }
    .card-link:hover {
      color: #1b834f;
      border: 2px solid #1b834f;
      background-color: white;
      box-shadow: 0 0 5px rgba(0,0,0,0.5);
    }
    .select_container {
      text-align: center;
      font-size: 1.3rem;
      margin-bottom: 10px;
    }
    select {
      width: 25%;
      margin-left: 10px;
      color: #1b834f;
    }
    span {
      font-size: 1.3rem;
      font-weight: 600;
      color: #1b834f;
      text-transform: uppercase;
      margin-right: 5px;
    }
  </style>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#categorySelect').change(function() {
        var categoryID = $(this).val();
        $.ajax({
          url: 'fetch_products.php',
          type: 'POST',
          data: { categoryID: categoryID },
          success: function(response) {
            $('.products-container').html(response);
          }
        });
      });
    });
  </script>
</head>
<body>
  <?php
    require_once("../HelperFiles/header.php");
    require_once("./ProductsClass.php");

   
    $productClass = new ProductsClass();    
    $productClass->displayCategories();
    $productClass->displayProducts();
  ?>

  <?php
    require_once("../HelperFiles/footer.php");
  ?>
</body>
</html>
