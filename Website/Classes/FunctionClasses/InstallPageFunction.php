<?php
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="shortcut icon" href="/Images/favicon.ico" />
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="/vendor/twbs/bootstrap/dist/js/jquery.js"></script>
        <script type="text/javascript">
            function installPage(page) {      
                
                $.ajax({
                        type: "POST",
                        url: "/Classes/PostSingle/pageinstallresponse.php",
                        cache: false,
                        data: {installpage: page},
                        success: function (response, textStatus, jqXHR) {
                            if(response != "NIL")
                                window.open(response,"_self");
                    }
                });
             }
        </script>
    </head>
    <body>
        <?php
        if(isset($_SESSION["installpage"]) && $_SESSION["purpose"] == "install")
            echo "<script>installPage('" . $_SESSION["installpage"] . "');</script>";
        ?>
    </body>
</html>
