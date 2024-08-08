// delete.php
<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if ($username === 'admin') {
        $sql = "DELETE FROM users WHERE id = ?";
    } else {
        $sql = "DELETE FROM users WHERE id = ? AND user_id = ?";
    }

    $stmt = $conn->prepare($sql);

    if ($username === 'admin') {
        $stmt->bind_param("i", $id);
    } else {
        $stmt->bind_param("ii", $id, $user_id);
    }

    if ($stmt->execute()) {
        echo "User deleted successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
    header("Location: index.php");
    exit();
}
?>
