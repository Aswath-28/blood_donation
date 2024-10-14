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
        font-family: Arial, sans-serif;
        color: white;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    .container {
        background-color: rgba(0, 0, 0, 0.7);
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        max-width: 500px;
        width: 100%;
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
    // Retrieve and sanitize form data
    $name = htmlspecialchars($_POST['name']);
    $age = (int)htmlspecialchars($_POST['age']);
    $bloodType = htmlspecialchars($_POST['bloodType']);
    $hospitalLocation = htmlspecialchars($_POST['hospitalLocation']);
    
    // Sanitize and validate contact number
    $contact = preg_replace('/\D/', '', $_POST['contact']); // Remove non-digit characters
    if (strlen($contact) != 10) {
        die("Invalid contact number. It must be exactly 10 digits.");
    }
    
    // Check age eligibility (you may want to adjust this for receivers)
    if ($age < 0 || $age > 120) {
        die("Invalid age. Please enter a valid age.");
    }

    // Store data temporarily in session
    $_SESSION['receiver_data'] = compact('name', 'age', 'bloodType', 'contact', 'hospitalLocation');

    // Display confirmation form
    echo '<div class="container">';
    echo '<h2>Confirm Your Details</h2>';
    echo "<p>Name: $name</p>";
    echo "<p>Age: $age</p>";
    echo "<p>Blood Type: $bloodType</p>";
    echo "<p>Contact Number: $contact</p>";
    echo "<p>Hospital Location: $hospitalLocation</p>";
    
    echo '<form method="post" action="receiver_update.php">';
    echo '<input type="hidden" name="name" value="' . htmlspecialchars($name) . '">';
    echo '<input type="hidden" name="age" value="' . htmlspecialchars($age) . '">';
    echo '<input type="hidden" name="bloodType" value="' . htmlspecialchars($bloodType) . '">';
    echo '<input type="hidden" name="contact" value="' . htmlspecialchars($contact) . '">';
    echo '<input type="hidden" name="hospitalLocation" value="' . htmlspecialchars($hospitalLocation) . '">';
    echo '<p>Do you want to update your details?</p>';
    echo '<button type="submit" name="update" value="yes">Yes, I want to update</button>';
    echo '<button type="submit" name="update" value="no">No, I\'m satisfied with my details</button>';
    echo '</form>';
    echo '</div>';
}

// Close connection
$conn->close();
?>