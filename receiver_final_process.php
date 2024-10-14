<?php
session_start(); // Start the session

// Database connection details
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

// Output background and styling
echo '<style>
    body {
        background-image: url("bg.jpg");
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        background-repeat: no-repeat;
        height: 100vh;
        margin: 0;
        color: white;
        font-family: Arial, sans-serif;
    }
    h2, p {
        text-align: center;
    }
    button {
        padding: 10px 20px;
        margin: 10px;
        border: none;
        background-color: #007BFF;
        color: white;
        cursor: pointer;
        border-radius: 5px;
        font-size: 16px;
    }
    button:hover {
        background-color: #0056b3;
    }
</style>';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve updated details
    $name = htmlspecialchars($_POST['name']);
    $age = (int)htmlspecialchars($_POST['age']);
    $bloodType = htmlspecialchars($_POST['bloodType']);
    $contact = preg_replace('/\D/', '', $_POST['contact']); // Remove non-digit characters
    $hospitalLocation = htmlspecialchars($_POST['hospitalLocation']);

    // Save updated data to the database
    $sql = "INSERT INTO receiver (name, age, bloodType, contact, hospital_location) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    // Check statement preparation
    if ($stmt === false) {
        die("Failed to prepare the SQL statement: " . $conn->error);
    }

    // Bind parameters and execute
    $stmt->bind_param("sisss", $name, $age, $bloodType, $contact, $hospitalLocation);
    if ($stmt->execute()) {
        echo '<h2>Thank you for updating your details!</h2>';
        echo '<p>Your information has been saved successfully.</p>';
    } else {
        echo '<h2>Update Failed</h2>';
        echo '<p>Error: ' . $stmt->error . '</p>';
    }

    // Close the statement
    $stmt->close();
}

// Close connection
$conn->close();
?>

<!-- Back to Home Button -->
<div style="text-align: center; margin-top: 20px;">
    <a href="home.html"><button type="button">Back to Home</button></a>
</div>