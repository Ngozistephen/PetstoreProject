<?php

    /*----------------------------------------------------------------------------------------------------------------|
        Program: ChoosePetcat.php
        Desc: Allows users to select a pet type. All the existing pet types from the pettype Table are displayed with radio buttons. A section to enter a pet type is provided. */
        include ("misc.inc") ;
        $cxn = mysqli_connect ($host,$user,$password,$database) or die ("couldn't connect to server");

        $query ="SELECT petType FROM pettype ORDER BY pettype";
        $result= mysqli_query ($cxn, $query) or die ("couldn't connect to server");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Categories</title>
    <style type= 'text/css'>
    
        #new {border: thin solid; margin: 1em 0: padding: 1em;}
        #radio { padding-bottom 1em;}
        .field {paddin-top: .5em;}
        label {font-weight: bold;}
        #new label { width: 20%; float:left; margin-right: 1em; text-align: right;}
        input {margin-left: 1em;}
        #new input{ margin-left: 0;}

    </style>
</head>
<body>
    <?php include_once('header.php') ?> 

    <h3> Select a catagory for the pet you are adding.</h3>
    <p> If you are adding a pet in a catagory that is not listed, choose <b>New catagory</b> and type the name and description of the catagory. Press <b> Sumbit Catagory</b> when you have finished selecting an existing catagory or typing a new catagory.</p>

    
        


        <!-- /* Display form for selecting pet type */ -->

        <form action ='ChoosePetName.php' method='post'> 

            <?php

                $counter= 0;

                while ($row = mysqli_fetch_assoc ($result))
                {
                    extract ($row);

                    echo "<label><input type= 'radio' name='category' value='$petType'";

                        if ($counter==0)
                        {
                            echo "checked ='checked'";
                        }
                    echo "/>$petType</label> \n";
                    $counter++;    
                }
            ?>

    
    
        <div id="new">
            <div id ="radio">
                <label for="catagory">New Category </label>
                    <input type= "radio" name="category" id="catagory" value="new"/>
            </div>

            <div class="field">
                <label for ="newCat"> Catagory name:</label>
                <input type= "text" name="new_cat" size="20" id="newCat" maxlength="20"/>
            </div>

            <div class="field">
                <label for="newDesc">Catagory description: </label>
                <input type="text" name="newDesc" id="newDesc" size="70%" maxlength="255"/>
            </div>
        </div>

    <input type='submit' value='Submit Catagory'/>
    </form>
</body>
</html>