<?php
require_once 'db_config.php';

// Get the id from the POST request
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;

// Retrieve the donor details from the database
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM donor WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "No donor found with the given ID.";
    $conn->close();
    exit;
}

$donor = $result->fetch_assoc();
$stmt->close();
?>

<h2>Modify Donor Details</h2>
<form action="update.php" method="post">
    <label for="name">Name:</label>
    <input type="text" name="name" value="<?php echo htmlspecialchars($donor['name']); ?>" required>
    <br>
    <label for="age">Age:</label>
    <input type="number" name="age" value="<?php echo htmlspecialchars($donor['age']); ?>" required>
    <br>
    <label for="bloodType">Blood Group:</label>
    <input type="text" name="bloodType" value="<?php echo htmlspecialchars($donor['bloodType']); ?>" required>
    <br>
    <label for="contact">Contact Number:</label>
    <input type="tel" name="contact" value="<?php echo htmlspecialchars($donor['contact_no']); ?>" required>
    <br>
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
    <button type="submit">Update Details</button>
</form>

<?php
$conn->close();
?>
