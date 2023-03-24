<?php
session_start();
$id = $_REQUEST['id'];
$_SESSION['userid'] = $id;

?>


<!DOCTYPE html>
<html>
<body>

<input type="text" id="mobile_number" placeholder="mobile_number"><br><br>
<input type="text" id="amount" placeholder="amount"><br><br>
<input type="text" id="payment_code" placeholder="payment_code"><br><br>
<input type="button" id="button" value="submit">

<div id="feedback"></div>

<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript" src="Show.js"></script>

</body>
</html>