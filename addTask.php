<?php
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET');
    header('Access-Control-Allow-Headers: Content-Type');

    $input = json_decode(file_get_contents("php://input"), true);
    if ($input === null) {
        echo json_encode(["status" => "error", "message" => "Invalid JSON"]);
        exit;
    }
    
    $file = 'tasks.json';
    if (file_exists($file)) {
        $data = file_get_contents($file);
        $tasks = json_decode($data, true);

        if (!is_array($tasks)) {
            $tasks = [];  
        }
        $newId = 1; 
        if (!empty($tasks)) {
            $newId = max(array_column($tasks, 'id')) + 1;
        }
        $taskWithId = array_merge($input, ['id' => $newId]);
        $tasks[] = $taskWithId;  

        
        if (file_put_contents($file, json_encode($tasks))) {
            echo json_encode(["status" => "success", "task" => $taskWithId]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to save"]);
        }
    } else {
        
        echo json_encode(["status" => "error", "message" => "Tasks file not found"]);
    }
?>
