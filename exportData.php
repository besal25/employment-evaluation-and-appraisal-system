<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Employee Ratings</title>
    <style>
        /* Basic reset for margin and padding */
        body, h1, h2, h3, p, ul, li {
            margin: 0;
            padding: 0;
        }

        /* Style for the table */
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
            border: 1px solid #ccc;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        thead {
            background-color: #f2f2f2;
        }

        th {
            font-weight: bold;
        }

        /* Style for alternating rows */
        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        /* Hover effect for rows */
        tbody tr:hover {
            background-color: #e0e0e0;
        }

        /* Style for the "No data available" message */
        .no-data {
            font-style: italic;
            color: #999;
            text-align: center;
            margin-top: 20px;
        }

        /* Optional: Center the table on the page */
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Optional: Add some overall styling to the page */
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }
    </style>
</head>
<body>
    <?php
    // Assuming you have a database connection established in db_connect.php
    include 'db_connect.php';

    if (isset($_GET['employee_id'])) {
        $employee_id = $_GET['employee_id'];

        // Fetch data from the ratings table and related tables
        $sql = "SELECT r.*, tl.task AS task_name, el.firstname AS evaluator_firstname, el.middlename AS evaluator_middlename, el.lastname AS evaluator_lastname
                FROM ratings r
                JOIN task_list tl ON r.task_id = tl.id
                JOIN evaluator_list el ON r.evaluator_id = el.id
                WHERE r.employee_id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $employee_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<table>
                    <thead>
                        <tr>
                            <th>Task Name</th>
                            <th>Evaluator Name</th>
                            <th>Efficiency</th>
                            <th>Timeliness</th>
                            <th>Quality</th>
                            <th>Accuracy</th>
                            <th>Remarks</th>
                            <th>Date Created</th>
                        </tr>
                    </thead>
                    <tbody>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['task_name']}</td>
                        <td>{$row['evaluator_firstname']} {$row['evaluator_middlename']} {$row['evaluator_lastname']}</td>
                        <td>{$row['efficiency']}</td>
                        <td>{$row['timeliness']}</td>
                        <td>{$row['quality']}</td>
                        <td>{$row['accuracy']}</td>
                        <td>{$row['remarks']}</td>
                        <td>{$row['date_created']}</td>
                    </tr>";
            }

            echo "</tbody></table>";
        } else {
            echo "No data available for this employee.";
        }
    } else {
        echo "Employee ID not provided.";
    }
    echo '<a href="http://localhost/epes/index.php?page=appraisal_list" class="back-button">Back to Appraisal List</a>';
    echo '<span style="margin: 0 10px;">&nbsp;</span>';
    echo '<a href="csv_export.php?employee_id=' . $employee_id . '" class="back-button">Export To CSV</a>';

    
    ?>
</body>
</html>
<style>
    /* Style for the back button */
.back-button {
    display: inline-block;
    padding: 10px 20px;
    background-color: #007bff;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    margin-top: 20px;
    font-weight: bold;
    transition: background-color 0.3s ease;
    box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
    border: none;
    cursor: pointer;
}

.back-button:hover {
    background-color: #0056b3;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
}
</style>