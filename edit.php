// edit.php
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
        $sql = "SELECT * FROM users WHERE id = ?";
    } else {
        $sql = "SELECT * FROM users WHERE id = ? AND user_id = ?";
    }

    $stmt = $conn->prepare($sql);

    if ($username === 'admin') {
        $stmt->bind_param("i", $id);
    } else {
        $stmt->bind_param("ii", $id, $user_id);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Unauthorized or record not found";
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
</head>
<body>
    <h2>Edit User</h2>
    <form method="POST" action="update.php">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <label>Name:</label>
        <input type="text" name="name" value="<?php echo $row['name']; ?>" required>
        <label>Email:</label>
        <input type="email" name="email" value="<?php echo $row['email']; ?>" required>
        <button type="submit">Update</button>
    </form>
</body>
</html>
