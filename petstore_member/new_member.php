<?php
    session_start();

    if (@$_SESSION['auth'] != "yes") {
        
        header("Location:login.php");

        exit();
    }
    include("dogs.inc");

    $cxn= mysqli_connect($host, $user,$password,$database) || die ("Counld't connect to server.");
    $sql = "SELECT FROM firstName, lastName FROM member WHERE loginName ='{$_SESSION['logname']}'";
    $result = mysqli_query ($cxn,$sql) || die("Couldn't connect to server");
    $row = mysqli_fetch_assoc($result);

    extract($row);

    echo "<html>
            <head><title>New Member Welcome</title></head> 
            
            <body>
                    <h2 style= 'margin-top: .7in ; text-align: center'> Welcome $firstName $lastName</h2> \n";
            
        

?>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ea minima nisi maxime! Sint voluptas aliquam perferendis dolor obcaecati dolorum alias dolore voluptate, facilis blanditiis sunt error illum, delectus voluptatem. Minus!</p>
                <p> Your new Member ID and password were emailed to you. Please store them carefully for future use</p>
                 <div style="text-align:center">
                    <p style ="margin-top: .5in; font-weight:bold"> Glad you could jion us !</p>

                    <form action="member_page.php" method="post">
                        <input type="Submit" value="Enter the Member Only Section">
                    </form>

                    <form action="PetShopFrontMembers.php" method="post">
                        <input type="Submit" value="Go to Pet Store Main Page">
                    </form>
                 </div>   
            </body>

            </html> 