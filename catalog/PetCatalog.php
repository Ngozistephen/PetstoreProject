<?php
    include("misc.inc");

    $cxn= mysqli_connect ( $host, $user, $password, $database) or die ("couldn't connect to server");
    $query= "SELECT * FROM pettype ORDER BY petType";
    $result = mysqli_query ($cxn,$query) or die ("Couldn't execute query.");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Pet Types</title>
</head>
<body>

    <div style="margin-left: .1in">
        <h1 style="text-align: center" > Pet Catalog</h1>
        <h2 style="text-align:center">The following animal friends are waiting for you.</h2>
        <p style="text-align:center"> Find just what you want and hurry in to the store to pick your new friend.</p>
        <h3>Which pet are you interested in?</h3>

        <form action='ShowPets.php' method='POST'>
            <table cellpadding='5' border='1'>
                <?php
                    $counter=1;
    
                    while ($row = mysqli_fetch_assoc ($result))
                    {
                        extract ($row);
                        ?>
                        <tr>
                            <td valign='top' width='15%' style="font-weight:bold; font-size: 1.2em">
            
                                <input type="radio" id="<?php echo $counter;?>" name="interest" value="<?php echo $petType?>" <?php echo $counter == 1 ? 'checked="checked"' : ''?>>
                                
                                <label for="<?php echo $counter;?>"><?php echo "$petType";?> </label>
                                
                            </td>
                            <td>
                                <?php echo $typeDescription ?>
                            </td>
                        </tr>
                        <?php 
                        $counter++;
                    }
                ?>
            
            </table>
            <p><input type='submit' value='Select Pet Type'></p>
        </form>


    </div>   
</body>
</html>