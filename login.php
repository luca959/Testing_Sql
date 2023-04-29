<?php
// import credentials
include('mysql_credentials.php');
// Open SQL Server connection
$con = new mysqli( $mysql_server, $mysql_user, $mysql_pass, $mysql_db );
// Check for SQL error
if ($con->connect_error) die ("Connection failed: " .$con->connect_error);
// --------

$user = $_POST['user'];
$pass = $_POST['pass'];
#$pass="' UNION ALL SELECT VERSION(),2,3,4 -- -";
#$pass="' AND ExtractValue(0, CONCAT( 0x5c, VERSION() ) ) -- -";
// $query = "SELECT * FROM users WHERE username='$user' AND password='$pass'";
// FIXED - no more attacks on $user
$query = "SELECT * FROM users WHERE username='admin' AND password='$pass'";
// NOPE - $pass -> any' OR 'a'='a
// SELECT * FROM users WHERE username='admin' AND password='any' OR 'a'='a'
$result = $con->query($query);

if($result->num_rows == 1) {
// Not specific
// if($result->num_rows == 1) {
//  [spoilers] This is still bypassable
  $row = $result->fetch_assoc();
  $username = $row["username"];
  echo "Welcome $username!";
} else {
  echo "Wrong username or password";
  // can't we just say if the username or the password were wrong?
  // Generic errors >>>>> Specific errors
}

$con->close();

//injection UNION
// put in $pass=" ' UNION ALL SELECT VERSION(),2,3,4 -- - "
//injection Error Based
//' AND ExtractValue(0, CONCAT( 0x5c, VERSION() ) ) -- -