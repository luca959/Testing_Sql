<?php
// import credentials
include('mysql_credentials.php');

// Open SQL Server connection
$con = new mysqli( $mysql_server, $mysql_user, $mysql_pass, $mysql_db );

// Check for SQL error
if ($con->connect_error) die ("Connection failed: " .$con->connect_error);

$max = $_GET['max'];

$query = "SELECT * FROM items WHERE price <= $max";
$result = $con->query($query);
echo $con->error;

while( $row = $result->fetch_assoc() ) {
  $name = $row["name"];
  $price = $row["price"];
  echo " - $name   $price.00 € <br/>";
}

$con->close();

//Injection UNION
// put in $max=" 1 OR 1=1 UNION ALL SELECT VERSION(),2 -- -"
//Injection Error Based
// 1 AND ExtractValue(0, CONCAT( 0x5c, VERSION() ) ) -- -