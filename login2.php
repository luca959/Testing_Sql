<?php
// import credentials
include('mysql_credentials.php');
$con = new mysqli( $mysql_server, $mysql_user, $mysql_pass, $mysql_db );
if ($con->connect_error) die ("Connection failed: " .$con->connect_error);

$user = $_POST['user'];
$pass = $_POST['pass'];
#$pass="' UNION ALL SELECT VERSION(),2,3,4 -- -";
#$pass="' AND ExtractValue(0, CONCAT( 0x5c, VERSION() ) ) -- -";

$query = "SELECT * FROM users WHERE username='admin' AND password='$pass'";
$result = $con->query($query);
echo $con->error;

if($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $username = $row["username"];
  echo "Welcome $username!";
} else {
  echo "Wrong username or password";
}

$con->close();
//injection UNION
// put in $pass=" ' UNION ALL SELECT VERSION(),2,3,4 -- - "
//injection Error Based
//' AND ExtractValue(0, CONCAT( 0x5c, VERSION()) ) -- -