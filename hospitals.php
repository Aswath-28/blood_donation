<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Blood Type Table</title>
    <link rel="stylesheet" href="styles.css"> <!-- Include your stylesheet -->
    <style>
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

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        button {
            display: block;
            margin: 20px auto;
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Hospital Blood Type Details</h1>
        <table>
            <thead>
                <tr>
                    <th>Hospital Name</th>
                    <th>Blood Type</th>
                    <th>Blood Quantity</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Database connection settings
                $servername = "localhost"; // Change if necessary
                $username = "root"; // Replace with your database username
                $password = ""; // Replace with your database password
                $dbname = "blood_donation"; // Replace with your database name

                // Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // SQL query to fetch hospital name, blood type, and calculate blood quantity based on donors
                $sql = "SELECT r.hospital_location AS hospital_name, r.bloodType, 
                               COUNT(d.bloodType) AS quantity 
                        FROM receiver r 
                        LEFT JOIN donor d ON r.bloodType = d.bloodType
                        GROUP BY r.hospital_location, r.bloodType";

                // Execute the query
                $result = $conn->query($sql);

                // Check if the query was successful
                if ($result === false) {
                    echo "Error: " . $conn->error; // Print the error
                } else {
                    // Check if there are results
                    if ($result->num_rows > 0) {
                        // Fetch and display each row
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['hospital_name']) . "</td>"; // Hospital Name
                            echo "<td>" . htmlspecialchars($row['bloodType']) . "</td>"; // Blood Type
                            echo "<td>" . htmlspecialchars($row['quantity']) . "</td>"; // Blood Quantity
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No records found.</td></tr>";
                    }
                }

                // Close connection
                $conn->close();
                ?>
            </tbody>
        </table>
        <!-- Button placed below the table -->
        <div style="text-align: center;">
            <button onclick="window.location.href='matches.php'">View All Details</button>
			<br>
				<a href="home.html"><button>Back to Home</button></a>
        </div>
    </div>
</body>
</html>