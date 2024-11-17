<!DOCTYPE html>
<html lang="en">
<?php 
session_start();
include('./db_connect.php');
ob_start();

$systemResult = $conn->query("SELECT * FROM system_settings");
$system = $systemResult->fetch_assoc(); // Fetch as an associative array

if ($system) {
    $_SESSION['system'] = $system;
}
ob_end_flush();
?>
<?php 
if(isset($_SESSION['login_id']))
  header("location:index.php?page=home");
?>
<?php include 'header.php' ?>
<head>
<style>
  /* Custom CSS for the login page */
  body {
    background: url('NSS1.jpg') no-repeat center center fixed;
    background-size: cover;
  }
  .login-box {
    margin-top: 8%;
    max-width: 360px;
    margin-left: auto;
    margin-right: auto;
  }
  .login-logo a {
    font-weight: bold;
    font-size: 24px;
    text-transform: uppercase;
    text-decoration: none;
    color: #4CAF50; /* Your desired text color */
    display: inline-block;
    padding: 10px;
    background: linear-gradient(135deg, #00FF99, #4CAF50); /* Gradient background */
    border-radius: 8px;
    transform: translateX(-10px); /* Apply 3D floating effect */
    box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.2); /* Add a subtle shadow */
    transition: transform 0.3s ease-in-out; /* Apply smooth transition */
  }
  .login-logo a:hover {
    transform: translateX(0); /* Reverse the 3D floating effect on hover */
  }
  .login-card-body {
    background-color: rgba(255, 255, 255, 0.2); /* Transparent white background */
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
  }
  .form-control {
    background-color: rgba(255, 255, 255, 0.8); /* Reduced transparency for background */
    border-color: rgba(210, 214, 222, 0.8); /* Reduced transparency for border color */
    border-radius: 5px;
    padding: 12px;
  }
  .btn-primary {
    background-color: #007bff;
    border-color: #007bff;
    padding: 12px;
    border-radius: 5px;
  }
  .btn-primary:hover {
    background-color: #0056b3;
    border-color: #0056b3;
  }
  .icheck-primary input:checked + label:before {
    border-color: #007bff;
    background-color: #007bff;
  }
</style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#" class="text-white">Employee Evaluation And Appraisal System</a>
  </div>
  <div class="card">
    <div class="card-body login-card-body">
      <form action="" id="login-form">
        <div class="input-group mb-3">
          <input type="email" class="form-control" name="email" required placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" id="password" required placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-eye" id="togglePassword"></span>
            </div>
          </div>
        </div>
        <div class="form-group mb-3">
          <label for="">Login As</label>
          <select name="login" id="" class="custom-select custom-select-sm">
            <option value="0">Employee</option>
            <option value="1">Evaluator</option>
            <option value="2">Admin</option>
          </select>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#togglePassword').click(function() {
            const passwordField = $('#password');
            const passwordFieldType = passwordField.attr('type');
            if (passwordFieldType === 'password') {
                passwordField.attr('type', 'text');
                $(this).removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                passwordField.attr('type', 'password');
                $(this).removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });

        $('#login-form').submit(function(e){
          e.preventDefault()
          start_load()
          if($(this).find('.alert-danger').length > 0 )
            $(this).find('.alert-danger').remove();
          $.ajax({
            url:'ajax.php?action=login',
            method:'POST',
            data:$(this).serialize(),
            error:err=>{
              console.log(err)
              end_load();
            },
            success:function(resp){
              if(resp == 1){
                location.href ='index.php?page=home';
              }else{
                $('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>')
                end_load();
              }
            }
          })
        })
    });
</script>
<?php include 'footer.php' ?>
</body>
</html>
