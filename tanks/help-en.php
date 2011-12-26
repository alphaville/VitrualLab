<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd" 
    >
<html>   
    <head>
        <title>Help: Level Control of Coupled Tanks</title>
        <meta name="keywords" content="Automatic Control Lab, Virtual Lab, Automatic Control Playground" >
        <meta name="description" content="Online automatic control lab." >
        <meta name="author" content="Pantelis Sopasakis">
        <meta http-equiv="Pragma" content="no-cache">
        <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, post-check=0, pre-check=0, max-age=0">
        <meta http-equiv="Expires" content="0">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
        <link rel="stylesheet" type="text/css" href="../style.css" >
        <link rel="stylesheet" type="text/css" href="./style-tanks.css" >
        <script type="text/javascript" src="../tooltip/script.js"></script>
        <script type='text/javascript' src="../chung.js"></script>
        <script type='text/javascript' src="../ga.js"></script>
        <script type='text/javascript' src="./tanks.js"></script>
        <link rel="shortcut icon" href="/vlab/favicon.ico" type="image/x-icon">
    </head>
    <body id="body" >        
        <script type='text/javascript' src="../wz_tooltip.js"></script>
        <script type='text/javascript' src="../tip_balloon.js"></script>

        <?
        include('../global.php');
        ?>
        <div id="wrap">
            <div id="background">
                <img src="../images/background.jpg" class="stretch" alt="" >
            </div>
            
            <div id="help-body" style="margin-left: 20px;margin-top:40px;margin-right:20px;font-size: small">
                <h1>Help</h1>
                <h3>1. Prerequisites</h3>
                <p align="justify">
                    The completion of the exercise assumes understanding of system
                    dynamics in the Laplace space and tuning techniques for PID
                    controllers such as the <b>IMC</b> method or the <b>Ziegler-Nichols</b> method.
                    The user should also be able to derive the transfer function of the
                    underlying system of the coupled tanks using mass transfer principles.
                </p>
                <h3>2. Scope of the exercise</h3>
                <p align="justify">
                    The scope of this exercise is to acquaint the students with various
                    <b>tuning</b> methods for PID controllers and see how different choice of 
                    parameters reflects to different system dynamics.
                </p>
                <h3>3. Tips and Tricks</h3>
                <p align="justify">
                    sdf
                </p>
            </div>
            
            <div class="footer" id="footer">
                <!-- -->  <? include('../footer.php') ?>
            </div>
        </div>
    </body>
</html>
