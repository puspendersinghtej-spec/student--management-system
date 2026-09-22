<?php

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(200);
    exit;
}

require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode([
        "success" => false,
        "message" => "Only POST request allowed"
    ]);
    exit;
}

$regno  = trim($_POST["regno"] ?? "");
$name   = trim($_POST["name"] ?? "");
$mobile = trim($_POST["mobile"] ?? "");
$course = trim($_POST["course"] ?? "");

if ($regno === "" || $name === "") {
    echo json_encode([
        "success" => false,
        "message" => "Registration No. and Name are required"
    ]);
    exit;
}

$sql = "INSERT INTO students
        (regno, name, mobile, course)
        VALUES (?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode([
        "success" => false,
        "message" => "SQL Error: " . $conn->error
    ]);
    exit;
}

$stmt->bind_param(
    "ssss",
    $regno,
    $name,
    $mobile,
    $course
);

if ($stmt->execute()) {

    echo json_encode([
        "success" => true,
        "message" => "Student saved successfully",
        "id" => $stmt->insert_id
    ]);

} else {

    echo json_encode([
        "success" => false,
        "message" => "Database Error: " . $stmt->error
    ]);
}

$stmt->close();
$conn->close();

?>