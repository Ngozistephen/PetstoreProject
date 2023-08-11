<?php
    
    if (@$_POST['newbutton'] ==  "Cancel") {
        header ("Location: ChoosePetCat.php");
    }

    include ("misc.inc");

    $cxn = mysqli_connect ($host, $user, $password,$database) or die ("Couldn't connect to server");

    foreach ($_POST as $field => $value) {
        if (empty ($value)) {
            if ($field == "petName" || $field == "petDescription"){
                $blank_array[] = $field;
            }
        }else {
            if($field != "category") {
                if (!preg_match ("/^[A-Za-z0-9.,_-]+$/", $value)){
                    $error_array[] = $field;
                }

                if ($field == "new_cat"){
                    $clean_data['petType'] = trim (strip_tags($value));
                }else {
                    $clean_data["$field"] = trim (strip_tags($value));
                }    
            }
        }    
    }

    if (@sizeof ($blank_array) > 0 or @sizeof ($error_array) >0){
        if (@sizeof ($blank_array) > 0){
            echo "<p><b>You must enter both Pet name and Pet description</b></p> \n" ;
        }

        if (@sizeof ($blank_array) > 0){
            echo "<p><b>The following fields have incorrect information. Only letters, numbers, spaces, underscores and hyphens are allowed:</b><br></p> \n" ;

            foreach ($error_array as $value){
                echo "&nbsp; &nbsp; $value <br /> \n ";
            }  
        }   

        extract ($clean_data);

        include ("NewName_Form.inc");

        exit();
    }

    foreach ($clean_data as $field => $value){
        if (!empty ($value) and $field != "petColor"){
            $fields_form[$field] = ucfirst (strtolower(strip_tags(trim($value))));

            $fields_form[$field] =mysqli_real_escape_string ($cxn, $fields_form[$field]);

            if ($field == "price")
            {
                $fields_form [$field] =(float) $fields_form[$field] ;
            }

        }

        if (!empty ($_POST [ 'petColor']))
        {
            $petColor = strip_tags(trim($_POST ['petColor']));

            $petColor = ucfirst (strtolower ($petColor));

            $petColor = mysqli_real_escape_string ($cxn, $petColor);
        }    
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Pet</title>
</head>
<body>
    <?php 
        
        $field_array = array_keys ($fields_form);

        $fields = implode (",", $field_array);

        $query = "INSERT INTO Pet ($fields) VALUE (";

        foreach ($fields_form as $field => $value)
            {
                
                if ($field == "price")
                {
                    $query .= "$value ," ;
                }
                
                else
                {
                    $query .= "'$value' ,";
                } 
                    
            }

            $query .=  ") " ;

            $query = preg_replace (" /,\) /",") " ,$query) ;

            $result = mysqli_query ($cxn ,$query) or die ("Couldn't cexecute query") ;

            $petID = mysqli_insert_id($cxn) ;

            $query = "SELECT * from Pet WHERE petID ='$petID' ";

            $result = mysqli_query ($cxn, $query) or die ("Couldn't execute query.") ;

            $row = mysqli_fetch_assoc($result);
            extract ($row) ;

            echo "The following pet has been added to the Pet Catalog: <br />
                    <ul>
                        <li> Category: $petType</li>
                        <li> Pet Name: $petName</li>
                        <li> Pet Description: $petDescription</li>
                        <li> Price: \$$price</li>
                        <li>Picture file: $pix </li>
                    </ul>
                    \n";

            if (@$petColor != "")
                {

                    $query = "SELECT petName FROM Color WHERE petName ='$petName' AND petColor ='$petColor'";

                    $result =mysqli_query ($cxn, $query) or die ("Couldn't execute query.");

                    $num = mysqli_num_rows ($result);

                    if ($num < 1)
                    {
                        $query ="INSERT INTO Color (petName, petColor, pix) VALUES ('$petName', '$petColor', '$pix')";
                        $result =mysqli_query($cxn, $query) or die ("Couldn't execute query." .mysqli_error($cxn));

                        echo "<li>Color: $petColor</li> \n";
                    }
                }        

                echo "</ul> \n";
                echo "<a href='ChoosePetCat.php'> Add Another Pet </a> \n";
    ?>
</body>
</html>