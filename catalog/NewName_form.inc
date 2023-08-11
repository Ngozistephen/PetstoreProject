<?php
    
    $labels= array("petName"=> "petName: ", "petDescription" => "petDescription: ", "price" =>"Price", "pix" => "Picture file name:", "petColor" => "Pet color (Optional)");

    if(isset($_POST['Category']))
    {
        $category = $_POST['category'];
    } 
    else
    {
        $category = @$_POST['new_cat']; 
    }
?>

<html>
        <head>
            <title>New Pet Information Form</title>
            <style>
                    <!--
                    form{margin:1em; padding: 0;}
                    .field { padding-top: .5em;}
                    label { font-weight: bold; float: left; width: 18%; margin-right: 1em; text-align: right;}
                    #submit {margin-top: 1em}

                    ---->
            </style>
        </head>
        <body>
            <form action= "AddPet.php" method ="post">
                <?php

                    echo "<h4>Pet Information</h4>";
                    echo" <div class ='field'> <label> Pet Category:</label> <b>$category</b>
                        </div> \n" ;   

                    foreach ($labels as $field => $label)
                    {
                        echo "<div class='field'> 
                        <label for= '$field'>$label</label> 
                        <input type= 'text' name='$field' id ='$field'
                            size='65' maxlength ='65' value='".@$$field."'/></div> \n ";
                    }       
                ?>
                
                <div id="submit">
                    <input type='hidden' name='new_cat' value= '<?php echo $category ?>' />
                    <input type='submit' value='Submit Pet Name' />
                    <input type= 'submit' name='newbutton' value='Cancel' />
                </div>
            </form>
        </body>
</html>