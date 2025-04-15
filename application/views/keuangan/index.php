<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>To Do List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .task-overdue {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">To Do List</h1>

    <form method="post" action="<?php echo site_url('todo/add'); ?>">
        <div class="mb-3">
            <input type="text" name="task" required class="form-control" placeholder="Enter your task...">
        </div>
        <div id="subtasks">
            <div class="mb-3">
                <input type="text" name="subtasks[]" class="form-control" placeholder="Enter a subtask...">
            </div>
        </div>
        <div class="mb-3">
            <input type="date" name="deadline" class="form-control" required>
        </div>
        <div class="d-flex justify-content-between">
            <button type="button" class="btn btn-outline-primary" onclick="addSubtask()">+ Add Subtask</button>
            <button type="submit" class="btn btn-success">Add Task</button>
        </div>
    </form>

    <hr class="my-4">

    <ul class="list-group">
        <?php if (!empty($tasks)): ?>
            <?php foreach ($tasks as $task): ?>
                <li class="list-group-item">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="<?php echo (strtotime($task->deadline) < time()) ? 'task-overdue' : ''; ?>">
                                <?php echo htmlspecialchars($task->task); ?>
                            </span><br>
                            <small class="text-muted">
                                Deadline: <?php echo date('d M Y', strtotime($task->deadline)); ?>
                            </small>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="<?php echo site_url('todo/edit/' . $task->id); ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="<?php echo site_url('todo/delete/' . $task->id); ?>" class="btn btn-danger btn-sm">Delete</a>
                        </div>
                    </div>

                    <?php if (!empty($task->subtasks)): ?>
                        <ul class="mt-2">
                            <?php foreach ($task->subtasks as $subtask): ?>
                                <li>- <?php echo htmlspecialchars($subtask->subtask); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li class="list-group-item text-center">No tasks found!</li>
        <?php endif; ?>
    </ul>
</div>

<script>
function addSubtask() {
    var div = document.createElement('div');
    div.className = 'mb-3';
    div.innerHTML = '<input type="text" name="subtasks[]" class="form-control" placeholder="Enter a subtask...">';
    document.getElementById('subtasks').appendChild(div);
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
