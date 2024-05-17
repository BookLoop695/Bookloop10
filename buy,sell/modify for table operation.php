<?php
$host = 'localhost:3306';  
$user = 'root';  
$pass = '';  
$db_name = 'buy_sell'; 

// Establish connection
$conn = mysqli_connect($host, $user, $pass, $db_name);  

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// SQL to alter table and change datatype
$sql = "ALTER TABLE selling ADD method varchar(45)";
if (mysqli_query($conn, $sql)) {
    echo "Column datatype changed successfully";
} else {
    echo "Error changing column datatype: " . mysqli_error($conn);
}

// Close connection
mysqli_close($conn);
?>
