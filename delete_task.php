<?php
include 'db_connect.php'; // Include your database connection file

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Perform the delete operation
    $sql = "DELETE FROM appraisal WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        echo 1; // Success
    } else {
        echo 0; // Error
    }
} else {
    echo 0; // Error
}

$conn->close();
?>
