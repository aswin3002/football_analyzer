<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

include "../db.php";

$id = $_GET['id'];

$result = mysqli_query($conn,"SELECT * FROM players WHERE player_id='$id'");
$row = mysqli_fetch_assoc($result);

if(isset($_POST['update'])){

$name = $_POST['name'];
$age = $_POST['age'];
$height = $_POST['height'];
$weight = $_POST['weight'];

mysqli_query($conn,"UPDATE players SET 
name='$name',
age='$age',
height='$height',
weight='$weight'
WHERE player_id='$id'");

header("Location: view_players.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Player</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body style="background:#f4f6f9">

<div class="container mt-5">

<h2>Edit Player</h2>

<form method="POST">

<div class="mb-3">
<label>Name</label>
<input type="text" name="name" class="form-control"
value="<?php echo $row['name']; ?>">
</div>

<div class="mb-3">
<label>Age</label>
<input type="number" name="age" class="form-control"
value="<?php echo $row['age']; ?>">
</div>

<div class="mb-3">
<label>Height</label>
<input type="text" name="height" class="form-control"
value="<?php echo $row['height']; ?>">
</div>

<div class="mb-3">
<label>Weight</label>
<input type="text" name="weight" class="form-control"
value="<?php echo $row['weight']; ?>">
</div>

<button type="submit" name="update" class="btn btn-success">
Update Player
</button>

<a href="view_players.php" class="btn btn-secondary">
Back
</a>

</form>

</div>

</body>
</html>