<?php
function getConnection() {
    $host = 'localhost'; // Update if different
    $dbname = 'dbaza8hpuwfswm';
    $username = 'uaozeqcbxyhyg';
    $password = 'f4kld3wzz1v3';

    try {
        $conn = new mysqli($host, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    } catch (Exception $e) {
        die("Connection error: " . $e->getMessage());
    }
}
?>
