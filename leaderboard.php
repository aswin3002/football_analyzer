<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

include "db.php";

/* FETCH TOP PLAYERS */
$query = mysqli_query($conn,"
SELECT p.player_id,p.name,p.age,p.height,p.weight,
ps.speed,ps.stamina,ps.dribbling,ps.shooting_accuracy,
ps.overall_rating,pos.position_name
FROM players p
LEFT JOIN player_stats ps ON p.player_id = ps.player_id
LEFT JOIN positions pos ON p.position_id = pos.position_id
ORDER BY ps.overall_rating DESC
LIMIT 10
");

?>

<!DOCTYPE html>
<html>
<head>
<title>Top Players Leaderboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
background:linear-gradient(135deg,#141e30,#243b55);
font-family:Poppins;
color:white;
}

.table{
background:white;
color:black;
border-radius:10px;
overflow:hidden;
}

h2{
font-weight:bold;
}

.rank1{
background:#FFD700;
}

.rank2{
background:#C0C0C0;
}

.rank3{
background:#CD7F32;
}

</style>

</head>

<body>

<div class="container mt-5">

<h2 class="text-center mb-4">🏆 Top Players Leaderboard</h2>

<table class="table table-bordered text-center">

<thead class="table-dark">
<tr>
<th>Rank</th>
<th>Player</th>
<th>Position</th>
<th>Speed</th>
<th>Dribbling</th>
<th>Shooting</th>
<th>Stamina</th>
<th>Overall</th>
</tr>
</thead>

<tbody>

<?php
$rank = 1;

while($row = mysqli_fetch_assoc($query)){

$class="";

if($rank==1) $class="rank1";
if($rank==2) $class="rank2";
if($rank==3) $class="rank3";

?>

<tr class="<?php echo $class; ?>">

<td><?php echo $rank; ?></td>

<td><?php echo $row['name']; ?></td>

<td><?php echo $row['position_name']; ?></td>

<td><?php echo $row['speed']; ?></td>

<td><?php echo $row['dribbling']; ?></td>

<td><?php echo $row['shooting_accuracy']; ?></td>

<td><?php echo $row['stamina']; ?></td>

<td><b><?php echo $row['overall_rating']; ?></b></td>

</tr>

<?php
$rank++;
}
?>

</tbody>
</table>

</div>

</body>
</html>