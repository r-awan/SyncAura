<?php
// Database connection details
$dsn = "mysql:host=localhost;dbname=users"; // Change to your database name
$user = "root"; // Default user for XAMPP
$password = ""; // Default password for XAMPP (empty string)

// Create a new PDO instance for database connection
try {
    $db = new PDO($dsn, $user, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Function to check if the user exists and verify password
function authenticateUser($username, $password_input) {
    global $db;  // Use the global database connection
    // Prepare SQL query to select user data including profile picture
    $stmt = $db->prepare("SELECT id, username, password, status, profile_picture FROM client WHERE username = :username");
    $stmt->bindParam(":username", $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // If the user exists, verify the password
        if (password_verify($password_input, $user["password"])) {
            // If the password is correct, return user details including profile picture
            return $user;
        }
    }

    return false; // Return false if user not found or password incorrect
}
   function getUserByFaceId($faceId) {
    global $db;  // Use the global database connection

    $sql = "SELECT * FROM client WHERE faceId = :face_id";
    try {
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':face_id', $faceId, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error in getUserByFaceId: " . $e->getMessage());
        return null;
    }
}
?>
