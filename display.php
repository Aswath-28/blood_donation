<?php
// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blood_donation";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch data
$sql = "SELECT * FROM donor";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Display data in a table
    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Donor Details</title>
        <link rel='stylesheet' href='styles.css'>
        <style>
            table {
                width: 100%;
                border-collapse: collapse;
            }
            table, th, td {
                border: 1px solid black;
            }
            th, td {
                padding: 8px;
                text-align: left;
            }
            th {
                background-color: #f2f2f2;
            }
            .container {
                max-width: 1000px;
                margin: 0 auto;
                padding: 20px;
                text-align: center;
            }
			body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
			background-image: url('blood.jpeg');
			background-size: cover; 
			background-repeat: no-repeat;
			background-attachment: fixed;
            margin: 0;
            padding: 20px;
        }
            .button {
                display: inline-block;
                padding: 10px 20px;
                margin: 10px;
                font-size: 16px;
                color: #fff;
                background-color: #007bff;
                text-decoration: none;
                border-radius: 5px;
                transition: background-color 0.3s;
            }
            .button:hover {
                background-color: #0056b3;
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <h1>Donor Details</h1>";
    
    echo "<table>";
    echo "<tr><th>ID</th><th>Name</th><th>Age</th><th>Blood Group</th><th>Contact Number</th>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["name"] . "</td>";
        echo "<td>" . $row["age"] . "</td>";
        echo "<td>" . $row["bloodType"] . "</td>";
        echo "<td>" . $row["contact"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    echo "<br><a href='home.html' class='button'>Back to Home</a>";
    echo "</div></body></html>";
} else {
    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>No Data Found</title>
        <link rel='stylesheet' href='styles1.css'>
        <style>
            .container {
                max-width: 1000px;
                margin: 0 auto;
                padding: 20px;
                text-align: center;
            }
            .button {
                display: inline-block;
                padding: 10px 20px;
                margin: 10px;
                font-size: 16px;
                color: #fff;
                background-color: #007bff;
                text-decoration: none;
                border-radius: 5px;
                transition: background-color 0.3s;
            }
            .button:hover {
                background-color: #0056b3;
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <h1>No Data Found</h1>
            <p>No donor data is available in the database.</p>
            <br><a href='home.html' class='button'>Back to Home</a>
        </div></body></html>";
}

$conn->close();
?>
