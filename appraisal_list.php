<?php include 'db_connect.php'; ?>

<div class="col-lg-12">
    <div class="card card-outline card-success">
        <div class="card-header">
            <?php if ($_SESSION['login_type'] == 2): ?>
                <div class="card-tools">
                    <button class="btn btn-block btn-sm btn-default btn-flat border-primary" id="new_task"><i class="fa fa-plus"></i> <a href="./index.php?page=appraisal">Add Appraisal</a></button>
                </div>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <table class="table table-hover table-condensed" id="list">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th width="30%">Employee</th>
                        <th>Date From/To</th>
                        <th>Status</th>
                        <th>Remarks</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $data = []; // An associative array to hold organized data

                    $sql = "SELECT *
                            FROM appraisal a
                            JOIN employee_list e ON a.employee_id = e.id";

                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $employeeFullName = $row["firstname"] . " " . $row['middlename'] . " " . $row['lastname'];
                            $dateFrom = $row["date_from"];
                            $dateTo = $row["date_to"];
                            $prediction = $row["prediction"];
                            $increment = '';

                            if ($prediction == 'Excellent') {
                                $increment = 'Increment by 10%';
                            } elseif ($prediction == 'Good') {
                                $increment = 'Increment by 5%';
                            } else {
                                $increment = 'No change';
                            }
                            $email = $row['email']; // Assuming you have fetched the email from somewhere
                            $sqlEmail = "SELECT id
                                         FROM employee_list
                                         WHERE email = '$email'";
                            $resultEmail = $conn->query($sqlEmail);

                            if ($resultEmail->num_rows > 0) {
                                while ($rowsEmail = $resultEmail->fetch_assoc()) {
                                    $employee_id = $rowsEmail['id'];
                                }
                            }

                            // Organize the data by employee and date
                            $dataKey = $employeeFullName . '|' . $dateFrom;
                            if (!isset($data[$dataKey])) {
                                $data[$dataKey] = [
                                    'date_to' => $dateTo,
                                    'prediction' => $prediction,
                                    'increment' => $increment,
                                    'employee_id' => $employee_id // Store the employee_id for the view button
                                ];
                            } else {
                                // Replace data with the latest end date and prediction
                                $data[$dataKey]['date_to'] = $dateTo;
                                $data[$dataKey]['prediction'] = $prediction;
                                $data[$dataKey]['increment'] = $increment;
                            }
                        }
                        
                        foreach ($data as $key => $row) {
                            list($employeeName, $dateFrom) = explode('|', $key);
                            echo "<tr>";
                            echo "<td>" . $i . "</td>";
                            echo "<td>" . $employeeName . "</td>";
                            echo "<td>" . $dateFrom . " / " . $row['date_to'] . "</td>";
                            echo "<td>" . $row['prediction'] . "</td>";
                            echo "<td>" . $row['increment'] . "</td>";
                            echo "<td><a class='view-button' href='#' data-employee-id='" . $row['employee_id'] . "' data-toggle='ratings-toggle'>View</a></td>";
                            // echo "<td><a class='view-button' href='#' data-employee-id='" . $row['employee_id'] . "' data-toggle='ratings-toggle'>Appraisal Date</a></td>";
                            echo "</tr>";
                            echo "<tr class='ratings-row' data-employee-id='" . $row['employee_id'] . "' style='display: none;'><td colspan='6'></td><td colspan='7'><div class='ratings-data'></div></td></tr>";
                            $i++;
                        }
                    } else {
                        echo "<tr><td colspan='5'>No data available</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<style>
    table p {
        margin: unset !important;
    }

    table td {
        vertical-align: middle !important
    }

    .view-button {
        display: inline-block;
        padding: 5px 10px;
        background-color: #3498db;
        color: white;
        border-radius: 5px;
        text-decoration: none;
    }

    .view-button:hover {
        background-color: #2980b9;
    }
</style>
<script>
    // Add event listener for the "View" buttons
    const viewButtons = document.querySelectorAll('.view-button[data-toggle="ratings-toggle"]');
    viewButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();

            const employeeId = this.getAttribute('data-employee-id');
            openRatingsPage(employeeId);
        });
    });

    function openRatingsPage(employeeId) {
        // Open a new window or tab with the ratings page
        const ratingsUrl = `exportData.php?employee_id=${employeeId}`;
        window.open(ratingsUrl, '_blank');
    }
</script>
