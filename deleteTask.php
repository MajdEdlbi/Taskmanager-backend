<?php
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET');
        header('Access-Control-Allow-Headers: Content-Type');

        $tasksFile = 'tasks.json';
        $data = json_decode(file_get_contents('php://input'), true);

        
        if (isset($data['id'])) {
            $taskId = $data['id'];
            $tasks = json_decode(file_get_contents($tasksFile), true);
            if ($tasks === null) {
                echo json_encode(['success' => false, 'message' => 'Failed to load tasks']);
                exit;
            }
            $tasks = array_filter($tasks, function ($task) use ($taskId) {
                return $task['id'] != $taskId;
            });
            $tasks = array_values($tasks);
            file_put_contents($tasksFile, json_encode($tasks, JSON_PRETTY_PRINT));
            echo json_encode(['success' => true, 'tasks' => $tasks]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Task ID is required']);
        }
?>
