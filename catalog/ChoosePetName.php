<?php

    if (@$_POST ['newbutton'] == "Return to category page" or @$_POST['newbutton'] == "Cancel")

    {
        header("Location: ChoosePetCat.php");

    }

    include("misc.inc");
    include ("functions.inc");

    $cxn = mysqli_connect ($host,$user,$password, $database) or die ("couldn't conect to server");

    /* IF  new was selected for the pet category, check if category name and description were filled in. */

    if (@trim($_POST['category']) == "new"){
        $_POST['category'] = trim($_POST['new_cat']);

        if (empty ($_POST['new_cat']) or empty($_POST['newDesc']))
        {
            include("NewCat_form.inc");
            exit ();
        }
        else
        {
            addNewType ($_POST['new_cat'], $_POST['newDesc'], $cxn);
        }

    }
    include("NewName_form.inc");    

?>