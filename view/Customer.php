<!DOCTYPE HTML>  
<html>
    <head>
        <style>
            error {color: #FF0000;}
        </style>
    </head>
    <body>  
        <?php
// define variables and set to empty values
        $Customer_NameErr = $Customer_NumberErr = $Contact_NumberErr = $AddressErr = $SalesAreaErr = $Type_of_SalesoutletErr = $Category_of_CustomerErr = "";
        $Customer_Name = $Customer_Number = $Contact_Number = $Address = $SalesArea = $Type_of_Salesoutlet = $Category_of_Customer = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($_POST["Customer_Name"])) {
                $Customer_NameErr = "Name is required";
            } else {
                $Customer_Name = test_input($_POST["Customer_Name"]);
                // check if name only contains letters and whitespace
                if (!preg_match("/^[a-zA-Z ]*$/", $Customer_Name)) {
                    $Customer_NameErr = "Only letters and white space allowed";
                }
            }

            if (empty($_POST["Customer_Number"])) {
                $Customer_NumberErr = "Customer Number is required";
            } else {
                $Customer_Number = test_input($_POST["Customer_Number"]);
                // check if e-mail address is well-formed
                if (!filter_var($Customer_Number, FILTER_VALIDATE_Customer_INT) === false) {
                    echo("Variable is an integer");
                } else {
                    
                }
            }

            if (empty($_POST["Contact_Number"])) {
                $Contact_NumberErr = "Contact Number is required";
            } else {
                $Contact_Number = test_input($_POST["Contact_Number"]);
                // check if e-mail address is well-formed
                if (!filter_var($Contact_Number, FILTER_VALIDATE_Customer_INT) === false) {
                    echo("Variable is an integer");
                } else {
                    
                }
            }
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($_POST["Address"])) {
                $AddressErr = "Address is required";
            } else {
                $Address = test_input($_POST["Address"]);
                // check if name only contains letters and whitespace
                if (!preg_match("/^[a-zA-Z ]*$/", $Address)) {
                    $AddressErr = "Only letters and white space allowed";
                }
            }
        }



        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($_POST["SalesArea"])) {
                $SalesAreaErr = "SalesArea is required";
            } else {
                $SalesArea = test_input($_POST["SalesArea"]);
                // check if name only contains letters and whitespace
                if (!preg_match("/^[a-zA-Z ]*$/", $SalesArea)) {
                    $SalesAreaErr = "Only letters and white space allowed";
                }
            }
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($_POST["Type_of_Salesoutlet"])) {
                $Type_of_SalesoutletErr = "Type_of_Salesoutlet is required";
            } else {
                $Type_of_Salesoutlet = test_input($_POST["Type_of_Salesoutlet"]);
                // check if name only contains letters and whitespace
                if (!preg_match("/^[a-zA-Z ]*$/", $Type_of_Salesoutlet)) {
                    $Type_of_Salesoutlet = "Only letters and white space allowed";
                }
            }
        }



        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($_POST["Category_of _Customer"])) {
                $Category_of_CustomerErr = "Category_of_Customer is required";
            } else {
                $Category_of_Customer = test_input($_POST["Category_of_Customer"]);
                // check if name only contains letters and whitespace
                if (!preg_match("/^[a-zA-Z ]*$/", $Category_of_Customer)) {
                    $Category_of_Customer = "Only letters and white space allowed";
                }
            }
        }

        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        ?>


        
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">  
            Customer Name: <input type="text" name="name" value="<?php echo $Customer_Name; ?>">
            <span class="error"> <?php echo $Customer_NameErr; ?></span>
            <br><br>
            Customer Number: <input type="text" name="Customer Number" value="<?php echo $Customer_Number; ?>">
            <span class="error"> <?php echo $Customer_NumberErr; ?></span>
            <br><br>
            Contact Number: <input type="text" name="Contact Number" value="<?php echo $Contact_Number; ?>">
            <span class="error"><?php echo $Contact_NumberErr; ?></span>
            <br><br>

            Address:  <textarea name="message" rows="1" cols="20"> </textarea>
  <br>
            <span class="error"><?php echo $AddressErr; ?></span>
            <br><br>




            SalesArea: <select>
  <option value="Aba">Aba</option>
  <option value="Abuja">Abuja</option>
  <option value="Lagos">Lagos</option>
  <option value="Enugu">Enugu</option>
</select>
            <br><br>
            



            Type of Salesoutlet: <input type="text" name="Type of Salesoutlet" value="<?php echo $Type_of_Salesoutlet; ?>">
            <span class="error"><?php echo $Type_of_SalesoutletErr; ?></span>
            <br><br>




            Category of Customer:  <select>
  <option value="Cash Customers">Cash Customers</option>
  <option value="Direct Customers">Direct Customers</option>
  <option value="Credit Customers">Credit Customers</option>
 
</select>
            <br><br>
            <span class="error"><?php echo $Category_of_CustomerErr; ?></span>
            <br><br>

       <input type="submit" name="submit" value="Submit">  
        
        
        
        
        </form>

    </body>
</html>