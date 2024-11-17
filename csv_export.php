<?php
// Start the output buffer.
ob_start();
// Set PHP headers for CSV output.
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=csv_export.csv');

// Create the headers.
$header_args = array(
    'Task Name',
    'Evaluator Name',
    'Efficiency',
    'Timeliness',
    'Quality',
    'Accuracy',
    'Remarks',
    'Date Created'
);

// Fetch data from the database and prepare the content.
// Assuming you have a database connection established in db_connect.php
include 'db_connect.php';

if (isset($_GET['employee_id'])) {
    $employee_id = $_GET['employee_id'];

    $sql = "SELECT r.*, tl.task AS task_name, el.firstname AS evaluator_firstname, el.middlename AS evaluator_middlename, el.lastname AS evaluator_lastname
            FROM ratings r
            JOIN task_list tl ON r.task_id = tl.id
            JOIN evaluator_list el ON r.evaluator_id = el.id
            WHERE r.employee_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Prepare the content to write to the CSV file.
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data_item = array(
            $row['task_name'],
            "{$row['evaluator_firstname']} {$row['evaluator_middlename']} {$row['evaluator_lastname']}",
            $row['efficiency'],
            $row['timeliness'],
            $row['quality'],
            $row['accuracy'],
            $row['remarks'],
            $row['date_created']
        );
        $data[] = $data_item;
    }

    // Clean up output buffer before writing anything to CSV file.
    ob_end_clean();

    // Create a file pointer with PHP.
    $output = fopen('php://output', 'w');

    // Write headers to CSV file.
    fputcsv($output, $header_args);

    // Loop through the prepared data to output it to CSV file.
    foreach ($data as $data_item) {
        fputcsv($output, $data_item);
    }

    // Close the file pointer with PHP.
    fclose($output);
    exit;
} else {
    echo "Employee ID not provided.";
}
?>
