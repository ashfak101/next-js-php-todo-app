<?php
include_once '../classes/Database.php';

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->id)) {
    $db = new Database();
    $conn = $db->getConnection();

    $query = "DELETE FROM todos WHERE id = :id";
    $stmt = $conn->prepare($query);

    $stmt->bindParam(":id", $data->id);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Todo deleted successfully."]);
    } else {
        echo json_encode(["message" => "Unable to delete todo."]);
    }
} else {
    echo json_encode(["message" => "Invalid input."]);
}
?>
