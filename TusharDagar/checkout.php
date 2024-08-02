<?php
require_once("../RavinderSingh/redirect.php");
$redirect=new redirect();
$redirect->redirectIfNotLoggedIn();
?>
<!DOCTYPE html>
<html>
<head>
  <title>RAMT coffee_mug_insulated</title>
  <link rel="stylesheet" type="text/css" href="../HelperFiles/style.css">

</head>
<body>
<main>
<?php
require_once("../HelperFiles/header.php");
require_once("./checkoutClass.php");

?>

<h1 class="checkTitle">CheckOut</h1>
<?php
    require_once("../HelperFiles/header.php");
    require_once("./checkoutClass.php");
    $obj=new checkoutClass();
    $user = $obj->getCarUserData();


    if($_SERVER["REQUEST_METHOD"]=="POST")
    {
       
   
    //Getting the values from form fields and storing in the variables
       $firstName=$obj->cleanValue($_POST["firstName"]); 
       $lastName=$obj->cleanValue($_POST["lastName"]);
       $email=$obj->cleanValue($_POST["email"]);
       $cellNumber=$obj->cleanValue($_POST["cellNumber"]);
       $houseNo=$obj->cleanValue($_POST["houseNo"]);
       $street=$obj->cleanValue($_POST["street"]);
       $city=$obj->cleanValue($_POST["city"]);
       $postal=$obj->cleanValue($_POST["postal"]);
       $province=$obj->cleanValue($_POST["province"]);
       $cardNo=$obj->cleanValue($_POST["cardNo"]);
       $cvv=$obj->cleanValue($_POST["cvv"]);
       $expiry=$obj->cleanValue($_POST["expiry"]);
       $cardHolderName=$obj->cleanValue($_POST["cardHolderName"]);

      $errors=[];
      $errors[]=$obj->validateFirstName($firstName);
      $errors[]=$obj->validateLastName($lastName);
      $errors[]=$obj->validateEmail($email);
      $errors[]=$obj->validateMobile($cellNumber);
      $errors[]=$obj->validateHouseNo($houseNo); 
      $errors[]=$obj->validateStreetname($street);
      $errors[]=$obj->validateCityName($city);  
      $errors[]=$obj->validatePostalCode($postal);    
      $errors[]=$obj->validateProvince($province);  
      $errors[]=$obj->validateCardNo($cardNo);
      $errors[]=$obj->validateCvv($cvv);      
      $errors[]=$obj->validateExpiry($expiry);  
      $errors[]=$obj->validateCardHolerName($cardHolderName);             
     // Remove empty values from the errors array
     $errors = array_filter($errors);

      if(!empty($errors))
      {
          foreach($errors as $err)
          echo $err;
      }
      else
      {     
        // $obj->emptyCart();
        echo "<script>alert('Order is placed successfully!');</script>";
        header("Location: ../RavinderSingh/invoicePDF/invoicePDF.php");
        exit();

      }
   

      

      }

     
  ?>
  



            <form class="checkForm" method="post">
                <h3>Contact Information</h3>
                
                <div class="field">
                    <label for="firstName">First Name</label>
                    <input type="text" id="firstName" name="firstName" placeholder="Enter First name here" value="<?php echo htmlspecialchars($user[0]['FirstName']) ?? "" ?>">
                    <small>*</small>
                </div> 
                
                
                <div class="field">
                    <label for="lastName">Last Name</label>
                    <input type="text" id="lastName" name="lastName"  placeholder="Enter Last name here" value="<?php echo htmlspecialchars($user[0]['LastName']) ?? "" ?>">
                    <small>*</small>
                </div>
             
                             
                 <div class="field">
                    <label for="email">E-Mail</label>
                    <input type="text" id="email" name="email" placeholder="Enter email here" value="<?php echo htmlspecialchars($user[0]['Email']) ?? "" ?>">
                    <small>*</small>
                </div>
                
                 <div class="field">
                    <label for="cellNumber">Cell Number</label>
                    <input type="text" id="cellNumber" name="cellNumber"  placeholder="Enter Cell number here" value="<?php echo htmlspecialchars($user[0]['Mobile']) ?? "" ?>">
                    <small>*</small>
                </div>

                <h3>Bitting Address</h3>
                
                  <div class="field">
                    <label for="houseNo">House No</label>
                    <input type="text" id="houseNo" name="houseNo" value="<?php echo $houseNo ?? "" ?>" placeholder="Enter House No">
                    <small>*</small>
                </div>
                
                 <div class="field">
                    <label for="street">Street</label>
                    <input type="text" id="street" name="street" value="<?php echo $street ?? "" ?>" placeholder="Enter Street Name">
                    <small>*</small>
                </div>
                
                <div class="field">
                    <label for="city">City</label>
                    <input type="text" id="city" name="city" value="<?php echo $city ?? "" ?>" placeholder="Enter City">
                    <small>*</small>
                </div>

                <div class="field">
                    <label for="postal">Postal Code</label>
                    <input type="text" id="postal" name="postal" value="<?php echo $postal ?? "" ?>" placeholder="Enter Postal Code">
                    <small>*</small>
                </div>

                <div class="field">
                <label for="province">Province</label>
                <select id="province" name="province" value="<?php echo $province ?? "" ?>">
                <option value="">Select Province</option>
                    <option value="AB" <?php echo (isset($province) && $province == "AB") ? "selected" : ""; ?>>Alberta</option>
                    <option value="BC" <?php echo (isset($province) && $province == "BC") ? "selected" : ""; ?>>British Columbia</option>
                    <option value="MB" <?php echo (isset($province) && $province == "MB") ? "selected" : ""; ?>>Manitoba</option>
                    <option value="NB" <?php echo (isset($province) && $province == "NB") ? "selected" : ""; ?>>New Brunswick</option>
                    <option value="NL" <?php echo (isset($province) && $province == "NL") ? "selected" : ""; ?>>Newfoundland and Labrador</option>
                    <option value="NS" <?php echo (isset($province) && $province == "NS") ? "selected" : ""; ?>>Nova Scotia</option>
                    <option value="ON" <?php echo (isset($province) && $province == "ON") ? "selected" : ""; ?>>Ontario</option>
                    <option value="PE" <?php echo (isset($province) && $province == "PE") ? "selected" : ""; ?>>Prince Edward Island</option>
                    <option value="QC" <?php echo (isset($province) && $province == "QC") ? "selected" : ""; ?>>Quebec</option>
                    <option value="SK" <?php echo (isset($province) && $province == "SK") ? "selected" : ""; ?>>Saskatchewan</option>
                    <option value="NT" <?php echo (isset($province) && $province == "NT") ? "selected" : ""; ?>>Northwest Territories</option>
                    <option value="NU" <?php echo (isset($province) && $province == "NU") ? "selected" : ""; ?>>Nunavut</option>
                    <option value="YT" <?php echo (isset($province) && $province == "YT") ? "selected" : ""; ?>>Yukon</option>
                </select>
                <small>*</small>
               </div>
                <h3>Bitting Address</h3>

                <div class="field">
                    <label for="cvv">Card No</label>
                    <input type="text" id="cardNo" name="cardNo" value="<?php echo $cardNo ?? "" ?>" placeholder="Enter Card No Name">
                    <small>*</small>
                </div>

                <div class="field">
                    <label for="cvv">CVV</label>
                    <input type="text" id="cvv" name="cvv" value="<?php echo $cvv ?? "" ?>" placeholder="Enter CVV No Name">
                    <small>*</small>
                </div>

                <div class="field">
                    <label for="expiry">Card Expiry Date</label>
                    <input type="text" id="expiry" name="expiry" value="<?php echo $expiry ?? "" ?>" placeholder="Enter Expiry DD/MM">
                    <small>*</small>
                </div>

                
                <div class="field">
                    <label for="cardHolderName">Card Holder Name</label>
                    <input type="text" id="cardHolderName" name="cardHolderName" value="<?php echo $cardHolderName ?? "" ?>" placeholder="Enter Card Holder Name here">
                    <small>*</small>
                </div>
                
                <div class="field">
                    <div></div>
                    <button class="btnSubmit" type="submit">Submit</button>
                    <div></div>
                </div>
            </form>
        
        


</main>


<?php
    require_once("../HelperFiles/footer.php");
  ?>
</body>
</html>