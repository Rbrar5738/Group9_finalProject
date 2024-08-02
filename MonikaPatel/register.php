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
require_once("./handleAccount.php");

?>

<h1 class="checkTitle">Regiter With Us</h1>
<?php
 


    if($_SERVER["REQUEST_METHOD"]=="POST")
    {
       $obj=new handleAccount();
   
    //Getting the values from form fields and storing in the variables
       $firstName=$obj->cleanValue($_POST["firstName"]); 
       $lastName=$obj->cleanValue($_POST["lastName"]);
       $email=$obj->cleanValue($_POST["email"]);
       $cellNumber=$obj->cleanValue($_POST["cellNumber"]);
       $password=$obj->cleanValue($_POST["password"]);
       $conformPassword=$obj->cleanValue($_POST["conformPassword"]);
     
      $errors=[];
      $errors[]=$obj->validateFirstName($firstName);
      $errors[]=$obj->validateLastName($lastName);
      $errors[]=$obj->validateEmail($email);
      $errors[]=$obj->validateMobile($cellNumber);
      $errors[]=$obj->validatePassword($password); 
      $errors[]=$obj->validateConfirmPassword($conformPassword);
      $errors[]=$obj->validateMatchPassword($password,$conformPassword);
      
               
     // Remove empty values from the errors array
     $errors = array_filter($errors);

      if(!empty($errors))
      {
          foreach($errors as $err)
          echo $err;
      }
      else
      {     
        $message=$obj->registerUser( $firstName,$lastName,$email,$password,$cellNumber);
       
        if($message)
        {
            echo "<script>alert('User Registered Successfully'); window.location.href='login.php';</script>";
        }
        else
        {
            echo "<p class='error'>Email already registered!</p>";
        }

      }

      }
     
  ?>
  



            <form class="registerForm" method="post">
                <h3>Registration Infromation</h3>
                
                <div class="field">
                    <label for="firstName">First Name</label>
                    <input type="text" id="firstName" name="firstName" value="<?php echo $firstName ?? "" ?>" placeholder="Enter First name here">
                    <small>*</small>
                </div> 
                
                
                <div class="field">
                    <label for="lastName">Last Name</label>
                    <input type="text" id="lastName" name="lastName" value="<?php echo $lastName ?? "" ?>" placeholder="Enter Last name here">
                    <small>*</small>
                </div>
             
                             
                 <div class="field">
                    <label for="email">E-Mail</label>
                    <input type="text" id="email" name="email" value="<?php echo $email ?? "" ?>" placeholder="Enter email here">
                    <small>*</small>
                </div>
            
                
                <div class="field">
                  <label for="password">Password</label>
                  <input type="password" id="password" name="password" value="<?php echo $password ?? "" ?>" placeholder="Enter Password">
                  <small>*</small>
              </div>
              
               <div class="field">
                  <label for="conformPassword">Conform Password</label>
                  <input type="password" id="conformPassword" name="conformPassword" value="<?php echo $conformPassword ?? "" ?>" placeholder="Enter Conform Password">
                  <small>*</small>
              </div>

              <div class="field">
              <label for="cellNumber">Cell Number</label>
                    <input type="text" id="cellNumber" name="cellNumber" value="<?php echo $cellNumber ?? "" ?>" placeholder="Enter Cell number here">
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