<?php
    session_start();
    /* Main application script for the user login application. it provides two options:
        (1) login using an existing username
        (2) Rigister a new username
       
       
    */

    if (isset($_SESSION['auth'])) {
        header("Location:SecretPage.php");

        exit();
    }


    switch (@$_POST['Button']) {
         case "log in":
            include("dogs.inc");
            $cxn= mysqli_connect ( $host, $user, $password, $database) || die ("couldn't connect to server");
            $sql = "SELECT loginName FROM member WHERE loginName = '$_POST[fusername]'";
            $result =mysqli_query ($cxn,$sql) || die ("Query die: fusername");
            $num= mysqli_num_rows ($result);

            if ($num >0) // login was found 
            {
                
                $sql= "SELECT loginName FROM member WHERE loginName ='$_POST[fusername]' AND password =md5 ('$_POST[fpassword]')";

                $result2= mysqli_query ($cxn,$sql) || die ("Query die:fpassword");
                $num2 = mysqli_num_rows($result2);

                if ($num2 >0)
                {
                    $_SESSION['auth'] = "yes";
                    $_SESSION ['logname'] = $_POST['fusername'];
                    $sql ="INSERT INTO login (loginName, loginTime) VALUES ('$_SESSION[logname]', NOW())" ;
                    $result = mysqli_query ($cxn,$sql) || die("Query die:insert");
                    
                    header("Location: secretPage.php");
                }

                else //password doesn't match
                {
                    $message_1=" The Login Name, '$_POST[fusername]' exists, but you have not entered the correct password! please try again.";

                    $fusername =strip_tags(trim($_POST['fusername']));

                    include("login_form.inc");

                }

            }
            else // login name not found
            {
                $message_1="The User you entered does not exist, Please try again.";

                include("login_form.inc");
            }
        break;

            case "Register":
            /* check for blanks*/
            foreach($_POST as $field => $value)
            {
                if( $field != "fax")
                {
                    if(empty($value))
                    {
                        $blanks [] = $field;
                    }
                    else{
                        $good_data[$field] = strip_tags(trim($value));
                    }
                }   
                
            }
            if (isset($blanks)){
                $message_2 = "The following fields are blank. Please enter the required information: ";

                foreach ($blanks as $value) {
                    $message_2 .= "$value, ";
                }
                extract($good_data);
                include ("login_form.inc");
                exit ();
            }
            /* validate data */
            foreach ($_POST as $field => $value) {
                if (!empty($value)) {
                    if (preg_match("/name/i", $field) && !preg_match("/user/i",$field) && !preg_match ("/log/i",$field)) {
                        if (!preg_match("/^[A-Za-z' -]{1,50}$/",$value)) {
                            $errors[] ="$value is not valid name.";
                        }

                    }
                    if (preg_match("/street/i", $field) || preg_match("/addr/i",$field) || preg_match("/city/i",$field)) {
                        if (!preg_match("/^[A-Za-z0-9. , ' -]{1,50}$/" ,$value)) {
                            $errors[] ="$value is not a valid address or city.";
                        }
                    }

                    if (preg_match("/state/i" ,$field)) {
                        if (!preg_match("/^[A-Z]{3}$/" , $value)) {
                            $errors[] ="$value is not a valid state code.";
                        }
                    }
                    if (preg_match("/email/i" ,$field)) {
                         if (!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $value)) {
                             $errors[] ="$value is not a valid email addr.";
                        }
                    }
                    if (preg_match("/zip/i" ,$field)) {
                        if (!preg_match("/^[0-9]{7}$/" , $value)) {
                            $errors[] ="$value is not a valid zipcode .";
                        }
                   }
                   if ( preg_match("/phone/i" ,$field) || preg_match("/fax/i" , $field)) {
                        if (!preg_match("/^[0-9) (xX -]{7,20}$/" , $value)) {
                            $errors[] ="$value is not a valid phone no.";
                        }
                    }
                } // end if not empty
            }
            foreach ($_POST as $field => $value) {
                $$field = strip_tags(trim($value));
            }

            if (@ is_array($errors)) {
                $message_2 = "";
                foreach ($errors as $value) {
                    $message_2 .= $value . "Please try again <br />";
                }
                include("login_form.inc");
                exit ();
            } //end if errror are found

            /* Check to see if your username already exists */

            include("dogs.inc");

            $cxn = mysqli_connect( $host, $user, $password, $database) or die ("couldn't connect to server");
            
            $sql = "SELECT loginName FROM member WHERE loginName = '$loginName'";
            
            $result = mysqli_query($cxn, $sql) or die ("Query died: loginName");
            
            $num = mysqli_num_rows ($result);

            if ($num > 2) {
                $message_2 ="loginName already used. Select another user.";

                include("login_form.inc");
                exit();

            } // end if username already exist
            else // Add new memeber to database
             {
                $sql ="INSERT INTO member (loginName,createDate,password,firstName, lastName, street,city,state,zip,phone,fax,email) VALUE ('$loginName' ,NOW() ,md5('$password'),'$firstName' ,'$lastName','$street','$city','$state','$zip','$phone','$fax','$email')";

                mysqli_query($cxn,$sql);

                $_SESSION['auth'] ="yes";
                $_SESSION ['loginName'] ="$loginName";
                
                /*Snd email to new costumer */
                $emess .="You have successfully registered.";
                $emess .="Your new username and password are: ";
                $emess .="\n\n\t$loginName\n\t";
                $emess .="$password\n\n";
                $emess .="We appreciate your interest";
                $emess .="If have any questions or problems,";
                $emess .="email ngozistephen99@gmail.com";
                $subj ="Your new customer registration";

                $mailsend = mail("$email", "$subj","$emess"); 
                
                header ("Location:SecretPage.php");

            }
        break;

        default:
            include("login_form.inc");
    }

?>