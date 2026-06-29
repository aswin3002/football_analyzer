<?php
session_start();
include "../db.php";

if(isset($_POST['login']))
{
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Example static admin (if you are not using admin table)
    if($username == "admin" && $password == "admin123"){
        $_SESSION['admin'] = $username;
        header("Location: dashboard.php");
        exit();
    }
    else{
        echo "<script>alert('Invalid Login');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background: linear-gradient(135deg,#141e30,#243b55);">

<div class="card p-4 shadow-lg" style="max-width:400px;margin:120px auto;background:rgba(255,255,255,0.08);backdrop-filter: blur(10px); color:white; border-radius:15px;">

<h2 class="text-center mb-4">Admin Login</h2>

<form method="post">

<input class="form-control mb-3" type="text" name="username" placeholder="Username" required>

<input class="form-control mb-3" type="password" name="password" placeholder="Password" required>

<button class="btn btn-primary w-100" name="login">Login</button>

</form>

</div>

</body>
</html>