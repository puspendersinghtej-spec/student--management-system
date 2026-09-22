<?php

$host = "YOUR_AIVEN_HOST";
$port = 20487;
$user = "avnadmin";
$password = "YOUR_AIVEN_PASSWORD";
$database = "defaultdb";

$conn = mysqli_init();

mysqli_ssl_set(
    $conn,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL
);

if (!mysqli_real_connect(
    $conn,
    $host,
    $user,
    $password,
    $database,
    $port,
    NULL,
    MYSQLI_CLIENT_SSL
)) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

$conn->set_charset("utf8mb4");

?>