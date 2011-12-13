<?php
session_start();
if (empty($_SESSION['count'])) {
 $_SESSION['count'] = 1;
} else {
 $_SESSION['count']++;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd" 
>
<html>
</html>
<head>
  <title>Virtual Lab - PID Control</title>
  <meta name="keywords" content="Automatic Control Lab, Virtual Lab, Automatic Control Playground" >
  <meta name="description" content="Online automatic control lab." >
  <meta name="author" content="Pantelis Sopasakis">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
  <script type='text/javascript' src="./chung.js"></script>
  <link rel="stylesheet" type="text/css" href="./style.css" >
  <link rel="shortcut icon" href="/vlab/favicon.ico" type="image/x-icon" />
</head>
<body id="body" onload="loadMe();">
  <div id="wrap">
    <div id="background">
      <img src="./images/background.jpg" class="stretch" alt="" >
    </div>
    <div id="leftcolumn">
      <?include('./sidebar.php');?>
    </div>
    <div id="rightcolumn">
      <!-- LEFT COLUMN -->
<div id="banner">
	<img src="/vlab/images/banner.gif" alt="" id="didi">
	</div>
    </div>
    <div id="container">
      <div id="nav">
      </div>
      <div id="centercolumn">
        <h1>
           Virtual Lab 
        </h1>
        <h3>
           List of available experiments 
        </h3>
        <div id="scopeMessage" class="smallTip">
          <ol>
            <li>
              <a href="./p">A closed loop with a P-controller</a>
            </li>
            <li>
              <a href="./pid">A closed loop system with a PID-controller</a>
            </li>
          </ol>
        </div>
      </div>
    </div>
    <div class="footer" id="footer">
      <? include('./footer.php') 
      ?>
    </div>
  </div>
</body>
</html>
