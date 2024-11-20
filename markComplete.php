<?php
    
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET');
    header('Access-Control-Allow-Headers: Content-Type');
    $input = json_decode(file_get_contents('php://input'), true);

    if (!isset($input['id'])) {
        echo json_encode(["error" => "Task ID is required"]);
        exit;
    }

    $taskId = $input['id'];
    $tasksFile = 'tasks.json';


    if (file_exists($tasksFile)) {
        $tasks = json_decode(file_get_contents($tasksFile), true);
        foreach ($tasks as &$task) {
            if ($task['id'] === $taskId) {
                $task['isCompleted'] = !$task['isCompleted'];
                break;
            }
        }
        file_put_contents($tasksFile, json_encode($tasks, JSON_PRETTY_PRINT));
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["error" => "Tasks file not found"]);
    }
?>
