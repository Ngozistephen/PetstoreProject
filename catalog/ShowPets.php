<?php
        include("misc.inc");

        $cxn = mysqli_connect($host,$user,$password,$database) or die (mysqli_error($cxn));

        /* Select pets of the given type */
        $query = "SELECT * FROM pet WHERE petType ='{$_POST['interest']}'";
// die($query); 
        $result = mysqli_query ($cxn, $query) or die (mysqli_error($cxn));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Pet Catalog</title>
</head>
<body>
    <?php include_once('header.php') ?> 
    <!-- /* Display results in Table */ -->
    <table cellspacing ='10' border='0' cellpadding='10' width '100%'>
        <tr>
            <td colspan='5' style='text-align: right'> Click on any Picture to see larger version.<hr /></td>
        </tr>

       <?php

        while ($row = mysqli_fetch_assoc ($result))
        {
            $f_price = number_format($row['price'], 2);

            // Check whether pets comes in colours 
            $query = "SELECT * FROM color WHERE petName ='{$row['petName']}'";

            $result2 = mysqli_query( $cxn, $query) or die (mysqli_error ($cxn));

            $ncolors = mysqli_num_rows($result2);
            ?>

            <!-- display row for each pet  -->
            <tr>
                <td><?php echo $row ['petID']?> </td>
            
                <td style='font-weight:bold; font-size: 1.1em'> <?php echo $row ['petName'] ?></td>
            
                <td> <?php echo $row ['petDescription'] ?></td>

                <?php 
                /* displays picture if pet did not come with color */
                    if ( $ncolors <= 1) 
                    {?>
                        <td>
                            <a href="./img/<?php echo $row ['pix'] ?>" border="0"> 
                                <img src ="./img/<?php echo $row['pix'] ?>" border='0' width ='100' height ='80'/> 
                            </a>
                        </td>
                        <?php 
                    } 
                ?>
            
                <td align='center'> <?php echo $f_price ?></td>
            </tr>

            <?php
                /* display row for each color */ 
                if ($ncolors > 1)
                {
                    while ($row2 = mysqli_fetch_assoc ($result2))
                    {?>
                            
                        <tr>
                            <td colspan = 2 >& nbsp; </td>
                            <td> <?php echo $row2 ['petColor'] ?> </td>
                            <td>
                                <a href='./img/$row2 ['pix']' border='0'> 
                                    <img src="../img/<?php echo $row2['pix'] ?>" border="0" width="100" height="80"/>
                                </a>
                            </td>
                        </tr>
                        <?php
                    }
                }
            
        }?>

        <tr><td colspan='5'> <hr /></td></tr>

    </table>

    <div style = 'text-align: center'>
        <a href='PetCatalog.php'><h3>See more pets </h3></a>
    </div>
</body>
</html>