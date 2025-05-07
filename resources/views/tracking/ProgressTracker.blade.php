<!-- resources/views/progress-tracker.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progress Tracker</title>
    <link rel="stylesheet" href="{{ asset('styles.css') }}">
</head>
<body>
    <div class="container">
        <h1>Progress Tracker</h1>

        <div class="task-section">
            <div class="task not-started">
                <h2>Not Yet Started</h2>
                <p>Deadline: 2 September 2025</p>
                <button class="check-btn">Cek Pekerjaan!</button>
            </div>

            <div class="task on-progress">
                <h2>On Progress</h2>
                <p>Deadline: 22 Agustus 2025</p>
                <p>Task: Design</p>
                <p>Due Time: 23:59 PM</p>
                <button class="check-list-btn">Check List</button>
            </div>

            <div class="task finished">
                <h2>Finished!</h2>
                <p>Deadline: 2 Agustus 2025</p>
            </div>
        </div>
    </div>
    <script src="{{ asset('script.js') }}"></script>
</body>
</html>