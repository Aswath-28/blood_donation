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

// SQL query to fetch matching data
$sql = "
    SELECT d.bloodType AS blood_type, 
           d.id AS donor_id, d.name AS donor_name, d.age AS donor_age, d.contact AS donor_contact,
           r.id AS receiver_id, r.name AS receiver_name, r.age AS receiver_age, r.contact AS receiver_contact, r.updateDate
    FROM donor d
    INNER JOIN receiver r ON d.bloodType = r.bloodType
    ORDER BY d.bloodType
";

$result = $conn->query($sql);

$grouped_data = [];
if ($result->num_rows > 0) {
    // Group data by blood type
    while ($row = $result->fetch_assoc()) {
        $blood_type = $row["blood_type"];
        if (!isset($grouped_data[$blood_type])) {
            $grouped_data[$blood_type] = [];
        }
        $grouped_data[$blood_type][] = $row;
    }
    
    // Display data in a table
    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Matching Donors and Receivers</title>
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
                padding: 10px;
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
            .donor-cell, .receiver-cell {
                padding: 10px;
                vertical-align: top;
            }
            .donor-cell {
                border-right: 2px solid #e0e0e0; /* Adds a vertical line between donor and receiver sections */
            }
            .blood-type-section {
                margin-bottom: 30px;
            }
            .blood-type-title {
                font-size: 1.5em;
                margin-bottom: 10px;
                border-bottom: 2px solid #007bff;
                padding-bottom: 5px;
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <h1>Matching Donors and Receivers</h1>";

    foreach ($grouped_data as $blood_type => $records) {
        echo "<div class='blood-type-section'>";
        echo "<div class='blood-type-title'>Blood Type: " . htmlspecialchars($blood_type) . "</div>";
        echo "<table>";
        echo "<tr>
                <th colspan='5'>Donor Information</th>
                <th colspan='6'>Receiver Information</th>
              </tr>";
        echo "<tr>
                <th>Donor ID</th><th>Name</th><th>Age</th><th>Blood Type</th><th>Contact</th>
                <th>Receiver ID</th><th>Name</th><th>Age</th><th>Blood Type</th><th>Contact</th><th>Update Date</th>
              </tr>";

        foreach ($records as $row) {
            echo "<tr>";
            echo "<td class='donor-cell'>" . htmlspecialchars($row["donor_id"]) . "</td>";
            echo "<td class='donor-cell'>" . htmlspecialchars($row["donor_name"]) . "</td>";
            echo "<td class='donor-cell'>" . htmlspecialchars($row["donor_age"]) . "</td>";
            echo "<td class='donor-cell'>" . htmlspecialchars($row["blood_type"]) . "</td>";
            echo "<td class='donor-cell'>" . htmlspecialchars($row["donor_contact"]) . "</td>";
            echo "<td class='receiver-cell'>" . htmlspecialchars($row["receiver_id"]) . "</td>";
            echo "<td class='receiver-cell'>" . htmlspecialchars($row["receiver_name"]) . "</td>";
            echo "<td class='receiver-cell'>" . htmlspecialchars($row["receiver_age"]) . "</td>";
            echo "<td class='receiver-cell'>" . htmlspecialchars($row["blood_type"]) . "</td>";
            echo "<td class='receiver-cell'>" . htmlspecialchars($row["receiver_contact"]) . "</td>";
            echo "<td class='receiver-cell'>" . htmlspecialchars($row["updateDate"]) . "</td>";
            echo "</tr>";
        }

        echo "</table></div>";
    }
    
    echo "<br><a href='home.html' class='button'>Back to Home</a>";
    echo "</div></body></html>";
} else {
    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>No Matches Found</title>
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
            <h1>No Matches Found</h1>
            <p>No matching donor and receiver records found in the database.</p>
            <br><a href='home.html' class='button'>Back to Home</a>
        </div></body></html>";
}

$conn->close();
?>
