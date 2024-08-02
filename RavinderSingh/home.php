<!DOCTYPE html>
<html>
<head>
  <title>RAMT coffee_mug_insulated</title>
  <link rel="stylesheet" type="text/css" href="../HelperFiles/style.css">
  <style>
    #dateDayContainer {
      float: right; 
      margin-top: -55px; 
      margin-right: 20px; 
      background-color: rgba(255, 255, 255, 0.8);
      padding: 5px 10px;
      border-radius: 5px; 
      box-shadow: 0 2px 2px rgba(0, 0, 0, 0.3); 
      z-index: 1000; 
      color: #1b834f;
    }
  </style>
</head>
<body>
  <?php
    require_once("../HelperFiles/header.php");

    // Fetch current date and time from WorldTimeAPI using cURL
    $timezone = 'America/Toronto';
    $apiUrl = "http://worldtimeapi.org/api/timezone/$timezone";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $jsonData = curl_exec($ch);
    curl_close($ch);

    $dateTimeData = json_decode($jsonData, true);
    
    // Get current date and day name
    $currentDateTime = $dateTimeData['datetime'] ?? 'Unable to fetch time.';
    $dateTime = new DateTime($currentDateTime);
    $currentDay = $dateTime->format('l'); // Get the day name
    $currentDate = $dateTime->format('Y-m-d'); // Format the date

    // Fetch weather data from Open-Meteo API (no API key required)
    $latitude = 43.4515; // Latitude for Kitchener
    $longitude = -80.4925; // Longitude for Kitchener
    $weatherApiUrl = "https://api.open-meteo.com/v1/forecast?latitude={$latitude}&longitude={$longitude}&current_weather=true";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $weatherApiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $weatherDataJson = curl_exec($ch);
    curl_close($ch);

    $weatherData = json_decode($weatherDataJson, true);
    $temperature = $weatherData['current_weather']['temperature'] ?? 'N/A'; // Get the temperature
    $city = "Kitchener"; // City name
  ?>
  
  <main>

    <!-- Added div to display the current date, day name, and temperature -->
    <div id="dateDayContainer">
      <?php echo "$currentDay, $currentDate | $city: $temperature °C"; ?>
    </div>

    <div class="home-header-container">
      <img src="../TusharDagar/public/Images/header.png" alt="Header Image of different coffee boxes">
      <div id="h2" class="header-img-text">Taste the Freshness, Feel the Difference!</div>
    </div>

    <div id="homeitem3">
      <p id="homebodyText">
      Welcome to RAMT Coffee, your virtual destination for exquisite coffee experiences! At RAMT, we pride ourselves on offering a curated selection of premium coffee beans sourced from around the globe, along with a variety of accessories to enhance your brewing ritual. Explore our virtual aisles stocked with a diverse range of roasts and flavors, from rich espresso blends to delicate single origins. Whether you're a connoisseur seeking the perfect brew or a coffee enthusiast exploring new flavors, RAMT Coffee ensures quality and convenience in every sip. Connect with our knowledgeable virtual assistants for personalized recommendations and brewing tips. Embrace the art of coffee with RAMT Coffee – your gateway to exceptional coffee moments, delivered to your door. Brew excellence, sip satisfaction, and elevate your experience with our range of accessories at RAMT Coffee.
      </p>
    </div>

    <section id="homesection1">
      <div id="h2Title">
        <h2 style="text-align:center;">We guarantee to provide you fresh items!</h2>
      </div>

      <div id="homeitem2">
        <div id="imageContainer">
          <img src="../TusharDagar/public/Images/coffeePlant.png" alt="Image of Coffee beans with plant in background">
        </div>
      </div>

      <div id="homeitem1">
        <h3 id="homeitem1h3">Why RAMT Coffee?</h3>
        <p>
          "Discover unbeatable deals at RAMT Grocery! Step into a world of freshness and savings with our wide
          selection of high-quality coffee, accessories. From farm-fresh coffee and best accessories, we've got everything you need to fill your basket without emptying
          your wallet."
        </p>
      </div>
    </div>
    
</section>

</main>

<?php
    require_once("../HelperFiles/footer.php");
?>
</body>
</html>
