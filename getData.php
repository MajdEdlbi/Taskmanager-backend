 
<?php
 
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET');
    header('Access-Control-Allow-Headers: Content-Type');

    $tasksFile = 'tasks.json';
    $tasks = json_decode(file_get_contents($tasksFile), true);

    if (isset($_GET['date'])) {
        $selectedDate = $_GET['date'];
        $filteredTasks = array_filter($tasks, function ($task) use ($selectedDate) {
            return isset($task['date']) && $task['date'] === $selectedDate;
        });

        echo json_encode(array_values($filteredTasks));  
    } else {
        echo json_encode($tasks);  
    }
?>
