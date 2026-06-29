<?php include "db.php"; ?>

<?php
if(isset($_POST['register']))
{
$name=$_POST['name'];
$email=$_POST['email'];
$password=$_POST['password'];

mysqli_query($conn,"INSERT INTO users(name,email,password)
VALUES('$name','$email','$password')");

echo "<script>alert('Registered Successfully');</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>User Register</title>
<link rel="stylesheet" href="css/bootstrap.css">
</head>

<body style="background: linear-gradient(135deg,#141e30,#243b55);">

<div class="card p-4 shadow-lg" style="max-width:400px;margin:120px auto;background:rgba(255,255,255,0.08);backdrop-filter: blur(10px); color:white; border-radius:15px;">

<h2 class="text-center mb-4">User Register</h2>

<form method="post">

<input class="form-control mb-3" type="text" name="name" placeholder="Name" required>

<input class="form-control mb-3" type="email" name="email" placeholder="Email" required>

<input class="form-control mb-3" type="password" name="password" placeholder="Password" required>

<button class="btn btn-success w-100" name="register">Register</button>

<br><br>

<a href="user_login.php" style="color:#ddd;">Already have account?</a>

</form>

</div>

</body>
</html>
