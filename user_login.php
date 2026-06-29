<?php
session_start();
include "db.php";

if(isset($_POST['login']))
{
$email=$_POST['email'];
$password=$_POST['password'];

$res=mysqli_query($conn,"SELECT * FROM users WHERE email='$email' AND password='$password'");

if(mysqli_num_rows($res)>0){
$_SESSION['user']=$email;
header("Location:user_dashboard.php");
}
else{
echo "<script>alert('Invalid Login');</script>";
}
}
?>

<!DOCTYPE html>
<html>
<head>
<title>User Login</title>
<link rel="stylesheet" href="css/bootstrap.css">
</head>

<body style="background: linear-gradient(135deg,#141e30,#243b55);">

<div class="card p-4 shadow-lg" style="max-width:400px;margin:120px auto;background:rgba(255,255,255,0.08);backdrop-filter: blur(10px); color:white; border-radius:15px;">

<h2 class="text-center mb-4">User Login</h2>

<form method="post">

<input class="form-control mb-3" type="email" name="email" placeholder="Email" required>

<input class="form-control mb-3" type="password" name="password" placeholder="Password" required>

<button class="btn btn-primary w-100" name="login">Login</button>

<br><br>

<a href="register.php" style="color:#ddd;">New User? Register</a>

</form>

</div>

</body>
</html>
