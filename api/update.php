<?php
include_once '../classes/Database.php';

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->id)) {
    $db = new Database();
    $conn = $db->getConnection();

    $query = "UPDATE todos SET title = :title, status = :status WHERE id = :id";
    $stmt = $conn->prepare($query);

    $stmt->bindParam(":title", $data->title);
    $stmt->bindParam(":status", $data->status);
    $stmt->bindParam(":id", $data->id);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Todo updated successfully."]);
    } else {
        echo json_encode(["message" => "Unable to update todo."]);
    }
} else {
    echo json_encode(["message" => "Invalid input."]);
}
?>
