<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

include "../db.php";

$query = "
SELECT players.*, 
       teams.team_name,
       positions.position_name
FROM players
LEFT JOIN teams ON players.team_id = teams.team_id
LEFT JOIN positions ON players.position_id = positions.position_id
ORDER BY players.player_id DESC
";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
<title>All Players</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background: linear-gradient(135deg,#0f2027,#203a43,#2c5364);
    font-family: 'Segoe UI', sans-serif;
}

.player-container{
    max-width:1200px;
    margin:60px auto;
    padding:40px;
    border-radius:25px;
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(15px);
    box-shadow: 0 20px 50px rgba(0,0,0,0.4);
    color:white;
}

.page-title{
    text-align:center;
    font-weight:600;
    margin-bottom:30px;
}

.table{
    background:white;
    border-radius:15px;
    overflow:hidden;
}

.table thead{
    background:#141E30;
    color:white;
}

.table tbody tr:hover{
    background:#f2f2f2;
    transition:0.3s;
}

.badge-position{
    background:#007bff;
}

.badge-team{
    background:#28a745;
}

.btn-custom{
    border-radius:20px;
    padding:5px 15px;
}

.action-btns .btn{
    margin:2px;
}
</style>
</head>

<body>

<div class="player-container">

<h2 class="page-title">⚽ All Players</h2>

<div class="d-flex justify-content-end mb-3">
    <a href="add_player.php" class="btn btn-success btn-custom">+ Add Player</a>
    <a href="dashboard.php" class="btn btn-light btn-custom ms-2">Back</a>
</div>

<?php if($result->num_rows > 0){ ?>

<div class="table-responsive">
<table class="table table-hover text-center align-middle">

<thead>
<tr>
<th>ID</th>
<th>Name</th>
<th>Age</th>
<th>Height</th>
<th>Weight</th>
<th>Position</th>
<th>Team</th>
<th>Action</th>
</tr>
</thead>

<tbody>
<?php while($row = $result->fetch_assoc()){ ?>
<tr>
<td><?php echo $row['player_id']; ?></td>
<td><strong><?php echo $row['name']; ?></strong></td>
<td><?php echo $row['age']; ?></td>
<td><?php echo $row['height']; ?> cm</td>
<td><?php echo $row['weight']; ?> kg</td>
<td>
<span class="badge badge-position">
<?php echo $row['position_name'] ?? "N/A"; ?>
</span>
</td>
<td>
<span class="badge badge-team">
<?php echo $row['team_name'] ?? "No Team"; ?>
</span>
</td>
<td class="action-btns">
<a href="edit_player.php?id=<?php echo $row['player_id']; ?>" 
   class="btn btn-primary btn-sm btn-custom">Edit</a>

<a href="delete_player.php?id=<?php echo $row['player_id']; ?>" 
   class="btn btn-danger btn-sm btn-custom"
   onclick="return confirm('Are you sure?')">
   Delete
</a>
</td>
</tr>
<?php } ?>
</tbody>

</table>
</div>

<?php } else { ?>

<div class="alert alert-warning text-center">
No Players Found!
</div>

<?php } ?>

</div>

</body>
</html>