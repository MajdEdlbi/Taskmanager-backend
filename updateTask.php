<?php
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET');
    header('Access-Control-Allow-Headers: Content-Type');

    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['id'])) {
        echo json_encode(["success" => false, "message" => "Task ID is required"]);
        exit;
    }

    $taskId = $data['id'];
    $filePath = "tasks.json";
    $tasks = json_decode(file_get_contents($filePath), true);
    foreach ($tasks as &$task) {
        if ($task['id'] == $taskId) {
            $task['title'] = $data['title'];
            $task['description'] = $data['description'];
            $task['priority'] = $data['priority'];
            break;
        }
    }
    file_put_contents($filePath, json_encode($tasks));
    echo json_encode(["success" => true]);
?>
