<?php

class Database {
    private $host = 'localhost';
    private $db_name = 'coffeeAndAccessories';
    private $username = 'root';
    private $password = '';
    private $charset = 'utf8mb4';
    private $pdo;

    public function __construct() {
        if (defined("INITIALIZING_DATABASE")) {
            $dsn = "mysql:host={$this->host};charset={$this->charset}";
        } else {
            $dsn = "mysql:host={$this->host};dbname={$this->db_name};charset={$this->charset}";
        }

        try {
            $this->pdo = new PDO($dsn, $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->pdo;
      }
    public function initializeDatabase() {
        try {
            // Drop and recreate database
            $this->pdo->exec("DROP DATABASE IF EXISTS {$this->db_name}");
            $this->pdo->exec("CREATE DATABASE {$this->db_name}");
            $this->pdo->exec("USE {$this->db_name}");

            // Create Users table
            $this->createUsersTable();

            // Create Categories table
            $this->createCategoriesTable();

            // Create Products table
            $this->createProductsTable();

            // Create Cart table
            $this->createCartTable();

              // Insert categories value
              $this->insertCategories();

              // Insert products value
              $this->insertProducts();

            echo "<h3>Database Initialized</h3>";
        } catch (PDOException $e) {
            die("Initialization failed: " . $e->getMessage());
        }
    }

    private function createUsersTable() {
        $this->pdo->exec("CREATE TABLE Users (
            UserID INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
            FirstName VARCHAR(100) NOT NULL,
            LastName VARCHAR(100) NOT NULL,
            Email VARCHAR(100) UNIQUE NOT NULL,
            Password VARCHAR(250) NOT NULL,          
            Mobile INT
        )");
    }

    private function createCategoriesTable() {
      $this->pdo->exec("CREATE TABLE Categories (
          CategoryID INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
          CategoryName VARCHAR(50) NOT NULL
      )");
  }
    private function createProductsTable() {
        $this->pdo->exec("CREATE TABLE Products (
        ProductID INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        ProductName VARCHAR(100) NOT NULL,
        SmallDescription VARCHAR(255),
        LargeDescription varchar(2000) NOT NULL,
        Price DECIMAL(10, 2) NOT NULL,
        ImageURL VARCHAR(255) NOT NULL,
        Quantity INT DEFAULT 0 NOT NULL,
        CategoryID INT NOT NULL,
        FOREIGN KEY (CategoryID) REFERENCES Categories(CategoryID)
        )");
    }



    private function createCartTable() {
        $this->pdo->exec("CREATE TABLE Cart (
        CartID INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        UserID INT,
        ProductID INT,
        Quantity INT,
        Price DECIMAL(10, 2) NOT NULL,
        FOREIGN KEY (UserID) REFERENCES Users(UserID),
        FOREIGN KEY (ProductID) REFERENCES Products(ProductID)
        )");
    }




    private function insertCategories() {
      try {
          $categories = [
              ['CategoryID' => 1, 'CategoryName' => 'Coffee'],
              ['CategoryID' => 2, 'CategoryName' => 'Coffee Maker'],
              ['CategoryID' => 3, 'CategoryName' => 'Coffee Grinder'],
              ['CategoryID' => 4, 'CategoryName' => 'Coffee Filter'],
              ['CategoryID' => 5, 'CategoryName' => 'Coffee Dripper'],
              ['CategoryID' => 6, 'CategoryName' => 'Coffee Mug'],
              ['CategoryID' => 7, 'CategoryName' => 'Coffee Scale'],
              ['CategoryID' => 8, 'CategoryName' => 'Coffee Container']
          ];
  
          $sql = "INSERT INTO Categories (CategoryID, CategoryName) VALUES (:CategoryID, :CategoryName)";
          $stmt = $this->pdo->prepare($sql);
  
          foreach ($categories as $category) {
              $stmt->execute($category);
          }
  
          echo "Categories inserted successfully.";
      } catch (PDOException $e) {
          die("Error inserting categories: " . $e->getMessage());
      }
  }





private function insertProducts() {
  try {
     
      $sql = "INSERT INTO Products (ProductName, SmallDescription, LargeDescription, Price, ImageURL, Quantity, CategoryID)
              VALUES (:productName, :smallDescription, :largeDescription, :price, :ImageURL, :Quantity, :categoryID)";

    
      $stmt = $this->pdo->prepare($sql);

      
          $products = [
          [
              'productName' => 'Espresso Roast Coffee',
              'smallDescription' => 'Rich, full-bodied espresso roast with a bold flavor.',
              'largeDescription' => 'Our Espresso Roast Coffee is crafted from high-quality Arabica beans, meticulously roasted to bring out a rich, full-bodied flavor with a bold, dark finish. Perfect for espresso lovers who enjoy a robust, intense coffee experience. The complex flavors of this roast are enhanced by its smoky undertones and a hint of chocolate, making it an ideal choice for those who appreciate a strong and satisfying cup. Whether enjoyed as a morning pick-me-up or a post-dinner treat, this espresso roast promises to deliver a consistently exceptional taste.',
              'price' => 15.99,
              'ImageURL'=>'..\TusharDagar\public\Images\espresso_roast.png',
              'Quantity'=>10,
              'categoryID' => 1 
          ],
          [
              'productName' => 'Colombian Medium Roast Coffee',
              'smallDescription' => 'Smooth and balanced Colombian medium roast coffee.',
              'largeDescription' => 'This Colombian Medium Roast Coffee offers a smooth, balanced flavor profile with notes of caramel and cocoa. Sourced from the finest coffee farms in Colombia, this blend provides a delightful, aromatic experience, perfect for any time of day. The medium roast level brings out the natural sweetness of the beans, creating a well-rounded cup with a bright acidity and a clean finish. Ideal for drip brewing or French press, this coffee will brighten your mornings and provide a comforting, flavorful sip whenever you need it.',
              'price' => 13.99,
              'ImageURL'=>'..\TusharDagar\public\Images\columbian_roast.png',
              'Quantity'=>25,
              'categoryID' => 1 
          ],
          [
              'productName' => 'French Vanilla Flavored Coffee',
              'smallDescription' => 'Delightful French vanilla flavored coffee.',
              'largeDescription' => 'Indulge in the delightful taste of our French Vanilla Flavored Coffee. This aromatic blend combines premium Arabica beans with the rich, creamy essence of French vanilla, creating a smooth and satisfying coffee experience that’s perfect for a cozy morning or an afternoon treat. The subtle sweetness of vanilla perfectly complements the smooth coffee base, offering a comforting and indulgent drink. Ideal for pairing with pastries or desserts, this flavored coffee brings a touch of elegance and warmth to any occasion.',
              'price' => 14.99,
              'ImageURL'=>'..\TusharDagar\public\Images\french_vanilla.png',
              'Quantity'=>40,
              'categoryID' => 1 
          ],
          [
              'productName' => 'Dark Chocolate Mocha Coffee',
              'smallDescription' => 'Decadent dark chocolate infused mocha coffee.',
              'largeDescription' => 'Experience the decadent taste of our Dark Chocolate Mocha Coffee. This rich blend combines high-quality Arabica coffee with the deep, luscious flavor of dark chocolate, creating a perfect harmony of bitterness and sweetness. Each sip reveals layers of complex flavors, making it an ideal choice for chocolate lovers and coffee enthusiasts alike. Enjoy it as a luxurious treat in the morning or as an indulgent dessert coffee.',
              'price' => 16.99,
              'ImageURL'=>'..\TusharDagar\public\Images\dark_chocolate_coffee.png',
              'Quantity'=>45,
              'categoryID' => 1 
          ],
          [
              'productName' => 'Hazelnut Flavored Coffee',
              'smallDescription' => 'Smooth and nutty hazelnut flavored coffee.',
              'largeDescription' => 'Delight in the smooth, nutty flavor of our Hazelnut Flavored Coffee. This blend features premium Arabica beans infused with the rich, buttery essence of roasted hazelnuts, creating a creamy and aromatic coffee experience. Perfect for any time of day, this flavored coffee is a deliciously satisfying treat that pairs wonderfully with breakfast pastries or a slice of pie.',
              'price' => 14.99,
              'ImageURL'=>'..\TusharDagar\public\Images\hazelnut_coffee.png',
              'Quantity'=>55,
              'categoryID' => 1 
          ],
          [
              'productName' => 'Caramel Macchiato Coffee',
              'smallDescription' => 'Sweet and creamy caramel macchiato coffee.',
              'largeDescription' => 'Indulge in the sweet and creamy flavors of our Caramel Macchiato Coffee. This blend combines premium Arabica beans with the rich, buttery taste of caramel and a hint of vanilla, creating a delightful coffee experience that’s both smooth and satisfying. Perfect for those who love their coffee with a touch of sweetness, this caramel macchiato is ideal for enjoying with friends or as a special treat just for you.',
              'price' => 15.49,
              'ImageURL'=>'..\TusharDagar\public\Images\caramel_macchiato_coffee.png',
              'Quantity'=>62,
              'categoryID' => 1 
          ],
          [
              'productName' => 'Organic Ethiopian Coffee',
              'smallDescription' => 'Bright and fruity organic Ethiopian coffee.',
              'largeDescription' => 'Savor the bright, fruity flavors of our Organic Ethiopian Coffee. This single-origin coffee is grown organically in the highlands of Ethiopia, offering a unique flavor profile with notes of citrus and floral undertones. The light to medium roast preserves the natural acidity and vibrant character of the beans, making it a refreshing and invigorating choice for coffee connoisseurs.',
              'price' => 17.99,
              'ImageURL'=>'..\TusharDagar\public\Images\ethiopia_yirgacheffe_cofffee.png',
              'Quantity'=>22,
              'categoryID' => 1 
          ],
          [
              'productName' => 'Decaf House Blend Coffee',
              'smallDescription' => 'Smooth and flavorful decaf house blend coffee.',
              'largeDescription' => 'Enjoy the smooth, rich taste of our Decaf House Blend Coffee without the caffeine. This carefully crafted blend features premium Arabica beans, decaffeinated to maintain their full flavor and aroma. Perfect for those who prefer a decaf option, this house blend offers a well-balanced cup with notes of chocolate and a hint of nuttiness, making it a delightful choice any time of day.',
              'price' => 12.99,
              'ImageURL'=>'..\TusharDagar\public\Images\house_blend_coffee.png',
              'Quantity'=>43,
              'categoryID' => 1 
          ],
          [
              'productName' => 'Cinnamon Spice Coffee',
              'smallDescription' => 'Warm and aromatic cinnamon spice coffee.',
              'largeDescription' => 'Warm up with the aromatic flavors of our Cinnamon Spice Coffee. This blend combines high-quality Arabica beans with a touch of cinnamon and spice, creating a cozy and comforting coffee experience. Perfect for chilly mornings or festive gatherings, this cinnamon spice coffee adds a special twist to your daily brew, making each cup a delightful treat.',
              'price' => 13.99,
              'ImageURL'=>'..\TusharDagar\public\Images\cinnamon_coffee.png',
              'Quantity'=>35,
              'categoryID' => 1 
          ],
          [
              'productName' => 'Cold Brew Coffee',
              'smallDescription' => 'Smooth and refreshing cold brew coffee.',
              'largeDescription' => 'Refresh yourself with the smooth, rich taste of our Cold Brew Coffee. Made from premium Arabica beans, this cold brew is slow-steeped to perfection, resulting in a less acidic and more concentrated coffee. Ideal for enjoying over ice or as a base for iced coffee drinks, this cold brew offers a refreshing and invigorating way to enjoy your favorite beverage.',
              'price' => 18.99,
              'ImageURL'=>'..\TusharDagar\public\Images\cold_brew_coffee.png',
              'Quantity'=>30,
              'categoryID' => 1 
          ],
          [
              'productName' => 'Stainless Steel Coffee Grinder',
              'smallDescription' => 'Durable stainless steel coffee grinder for fresh grounds.',
              'largeDescription' => 'The Stainless Steel Coffee Grinder offers precision grinding for fresh coffee grounds every time. Its durable construction and adjustable settings ensure the perfect grind consistency, whether you prefer a coarse grind for French press or a fine grind for espresso. The sleek, compact design fits easily on any countertop, while the easy-to-clean parts make maintenance a breeze. This grinder\'s powerful motor and sharp blades provide consistent results, ensuring that you get the best flavor extraction from your coffee beans with every use.',
              'price' => 25.99,
              'ImageURL'=>'..\TusharDagar\public\Images\coffee_grinder_stainless_steel.png',
              'Quantity'=>10,
              'categoryID' => 3
          ],
          [
              'productName' => 'French Press Coffee Maker',
              'smallDescription' => 'Classic French press coffee maker for rich, flavorful brews.',
              'largeDescription' => 'Enjoy rich, flavorful coffee with our Classic French Press Coffee Maker. Made from high-quality glass and stainless steel, this French press allows you to brew coffee to your desired strength, preserving the natural oils and flavors for a truly authentic coffee experience. The ergonomic handle and durable construction ensure a comfortable and long-lasting use. Whether you\'re brewing for yourself or hosting a gathering, this French press makes the perfect addition to any coffee lover kitchen. Its timeless design also makes it a stylish serving piece for any occasion.',
              'price' => 29.99,
              'ImageURL'=>'..\TusharDagar\public\Images\french_press_coffee_maker.png',
              'Quantity'=>10,
              'categoryID' => 2 
          ],
          [
              'productName' => 'Reusable Coffee Filter',
              'smallDescription' => 'Eco-friendly reusable coffee filter for drip coffee makers.',
              'largeDescription' => 'Make an eco-friendly choice with our Reusable Coffee Filter, designed for use with most drip coffee makers. This filter is made from high-quality, durable materials that ensure a clean, crisp coffee taste while reducing waste and saving you money in the long run. Easy to clean and maintain, it provides a sustainable alternative to disposable paper filters. The fine mesh construction ensures that all the rich flavors of your coffee are preserved while preventing any grounds from slipping through. By switching to a reusable filter, you\'re not only improving your coffee experience but also contributing to a healthier planet.',
              'price' => 12.99,
              'ImageURL'=>'..\TusharDagar\public\Images\coffee_filter.png',
              'Quantity'=>10,
              'categoryID' => 4
          ],
          [
              'productName' => 'Electric Milk Frother',
              'smallDescription' => 'Handheld electric milk frother for creamy froth.',
              'largeDescription' => 'Create café-quality froth at home with our Electric Milk Frother. This handheld frother is perfect for making creamy, frothy milk for your lattes, cappuccinos, and other coffee drinks. Its powerful motor and easy-to-use design make it a must-have accessory for any coffee lover. Simply immerse the frother in your milk, press the button, and watch as it creates a rich, velvety foam in seconds. Compact and easy to clean, it is an essential tool for elevating your coffee experience.',
              'price' => 19.99,
              'ImageURL'=>'..\TusharDagar\public\Images\frother.png',
              'Quantity'=>10,
              'categoryID' => 2 
          ],
          [
              'productName' => 'Insulated Travel Mug',
              'smallDescription' => 'Double-walled insulated travel mug to keep beverages hot or cold.',
              'largeDescription' => 'Take your favorite coffee on the go with our Insulated Travel Mug. Featuring double-walled insulation, this travel mug keeps your beverages hot or cold for hours. Its leak-proof lid ensures no spills, while the ergonomic design makes it easy to hold and drink from. Made from high-quality stainless steel, it’s durable and built to last. Whether you\'re commuting to work or heading out for an adventure, this travel mug is the perfect companion for keeping your coffee at the ideal temperature.',
              'price' => 17.99,
              'ImageURL'=>'..\TusharDagar\public\Images\coffee_mug_insulated.png',
              'Quantity'=>10,
              'categoryID' => 6 
          ],
          [
              'productName' => 'Coffee Scale with Timer',
              'smallDescription' => 'Precision coffee scale with built-in timer for perfect brewing.',
              'largeDescription' => 'Achieve perfect coffee brewing with our Coffee Scale with Timer. This precision scale ensures accurate measurement of coffee and water, essential for consistently great-tasting coffee. The built-in timer helps you track brewing time, making it ideal for pour-over and other manual brewing methods. Its sleek design and easy-to-read display make it a functional and stylish addition to your coffee setup. Whether you are a novice or an expert, this coffee scale will help you elevate your brewing skills.',
              'price' => 29.99,
              'ImageURL'=>'..\TusharDagar\public\Images\coffee_scale.png',
              'Quantity'=>10,
              'categoryID' => 7
          ],
          [
              'productName' => 'Coffee Storage Canister',
              'smallDescription' => 'Airtight coffee storage canister to keep beans fresh.',
              'largeDescription' => 'Keep your coffee beans fresh with our Airtight Coffee Storage Canister. Designed to preserve the flavor and aroma of your beans, this canister features a vacuum seal that locks out air and moisture. The durable stainless steel construction ensures long-lasting use, while the sleek design looks great on any countertop. A built-in date tracker helps you monitor freshness, so you always enjoy the best-tasting coffee. Perfect for any coffee enthusiast who values freshness and quality.',
              'price' => 22.99,
              'ImageURL'=>'..\TusharDagar\public\Images\coffee_container.png',
              'Quantity'=>10,
              'categoryID' => 8 
          ],
          [
              'productName' => 'Pour-Over Coffee Maker',
              'smallDescription' => 'Elegant pour-over coffee maker for precise brewing.',
              'largeDescription' => 'Elevate your coffee brewing with our Pour-Over Coffee Maker. This elegant and functional device allows you to brew coffee with precision, controlling every variable for a perfect cup. Made from high-quality glass and stainless steel, it’s designed for durability and style. The reusable stainless steel filter ensures pure, rich flavors without the need for paper filters. Ideal for coffee aficionados who appreciate the art of brewing, this pour-over coffee maker provides a refined and enjoyable coffee experience.',
              'price' => 34.99,
              'ImageURL'=>'..\TusharDagar\public\Images\pour_over_coffee_maker.png',
              'Quantity'=>10,
              'categoryID' => 2 
          ],
          [
              'productName' => 'Ceramic Coffee Dripper',
              'smallDescription' => 'Classic ceramic coffee dripper for pour-over brewing.',
              'largeDescription' => 'Brew delicious pour-over coffee with our Classic Ceramic Coffee Dripper. This timeless design ensures even extraction and a rich, full-bodied flavor. Made from high-quality, heat-resistant ceramic, it retains heat for optimal brewing temperature. The dripper’s conical shape and spiral ridges guide water through the coffee grounds evenly, enhancing the brewing process. Compatible with standard coffee filters, it’s a simple yet effective way to enjoy handcrafted coffee at home.',
              'price' => 15.99,
              'ImageURL'=>'..\TusharDagar\public\Images\coffee_dripper.png',
              'Quantity'=>10,
              'categoryID' => 5 
          ],
          [
              'productName' => 'Cold Brew Coffee Maker',
              'smallDescription' => 'Convenient cold brew coffee maker for smooth, rich coffee.',
              'largeDescription' => 'Make smooth, rich cold brew coffee at home with our Cold Brew Coffee Maker. This convenient and easy-to-use device allows you to steep coffee grounds in cold water, resulting in a less acidic and more flavorful brew. The large capacity ensures you have plenty of coffee to enjoy throughout the week. Made from durable glass and stainless steel, it’s designed for long-lasting use. The built-in filter keeps grounds out of your coffee, ensuring a clean and refreshing drink every time. Perfect for hot summer days or anytime you crave a refreshing coffee beverage.',
              'price' => 27.99,
              'ImageURL'=>'..\TusharDagar\public\Images\cold_brew_coffe_maker.png',
              'Quantity'=>10,
              'categoryID' => 2 
          ],
      ];

   
      foreach ($products as $product) {
          $stmt->execute($product);
      }

      echo "Products inserted successfully.";
  } catch (PDOException $e) {
      die("Error inserting products: " . $e->getMessage());
  }
}
}

?>
