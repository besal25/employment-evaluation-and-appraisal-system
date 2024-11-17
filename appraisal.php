<?php include 'db_connect.php' ?>
<?php
ob_start();
$my_class = 'block';
include('decisionTreeMain.php');
$message = "";

// Function to retrieve earliest date_created from ratings
function getEarliestRatingDate($conn) {
    $query = $conn->query("SELECT MIN(date_created) AS earliest_date FROM ratings");
    $row = $query->fetch_assoc();
    return $row['earliest_date'];
}

// Function to retrieve the date of creation for an employee
function getEmployeeCreationDate($conn, $employee_id) {
    $query = $conn->query("SELECT date_created FROM employee_list WHERE id = '$employee_id'");
    $row = $query->fetch_assoc();
    return $row['date_created'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['SubmitButton'])){
        $employee = $_POST['employee'];
        $start_date = getEmployeeCreationDate($conn, $employee); // Get the date of creation for the selected employee
        $date_to = $_POST['endDatePicker'];
        
        $efficiency = 0;
        $quality = 0;
        $timeliness = 0;
        $accuracy = 0;
        
        $query = $conn->query("SELECT * FROM ratings WHERE employee_id = '$employee' AND date_created >= '$start_date' AND date_created <= '$date_to'");
        while ($row = $query->fetch_assoc()) {
            $efficiency += $row['efficiency'];
            $quality += $row['quality'];
            $timeliness += $row['timeliness'];
            $accuracy += $row['accuracy'];
        }
        $total_tasks = $query->num_rows;
        
        if ($total_tasks > 0) {
            $ind_total = 5 * $total_tasks;

            $converted_efficiency = ($efficiency / $ind_total) * 5;
            $converted_quality = ($quality / $ind_total) * 5;
            $converted_timeliness = ($timeliness / $ind_total) * 5;
            $converted_accuracy = ($accuracy / $ind_total) * 5;
            include('decisionTree.php');
            
            echo $prediction;
            
            $my_class = 'none';

            // Check if the entry already exists
            $check_duplicate_query = $conn->query("SELECT * FROM appraisal WHERE employee_id = '$employee' AND date_from = '$start_date' AND date_to = '$date_to'");
            if ($check_duplicate_query->num_rows == 0) {
                date_default_timezone_set("Asia/Kathmandu");

                $current_date = date("Y-m-d H:i:s"); // Get the current date and time
                $sql = "INSERT INTO appraisal (employee_id, date_from, date_to, prediction, appraisal_date) VALUES ('$employee', '$start_date', '$date_to', '$prediction', '$current_date')";
            // if ($check_duplicate_query->num_rows == 0) {
            //     $sql = "INSERT INTO appraisal (employee_id, date_from, date_to, prediction) VALUES ('$employee', '$start_date', '$date_to', '$prediction')";

                try {
                    if ($conn->query($sql) === TRUE) {
                        ob_end_flush(); // Flush any output before redirection
                        echo '<script>window.location.href = "./index.php?page=appraisal_list";</script>';
                        // header("Location: ./index.php?page=appraisal_list");
                        // exit();
                    } else {
                        echo "Error: " . $conn->error;
                    }
                } catch (mysqli_sql_exception $e) {
                    echo "An error occurred: " . $e->getMessage();
                }
            } else {
                echo "Entry already exists.";
            }
        }
    }
}
?>

<div class="col-lg-12">
	<div class="card card-outline card-success" style='display:<?php echo $my_class; ?>'>
		<div class="card-header">
			<?php if($_SESSION['login_type'] == 2): ?>
			<div class="card-tools">
				<button class="btn btn-block btn-sm btn-default btn-flat border-primary" id="new_task"><i class="fa fa-plus"></i> Add New Task</button>
			</div>
			<?php endif; ?>
		</div>
		<div class="card-body">
        <form id="appraisalForm" action="" method="POST">
            
            <div class="row inline col-md-12" style="display:inline-flex;">
                <div class="form-group col-md-5">
                    <select id="employeeDropdown" name="employee"  class="form-control">
                        <option value="">Select Employee</option>
                        <?php
                            $query = $conn->query('SELECT * FROM employee_list');
                            while ($row = $query->fetch_assoc()) {
                                echo '<option value="' . $row['id'] . '">' . $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['lastname'] . '</option>';
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <input type="date" id="startDatePicker" name="startDatePicker" class="form-control" placeholder="Start Date" value="<?php echo $start_date; ?>" readonly>
                </div>
                <div class="form-group col-md-3">
                    <input type="date" id="endDatePicker" name="endDatePicker" class="form-control" placeholder="End Date">
                </div>

                <div class="form-group col-md-12" style="text-align-last:right;">
                    <input type="submit" name="SubmitButton" value="Proceed for Appraisal...">
                </div>
            </div>
            <?php echo $message; ?>
        </form>
	</div>
</div>
<style>
	table p{
		margin: unset !important;
	}
	table td{
		vertical-align: middle !important
	}
</style>
