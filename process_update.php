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
    .button-container {
        text-align: center;
        margin-top: 20px;
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
    // Retrieve session data
    $name = htmlspecialchars($_POST['name']);
    $age = (int)htmlspecialchars($_POST['age']);
    $bloodType = htmlspecialchars($_POST['bloodType']);
    $contact = preg_replace('/\D/', '', $_POST['contact']); // Remove non-digit characters

    // Check if the user chose to update
    if ($_POST['update'] === 'yes') {
        // Allow updates to age and contact
        echo '<h2>Update Your Details</h2>';
        echo '<form method="post" action="final_process.php">';
        echo 'New Age: <input type="number" name="age" value="' . $age . '" min="18" max="69" required>';
        echo 'New Contact: <input type="tel" name="contact" value="' . $contact . '" pattern="\d{10}" title="Contact number must be exactly 10 digits." required>';
        echo '<input type="hidden" name="name" value="' . htmlspecialchars($name) . '">';
        echo '<input type="hidden" name="bloodType" value="' . htmlspecialchars($bloodType) . '">';
        echo '<button type="submit">Update</button>';
        echo '</form>';
    } else {
        // Directly save data to the database
        $sql = "INSERT INTO donor (name, age, bloodType, contact) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        
        // Check statement preparation
        if ($stmt === false) {
            die("Failed to prepare the SQL statement: " . $conn->error);
        }

        // Bind parameters and execute
        $stmt->bind_param("siss", $name, $age, $bloodType, $contact);
        if ($stmt->execute()) {
            echo '<h2>Thank you for registering!</h2>';
            echo '<p>Your details have been saved successfully.</p>';
        } else {
            echo '<h2>Registration Failed</h2>';
            echo '<p>Error: ' . $stmt->error . '</p>';
        }

        // Close the statement
        $stmt->close();
    }
}

// Close connection
$conn->close();
?>
