<?php

class handleAccount
{

  function cleanValue($value)
  {
    $value = htmlspecialchars($value);
    $value = htmlentities($value);
    $value = strip_tags($value);
    return $value;
  }

       //Declaration of function of regular expression to check if name contains digits  
       function checkDigits($value)
       {
           $digitsMatch="/\d/";
           if(preg_match($digitsMatch,$value))
           {
               return true;
           }
       }
        //Declaration of function of regular expression to check if Cell number contains Alphabets
        function checkAlphabest($value)
        {
             $alphabetMatch="/[a-zA_Z]/";
            if(preg_match($alphabetMatch,$value))
            {
                return true;
            }
        } 
         //Declaration of function of regular expression to check if Cel number contains all same digits
         function checkSameDigits($value)
         {
              $sameDigits="/0{10}|1{10}|2{10}|3{10}|4{10}|5{10}|6{10}|7{10}|8{10}|9{10}$/";
             if(preg_match($sameDigits,$value))
             {
                 return true;
             }
         } 
         //Declaration of function of regular expression to check if Cel number contains all same digits
         function checkSameDigitsCard($value)
         {
              $sameDigits="/0{16}|1{16}|2{16}|3{16}|4{16}|5{16}|6{16}|7{16}|8{16}|9{16}$/";
             if(preg_match($sameDigits,$value))
             {
                 return true;
             }
         }                

       //Fuction for First Name Valodation
      function validateFirstName($value)
      {
        if(empty($value))
        {
          return "<p class='error'>First Name is Required</p>";
        }
      else if ($this->checkDigits($value)) 
        {
            return "<p class='error'>Digits are not allowed in First Name</p>"; 
        }    
      
      }

       //Fuction for Last Name Valodation
       function validateLastName($value)
       {
         if(empty($value))
         {
           return "<p class='error'>Last Name is Required</p>";
         }
       else if ($this->checkDigits($value)) 
         {
             return "<p class='error'>Digits are not allowed in Last Name</P>";  
         }     
       
       }
            
          // Fuction for validations for the Email
         function validateEmail($value)
         {  
          if(empty($value))
          {
            return "<p class='error'>Email is Required</P>"; 
          }
          else if(!filter_var($value,FILTER_VALIDATE_EMAIL))
          {
           return "<p class='error'>Wrong Email Format</P>";  
          }       
        }
            
          // Fuction for validations for the Mobile Number
          function validateMobile($value)
          {  
           if(empty($value))
           {
             return "<p class='error'>Mobile Number is Required</P>";
           }
           else if(!$this->checkDigits($value))
           {
            return "<p class='error'>Only Digits are allowded in Mobile Number</P>";  
           }
           else if(strlen($value)!=10)
           {
               return "<p class='error'>Cell Number must contain 10 digits</P>"; 
           } 
           if($this->checkSameDigits($value))
           {
             return "<p class='error'>Invalid Cell Number with all same digits</P>"; 
           }      
         }  




        // Function for Password Validation
        function validatePassword($value) {
          if (empty($value)) 
          {
            return "<p class='error'>Password is Required</P>"; 
          } 

          else if(strlen($value)<6)
          {
              return "<p class='error'>Password must contain at least 6 Chatacters</P>"; 
          } 
         }

         
        // Function for Password Validation
        function validateConfirmPassword($value) {
          if (empty($value)) 
          {
            return "<p class='error'>Confirm Password is Required";
          } 

          else if(strlen($value)<6)
          {
              return "<p class='error'>Confirm Password must contain at lease 6 Chatacters</P>"; 
          } 
        }

          // Function to match Password and Confirm Password
        function validateMatchPassword($value,$value2) {
          if(!empty($value) && !empty($value2) )
          {
          if ($value!=$value2)
          {
            return "<p class='error'>Password and Confirm Password do not match</p>";
          } 
        }

         

       
      }
   
      private $pdo;
      public function registerUser($FirstName, $LastName, $Email, $Password, $Mobile)
       {
        $db = new Database();
        $this->pdo = $db->getConnection();

        // Check if the email already exists
        $checkEmailSql = "SELECT COUNT(*) FROM Users WHERE Email = :Email";
        $stmt = $this->pdo->prepare($checkEmailSql);
        $stmt->execute([':Email' => $Email]);
        $emailCount = $stmt->fetchColumn();

        if ($emailCount > 0) 
        {
            // Email already exists
            return false;
        }
         else 
        {
            // Proceed with the registration
            $sql = "INSERT INTO Users (FirstName, LastName, Email, Password, Mobile) VALUES (:FirstName, :LastName, :Email, :Password, :Mobile)";
            $stmt = $this->pdo->prepare($sql);
            $hash = password_hash($Password, PASSWORD_DEFAULT);
            $stmt->execute([
                ':FirstName' => $FirstName,
                ':LastName' => $LastName,
                ':Email' => $Email,
                ':Password' => $hash,
                ':Mobile' => $Mobile
            ]);
            return true;
        }
    }


    public function login($email, $password)
    {
        $db = new Database();
        $this->pdo = $db->getConnection();
        $stmt = $this->pdo->prepare("SELECT UserId, Email, Password FROM Users WHERE Email = :email");
        $stmt->execute(['email' => $email]);

        if ($stmt->rowCount() == 1) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $row["Password"])) {
                session_regenerate_id();
                $_SESSION["UserId"] = $row["UserId"];
                return true;
            }
        }
        return false;
    }
      

  }
      
      
        

      

?>