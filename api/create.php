<?php
// Enable CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  http_response_code(200);
  exit;
}
include_once '../classes/Database.php';

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->title)) {
    $db = new Database();
    $conn = $db->getConnection();

    // Create a new table in the database
    $create = "CREATE TABLE IF NOT EXISTS todos (
        id INT AUTO_INCREMENT PRIMARY KEY,        -- Unique ID for each to-do
        title VARCHAR(255) NOT NULL,              -- Title of the to-do item
        status TINYINT(1) DEFAULT 0,              -- 0 = incomplete, 1 = complete
        description TEXT,                         -- Description of the to-do item
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP  -- Creation timestamp
    )";
    try {
      $conn->exec($create);
  } catch (PDOException $e) {
      echo json_encode(["error" => $e->getMessage()]);
  }

    // Insert data into the table
    $query = "INSERT INTO todos (title, status, description) VALUES (:title, :status, :description)";
    $stmt = $conn->prepare($query);

    $stmt->bindParam(":title", $data->title);
    $stmt->bindParam(":status", $data->status);
    $stmt->bindParam(":description", $data->description);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Todo created successfully."]);
    } else {
        echo json_encode(["message" => "Unable to create todo."]);
    }
} else {
    echo json_encode(["message" => "Invalid input."]);
}
?>
