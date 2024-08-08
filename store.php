// store.php
<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $user_id = $_SESSION['user_id']; // Associando ao usuário logado

    $stmt = $conn->prepare("INSERT INTO users (name, email, user_id) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $name, $email, $user_id);

    if ($stmt->execute()) {
        echo "New user created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
    header("Location: index.php");
    exit();
}
?>
