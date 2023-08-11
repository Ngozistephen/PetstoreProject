<?php

    $fields_1 = array ("fusername" =>"User Name", "fpassword" =>"Password");
    $fields_2 = array ("loginName" => " User Name", "password" => "Password", "email" =>"Email", "firstName" =>" First Name", "lastName" =>"Last Name", "street" =>"Street", "city" =>"City", "state" =>"State" ,"zip" =>"Zip", "phone"=>"Phone", "fax"=>"Fax");

    include("function12.inc");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Costumer Login Page</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="style.css">
    <script src="js/jquery-slim.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
</head>
<body style ="margin: 0">
        <div id ="wrapper">
            <div id ="login">
                <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
                        <fieldset><legend> Login Form</legend>
                    
                
                <?php
                        if (isset($message_1)) {
                            echo "<P class ='errors'> $message_1</p> \n";
                        }

                        foreach ($fields_1 as $field => $value) {
                            if (preg_match("/pass/i", $field)) 
                                $type ="password";

                            else
                                $type="text";
                            
                            echo" <div id ='field'><label for ='$field'>$value</label>
                                    <input id=' $field' name ='$field' type='$type' value='".@$$field."' size='20' maxlength ='50'/></div> \n";        
                        }
                ?>
                        <input type="submit" name="Button" style='margin-left:45%; margin-botttom:.5em' value="log in" />
                        </fieldset>

                </form>
                <h3> If you already have an account please, log in.</h3>
                <h3> If you don't have an account. please, register now.</h3>        
            </div>

            <div id="reg">
                    <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
                            <fieldset><legend> Registration Form</legend>
                                <?php 
                                    if (isset($message_2)) {
                                        echo "<p class ='errors'> $message_2 </p> \n";
                                    }
                                    foreach ($fields_2 as $field => $value) {
                                        if ($field =="state") {
                                            echo "<div id='field'>
                                                    <label for ='$field'>$value</label>
                                                    <select name='state' id='$field'>";
                                                    $stateName =getStateName();
                                                    $stateCode = getStateCode();

                                                    for ($n=1; $n<=4 ; $n++) { 
                                                        $state= $stateName[$n];
                                                        $scode=$stateCode[$n];

                                                        echo"<option value ='$scode'";
                                                        if (isset($_POST['state'])) {
                                                            if ($_POST['state'] == $scode) {
                                                                echo "selected='selected'";
                                                            }
                                                        }
                                                        else{
                                                            if ($n <2) {
                                                                echo "selected='selected'";
                                                            }
                                                        }
                                                        echo">$state \n</option>";

                                                    }
                                                    echo "</select>
                                                </div>";
                                        }

                                        else {
                                            if (preg_match("/pass/i", $field)) {
                                                $type ="password";
                                            }    
                                                else 
                                                    $type ="text";

                                                echo "<div id ='field'>
                                                            <label for ='$field'> $value</label>
                                                            <input id='$field' name ='$field' type='$type' value ='".@$$field."' size='40' maxlenghth ='65' /></input>
                                                    </div> \n";
                                            
                                        } //end else
                                    }// end foreach field
                                
                                ?>

                                <input type="submit"  name="Button"  style='margin-left:45%; margin-bottom: .5em' value="Register" />
                            
                            </fieldset>
                    </form>    
            </div>


        </div>
</body>
</html>

