<?php
session_start(); // Start the session at the beginning of the script

require_once 'db_connect.php';

// Fetch attendance data
$sql = "SELECT * FROM attendance";
$stmt = $conn->prepare($sql);
$stmt->execute();
$attendance = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch students data including date of joining
$sql_students = "SELECT id, name, date_of_joining FROM students";
$stmt_students = $conn->prepare($sql_students);
$stmt_students->execute();
$students = $stmt_students->fetchAll(PDO::FETCH_ASSOC);

// Create a lookup array for students
$students_lookup = [];
foreach ($students as $student) {
    $students_lookup[$student['name']] = [
        'date_of_joining' => new DateTime($student['date_of_joining']),
        'attendance_count' => 0,
        'total_sessions' => 0,
        'days_present' => 0,
        'days_total' => 0
    ];
}

// Calculate total sessions and attendance count for each student
foreach ($attendance as $row) {
    $student_name = $row['student_name'];
    $attendance_date = new DateTime($row['date']);
    if (isset($students_lookup[$student_name])) {
        $date_of_joining = $students_lookup[$student_name]['date_of_joining'];
        if ($attendance_date >= $date_of_joining) {
            $students_lookup[$student_name]['total_sessions'] += 1;
            $students_lookup[$student_name]['days_total'] += 1;
            if (strtolower($row['attendance']) == 'present') {
                $students_lookup[$student_name]['attendance_count'] += 1;
                $students_lookup[$student_name]['days_present'] += 1;
            }
        }
    }
}

// Calculate attendance percentage for each student
foreach ($students_lookup as $student_name => $data) {
    if ($data['total_sessions'] > 0) {
        $students_lookup[$student_name]['attendance_percentage'] = 
            ($data['attendance_count'] / $data['total_sessions']) * 100;
    } else {
        $students_lookup[$student_name]['attendance_percentage'] = 0;
    }
}

// Extract unique years, months, days, and sessions
$years = [];
$months = [];
$days = [];
$sessions = [];

foreach ($attendance as $row) {
    $date = new DateTime($row['date']);
    $years[] = $date->format('Y');
    $months[] = $date->format('m');
    $days[] = $date->format('d');
    $sessions[] = $row['session'];
}

$years = array_unique($years);
sort($years);

$months = array_unique($months);
sort($months);

$days = array_unique($days);
sort($days);

$sessions = array_unique($sessions);
sort($sessions);

// Determine the back link based on the user's role
$back_link = "dashboard.html"; // Default to dashboard for admin
if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'staff') {
    $back_link = "staff.php";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Records</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <style>
        body {
            background-image: url('bgimage.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            margin-top: 100px; /* Adjust the margin-top value as needed */
        }
        .container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
        }
        .percentage-box {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 5px;
            color: white;
        }
        .low-percentage {
            background-color: #e74c3c; /* Red */
        }
        .mid-percentage {
            background-color: lightblue;
        }
        .high-percentage {
            background-color: #2ecc71; /* Green */
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="<?php echo $back_link; ?>" class="btn btn-secondary">Back</a>
        <h2 class="mb-4">Attendance Records</h2>
        <div class="filters mb-4">
            <label for="year_filter">Year:</label>
            <select id="year_filter" class="mr-2">
                <option value="">All</option>
                <?php foreach ($years as $year): ?>
                    <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                <?php endforeach; ?>
            </select>
            <label for="month_filter">Month:</label>
            <select id="month_filter" class="mr-2">
                <option value="">All</option>
                <?php foreach ($months as $month): ?>
                    <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                <?php endforeach; ?>
            </select>
            <label for="day_filter">Day:</label>
            <select id="day_filter" class="mr-2">
                <option value="">All</option>
                <?php foreach ($days as $day): ?>
                    <option value="<?php echo $day; ?>"><?php echo $day; ?></option>
                <?php endforeach; ?>
            </select>
            <label for="session_filter">Session:</label>
            <select id="session_filter" class="mr-2">
                <option value="">All</option>
                <?php foreach ($sessions as $session): ?>
                    <option value="<?php echo $session; ?>"><?php echo $session; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <table id="attendanceTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Staff Name</th>
                    <th>Role</th>
                    <th>Student Name</th>
                    <th>Attendance</th>
                    <th>Date</th>
                    <th>Session</th>
                    <th>Days Present</th>
                    <th>Total Days</th>
                    <th>Attendance Percentage</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($attendance as $row): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['staff_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['role']); ?></td>
                    <td><?php echo htmlspecialchars($row['student_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['attendance']); ?></td>
                    <td><?php echo htmlspecialchars($row['date']); ?></td>
                    <td><?php echo htmlspecialchars($row['session']); ?></td>
                    <td><?php echo $students_lookup[$row['student_name']]['days_present']; ?></td>
                    <td><?php echo $students_lookup[$row['student_name']]['days_total']; ?></td>
                    <td>
                        <?php 
                        $student_name = $row['student_name'];
                        $percentage = isset($students_lookup[$student_name]['attendance_percentage']) 
                            ? $students_lookup[$student_name]['attendance_percentage'] 
                            : 0;
                        
                        $class = '';
                        if ($percentage < 70) {
                            $class = 'low-percentage';
                        } elseif ($percentage > 95) {
                            $class = 'high-percentage';
                        } elseif ($percentage < 95) {
                            $class = 'mid-percentage';
                        }
                        ?>
                        <span class="percentage-box <?php echo $class; ?>">
                            <?php echo number_format($percentage, 2) . '%'; ?>
                        </span>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>

    <script>
    $(document).ready(function() {
        // DataTable
        var table = $('#attendanceTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'copy',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'pdf',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'print',
                    exportOptions: {
                        columns: ':visible'
                    },
                    customize: function (win) {
                        $(win.document.body).find('thead').each(function(){
                            var head = $(this);
                            head.find('tr').slice(1).remove(); // Remove all rows except first
                        });
                    }
                }
            ]
        });

        // Filter function
        function filterTable() {
            var year = $('#year_filter').val();
            var month = $('#month_filter').val();
            var day = $('#day_filter').val();
            var session = $('#session_filter').val();
            var search = '';

            if (year) search += year;
            if (month) search += '-' + (month.length < 2 ? '0' + month : month);
            if (day) search += '-' + (day.length < 2 ? '0' + day : day);

            table.column(4).search(search).draw();
            table.column(5).search(session).draw();
        }

        // Event listeners for filters
        $('#year_filter, #month_filter, #day_filter, #session_filter').on('change', filterTable);
    });
    </script>
</body>
</html>
