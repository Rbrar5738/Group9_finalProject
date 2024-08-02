<?php
<<<<<<< HEAD
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once("../RavinderSingh/DB/db_conn.php");
=======
require_once("../RavinderSingh/DB/db_conn.php")
>>>>>>> 60e4ea5c1cf46763b77013e9beca051354ce7931
?>

<head>
    <title>Coffee and Accessories</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="header">
        <div id="logo">
            <img src="../TusharDagar/public/Images/logo.png" alt="Logo image of RAMT Coffee">
        </div>
        <div>
            <h1>Coffee And Accessories</h1>
        </div>
        <div id="span">
         
        <?php
            if (isset($_SESSION["UserId"])) {
             
                echo '<a href="../MonikaPatel/logout.php">Logout</a>';
            } else {
              
                echo '<a href="../MonikaPatel/login.php">Login</a>';
            }
            ?>
         
        </div>
    </div>
<<<<<<< HEAD

    <nav>
        <ul>
            <li><a id="nav" href="../RavinderSingh/home.php">Home</a></li>
            <li><a id="nav" href="../RavinderSingh/products.php">Products</a></li>
            <li><a id="nav" href="../RavinderSingh/cart.php">Cart</a></li>
        </ul>
    </nav>
</body>
=======
    <div id="span">
      <a href="../MonikaPatel/login.php">Login</a>
  </div>
  </div>

  <nav>
    <ul>
      <li><a id="nav" href="../RavinderSingh/home.php">Home</a></li>
      <li><a id="nav" href="../RavinderSingh/products.php">Products</a></li>
      <li><a id="nav" href="#">Cart</a></li>
    </ul>
  </nav>
</body>
>>>>>>> 60e4ea5c1cf46763b77013e9beca051354ce7931
