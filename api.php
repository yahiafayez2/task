<?php
include 'db.php';

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

$id = isset($_GET['id']) ? $_GET['id'] : null;

switch ($method) {
    case 'GET':
        if ($id) {
            $sql = "SELECT * FROM the_table WHERE id = $id";
        } else {
            $sql = "SELECT * FROM the_table";
        }

        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            echo json_encode($data);
        } else {
            echo json_encode(["message" => "No records found"]);
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true); 

        $title = $data['title'] ?? '';
        $content = $data['content'] ?? '';

        if ($title && $content) {
            $sql = "INSERT INTO the_table (title, content) VALUES ('$title', '$content')";
            if ($conn->query($sql) === TRUE) {
                echo json_encode(["message" => "Record created successfully"]);
            } else {
                echo json_encode(["message" => "Error: " . $conn->error]);
            }
        } else {
            echo json_encode(["message" => "Missing data"]);
        }
        break;

    case 'PUT':
        if ($id) {
            $data = json_decode(file_get_contents("php://input"), true);
            $title = $data['title'] ?? '';
            $content = $data['content'] ?? '';

            if ($title && $content) {
                $sql = "UPDATE the_table SET title='$title', content='$content' WHERE id=$id";
                if ($conn->query($sql) === TRUE) {
                    echo json_encode(["message" => "Record updated successfully"]);
                } else {
                    echo json_encode(["message" => "Error: " . $conn->error]);
                }
            } else {
                echo json_encode(["message" => "Missing data"]);
            }
        } else {
            echo json_encode(["message" => "ID is required"]);
        }
        break;

    case 'DELETE':
        if ($id) {
            $sql = "DELETE FROM the_table WHERE id = $id";
            if ($conn->query($sql) === TRUE) {
                echo json_encode(["message" => "Record deleted successfully"]);
            } else {
                echo json_encode(["message" => "Error: " . $conn->error]);
            }
        } else {
            echo json_encode(["message" => "ID is required"]);
        }
        break;

    default:
        echo json_encode(["message" => "Method not allowed"]);
        break;
}

$conn->close();
?>