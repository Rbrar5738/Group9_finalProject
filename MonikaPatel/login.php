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
    
       $email=$obj->cleanValue($_POST["email"]);
    
       $password=$obj->cleanValue($_POST["password"]);

     
      $errors=[];
  
      $errors[]=$obj->validateEmail($email);
      $errors[]=$obj->validatePassword($password); 

      
               
     // Remove empty values from the errors array
     $errors = array_filter($errors);

      if(!empty($errors))
      {
          foreach($errors as $err)
          echo $err;
      }
      else
      {     
        $message=$obj->login($email,$password);
       
        if($message)
        {
          
           header("Location: ../RavinderSingh/home.php");
        }
        else
        {
            echo "<p class='error'>Wrong email or password!</p>";
        }

      }

      }


  
     
  ?>
  



            <form class="registerForm" id="login" method="post">
                <h3>Login</h3>
                        
             
                             
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
                    <div></div>
                    <button class="btnSubmit" type="submit">Submit</button>
                    <div></div>
                   </div>


                   <div class="field">
                    <div></div>
                    <a class="btnRegister" href="./register.php">Register</a>
                    <div></div>
                   </div>
            </form>
        
        


</main>


<?php
    require_once("../HelperFiles/footer.php");
  ?>
</body>
</html>