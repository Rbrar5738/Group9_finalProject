<?php
// session_start();
require_once("../RavinderSingh/DB/db_conn.php");
class checkoutClass{

  private $pdo;
  private $userID;
    //Initializing the database object using constructor
    public function __construct() {
      $db = new Database();
      $this->pdo = $db->getConnection();      
      // Set the userID from session if available
      if (isset( $_SESSION["UserId"])) {
        $this->userID =filter_var( $_SESSION["UserId"],FILTER_VALIDATE_INT);
        
      }
    }

  function cleanValue($value){
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
             return "<p class='error'>Digits are not allowed in Last Name</p>"; 
         }     
       
       }
            
          // Fuction for validations for the Email
         function validateEmail($value)
         {  
          if(empty($value))
          {
            return "<p class='error'>Email is Required</p>"; 
          }
          else if(!filter_var($value,FILTER_VALIDATE_EMAIL))
          {
           return "<p class='error'>Wrong Email Format</p>";  
          }       
        }
            
          // Fuction for validations for the Mobile Number
          function validateMobile($value)
          {  
           if(empty($value))
           {
             return "<p class='error'>Mobile Number is Required</p>"; 
           }
           else if(!$this->checkDigits($value))
           {
            return "<p class='error'>Only Digits are allowded in Mobile Number.</p>";  
           }
           else if(strlen($value)!=10)
           {
               return "<p class='error'>Cell Number must contain 10 digits</p>"; 
           } 
           if($this->checkSameDigits($value))
           {
             return "<p class='error'>Invalid Cell Number with all same digits</p>";
           }      
         }  

          // Fuction for validations for the Email
          function validateHouseNo($value)
          {  
           if(empty($value))
           {
             return "<p class='error'>House No is Required</p>"; 
           }      
         } 

          // Fuction for validations for the Email
          function validateStreetname($value)
          {  
           if(empty($value))
           {
             return "<p class='error'>Street Name is Required</p>"; 
           }      
         } 
       //Fuction for Last Name Valodation
       function validateCityName($value)
       {
         if(empty($value))
         {
           return "<p class='error'>City Name is Required</p>";
         }
        else if ($this->checkDigits($value)) 
         {
             return "<p class='error'>Digits are not allowed in City Name</p>"; 
         }       
       } 
        // Function for Postal Code Validation
        function validatePostalCode($value) {
          if (empty($value)) 
          {
            return "<p class='error'>Postal Code is Required</p>";
          } 
          else if (!preg_match("/^[A-Za-z]\d[A-Za-z]\d[A-Za-z]\d$/", $value)) 
          {
            return "<p class='error'>Postal Code must be in A1A1A1 format</p>";
          }
          else if(strlen($value)!=6)
          {
              return "<p class='error'>Postal Code must contain 6 Chatacters</p>"; 
          } 
         }

        // Function for Province Validation
         function validateProvince($value) {
          // List of valid Canadian provinces and territories
          $validProvinces = [
              'Alberta', 'British Columbia', 'Manitoba', 'New Brunswick', 
              'Newfoundland and Labrador', 'Northwest Territories', 'Nova Scotia', 
              'Nunavut', 'Ontario', 'Prince Edward Island', 'Quebec', 
              'Saskatchewan', 'Yukon'
          ];
      
          if (empty($value)) 
          {
            return "<p class='error'>Province is Required</p>";
          } 
          else if (in_array($value, $validProvinces)) 
          {
              return "<p class='error'>Please select province from the list</p>"; 
          }
        }
          // Fuction for validations for the Card Number
          function validateCardNo($value)
          {  
           if(empty($value))
           {
             return "<p class='error'>Card Number is Required</p>"; 
           }
           else if(!$this->checkDigits($value))
           {
            return "<p class='error'>Only Digits are allowded in Card Number.</p>";  
           }
           else if(strlen($value)!=16)
           {
               return "<p class='error'>Cell Number must contain 16 digits</p>"; 
           } 
           if($this->checkSameDigitsCard($value))
           {
             return "<p class='error'>Invalid Card Number with all same digits</p>";
           }      
         } 
          // Fuction for validations for the Card Number
          function validateCvv($value)
          {  
           if(empty($value))
           {
             return "<p class='error'>CVV Number is Required</p>"; 
           }
           else if(!$this->checkDigits($value))
           {
            return "<p class='error'>Only Digits are allowded in CVV Number.</p>";  
           }
           else if(strlen($value)!=3)
           {
               return "<p class='error'>CVV must contain 3 digits</p>"; 
           }           
          }

          // Function for Expiry Date Validation
          function validateExpiry($value)
          {
                      
              $currentDate = new DateTime();
              $expiryDateTime = DateTime::createFromFormat('m/y', $value);
              // $expiryDateTime->modify('last day of this month');
              
            if(empty($value))
            {
                return "<p class='error'>Expiry Date is Required</p>";
            } 
            else if(!preg_match("/^(0[1-9]|1[0-2])\/([0-9]{2})$/", $value))
            {
                return "<p class='error'>Invalid Expiry Date format. Use MM/YY.</p>";
            }
            else if($expiryDateTime <= $currentDate) 
            {
              return "<p class='error'>Card is expired.</p>";
            }
            }
  
       //Fuction for Card Holder Name Valodation
       function validateCardHolerName($value)
       {
         if(empty($value))
         {
           return "<p class='error'>Card Holder Name is Required</p>";
         }
       else if ($this->checkDigits($value)) 
         {
             return "<p class='error'>Digits are not allowed in Card Holder Name</p>"; 
         }       
       } 
       
       
    
  public function emptyCart() {
    $sql = "DELETE FROM Cart WHERE UserID = :UserID";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([':UserID' => $this->userID]);
  }


//Function to get dxata of a user for Users table
  public function getCarUserData() {
    if (isset( $_SESSION["UserId"])) {
      $userID =filter_var(  $_SESSION["UserId"],FILTER_VALIDATE_INT);      
    }
    $sql = "SELECT * FROM Users            
            WHERE UserID = :UserID";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([':UserID' => $this->userID]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  
   }

        
             
      
        

      

?>