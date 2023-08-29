<?php
define('HOSTNAME', "localhost");
define('USERNAME', "root");
define('PASSWORD', "");
define('DATABASE', "crud_expense_tracker");

//connect to the database
$connection = mysqli_connect(HOSTNAME, USERNAME, PASSWORD, DATABASE);

if (mysqli_connect_errno()) {
    die("Connection failed: " . mysqli_connect_error($connection));
} 
// else {
//     echo "Connected successfully";
// }
