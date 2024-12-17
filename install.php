<?php
// Create Database if not exists
$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

// Create database dbQay
$sql = "CREATE DATABASE IF NOT EXISTS dbQay";
if ($conn->query($sql) === TRUE) {
	echo "Database dbQay created successfully<br>";
} else {
	echo "Error creating database dbQay: " . $conn->error . "<br>";
}

// Create database qaytech
$sql2 = "CREATE DATABASE IF NOT EXISTS qaytech";
if ($conn->query($sql2) === TRUE) {
	echo "Database qaytech created successfully<br>";
} else {
	echo "Error creating database qaytech: " . $conn->error . "<br>";
}

$conn->close();

// Connect to database dbQay and create table tbQay
$conn = new mysqli($servername, $username, $password, 'dbQay');
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

// SQL to create table tbQay
$sql = "CREATE TABLE IF NOT EXISTS tbQay (
    no INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tanggal DATE NULL,
    hari VARCHAR(30),
    waktu TIME NULL, 
    nama VARCHAR(255),
    data VARCHAR(10),
    keterangan VARCHAR(10)
)";

if ($conn->query($sql) === TRUE) {
	echo "Table tbQay created successfully<br>";

	// Use INSERT INTO for inserting data
	$sql_insert_tbQay = "INSERT INTO tbQay (tanggal, hari, waktu, nama, data, keterangan) 
            VALUES ('2024-07-30', 'Rabu', '18:30:00', 'nama', '00.00', 'data')";

	if ($conn->query($sql_insert_tbQay) === TRUE) {
		echo "Data inserted successfully into tbQay<br>";
	} else {
		echo "Error inserting data into tbQay: " . $conn->error . "<br>";
	}
} else {
	echo "Error creating table tbQay: " . $conn->error . "<br>";
}

$conn->close();

// Connect to database qaytech and create table login
$conn = new mysqli($servername, $username, $password, 'qaytech');
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

// SQL to create table login
$sql_create_table = "CREATE TABLE IF NOT EXISTS login (
    email VARCHAR(255) PRIMARY KEY,
    password VARCHAR(255)
)";

if ($conn->query($sql_create_table) === TRUE) {
	echo "Table login created successfully<br>";

	// SQL to insert data
	$sql_insert_data = "INSERT INTO login (email, password) 
                        VALUES ('perkin@gmail.com', '@perkin_indonesia')";

	if ($conn->query($sql_insert_data) === TRUE) {
		echo "Data inserted successfully into login<br>";
	} else {
		echo "Error inserting data into login: " . $conn->error . "<br>";
	}
} else {
	echo "Error creating table login: " . $conn->error . "<br>";
}

$conn->close();
?>