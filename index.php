<?php
session_start(); // Start the session

// Database connection details
$servername = "localhost"; // or your database server
$username = "root"; // your MySQL username
$password = ""; // your MySQL password (empty for XAMPP default)
$dbname = "blood_donation"; // replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Output the background styling at the top of the file
echo '<style>
        body {
            background-image: url("bg.jpg"); /* Update the path to your image */
            background-size: cover; /* Scale the image to cover the entire screen */
            background-position: center; /* Center the image */
            background-attachment: fixed; /* Keep the background fixed on scroll */
            background-repeat: no-repeat; /* Prevent the background from repeating */
            height: 100vh; /* Ensure body covers the full viewport height */
            margin: 0; /* Remove body margin */
            color: white; /* Text color for visibility */
            font-family: Arial, sans-serif; /* Font for better readability */
        }

        h2, p {
            text-align: center; /* Center align text */
        }

        form {
            text-align: center; /* Center the form */
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
            background-color: #0056b3; /* Darker shade on hover */
        }
      </style>';

// Proceed with form submission logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $name = htmlspecialchars(trim($_POST['name']));
    $age = (int)htmlspecialchars(trim($_POST['age']));
    $bloodType = htmlspecialchars(trim($_POST['bloodType']));
    $contact = preg_replace('/\D/', '', trim($_POST['contact'])); // Remove non-digit characters

    $errors = []; // Initialize an array to hold error messages

    // Validate fields
    if (empty($name) || empty($bloodType)) {
        $errors[] = "Name and Blood Type are required.";
    }
    if (strlen($contact) != 10) {
        $errors[] = "Contact number must be exactly 10 digits.";
    }
    if ($age < 18 || $age > 67) {
        $errors[] = "Age must be between 18 and 67.";
    }

    // If there are errors, display them
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p style='color:red;'>$error</p>";
        }
        exit; // Stop further processing
    }

    // Show registration summary and ask if they want to update
    echo "<h2>Registration Successful!</h2>";
    echo "<p>Thank you, $name, for registering to donate blood.</p>";
    echo "<p>Age: $age</p>";
    echo "<p>Blood Type: $bloodType</p>";
    echo "<p>Contact Number: $contact</p>";

    // Store the information temporarily in the session
    $_SESSION['temp_data'] = [
        'name' => $name,
        'age' => $age,
        'bloodType' => $bloodType,
        'contact' => $contact,
    ];

    // Ask if the user wants to change their details
    echo '<form method="post" action="update.php">'; // Link to update.php
    echo '<p>Do you need to change your details?</p>';
    echo '<button type="submit" name="update" value="yes">Yes, I want to update</button>';
    echo '<button type="submit" name="update" value="no">No, I don\'t want to update</button>';
    echo '</form>';
}

// Close the connection
$conn->close();
?>
