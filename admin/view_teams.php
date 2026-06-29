<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

include "../db.php";

$result = $conn->query("SELECT * FROM teams ORDER BY team_id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>View Teams</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background: linear-gradient(135deg,#0f2027,#203a43,#2c5364);
}

.team-box{
    max-width:900px;
    margin:60px auto;
    background:white;
    padding:30px;
    border-radius:20px;
    box-shadow:0 15px 40px rgba(0,0,0,0.3);
}
</style>

</head>
<body>

<div class="team-box">

<h3 class="text-center mb-4">🏆 All Teams</h3>

<div class="text-end mb-3">
<a href="add_team.php" class="btn btn-success btn-sm">+ Add Team</a>
<a href="dashboard.php" class="btn btn-secondary btn-sm">Back</a>
</div>

<?php if($result->num_rows > 0){ ?>

<table class="table table-bordered text-center">
<thead class="table-dark">
<tr>
<th>ID</th>
<th>Team Name</th>
<th>Coach</th>
<th>Stadium</th>
</tr>
</thead>

<tbody>
<?php while($row = $result->fetch_assoc()){ ?>
<tr>
<td><?php echo $row['team_id']; ?></td>
<td><?php echo $row['team_name']; ?></td>
<td><?php echo $row['coach_name']; ?></td>
<td><?php echo $row['stadium']; ?></td>
</tr>
<?php } ?>
</tbody>

</table>

<?php } else { ?>

<div class="alert alert-warning text-center">
No Teams Added Yet!
</div>

<?php } ?>

</div>

</body>
</html>