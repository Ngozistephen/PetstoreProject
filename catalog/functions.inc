<?php
     
     function addNewType ($petType, $typeDecription, $cxn)
        {
            /* check whether a new Category is in PetType table. If it is not in table, add it to  table. */

            $query = "SELECT petType FROM pettype WHERE petType ='$petType'";

            $result = mysqli_query ($cxn,$query) or die ("Couldn't execute select query") ;

            $ntype = mysqli_num_rows ($result) ; //

            if ($ntype < 1) //if new type is not in table 
            {
                $petType = ucfirst(strip_tags (trim($petType))) ;

                $typeDecription = ucfirst (strip_tags (trim($typeDecription)));

                $petType = mysqli_real_escape_string ($cxn, $petType);

                $typeDecription = mysqli_real_escape_string ($cxn,$typeDecription);
                $query = "INSERT INTO pettype (petType, typeDescription) VALUES ('$petType' ,'$typeDecription')" ;

                $result = mysqli_query ($cxn, $query) or die (mysqli_error($cxn));
            }
            return;

        }

?>