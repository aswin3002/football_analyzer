<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

include "db.php";

/* FETCH PLAYERS */
$players = mysqli_query($conn,"SELECT player_id,name FROM players ORDER BY name ASC");

$p1 = null;
$p2 = null;

if(isset($_POST['compare'])){

$player1 = $_POST['player1'];
$player2 = $_POST['player2'];

$p1 = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT p.name,ps.speed,ps.stamina,ps.dribbling,ps.shooting_accuracy,ps.passes
FROM players p
LEFT JOIN player_stats ps ON p.player_id = ps.player_id
WHERE p.player_id = $player1
"));

$p2 = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT p.name,ps.speed,ps.stamina,ps.dribbling,ps.shooting_accuracy,ps.passes
FROM players p
LEFT JOIN player_stats ps ON p.player_id = ps.player_id
WHERE p.player_id = $player2
"));

}
?>

<!DOCTYPE html>
<html>
<head>

<title>Compare Players</title>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>

body{
font-family:Arial;
background:#0f2027;
color:white;
text-align:center;
padding:40px;
}

select,button{
padding:10px;
margin:10px;
}

canvas{
max-width:600px;
margin:auto;
}

</style>

</head>

<body>

<h2>⚔️ Player Comparison</h2>

<form method="POST">

<select name="player1" required>
<option value="">Select Player 1</option>
<?php
mysqli_data_seek($players,0);
while($row = mysqli_fetch_assoc($players)){
?>
<option value="<?php echo $row['player_id']; ?>">
<?php echo $row['name']; ?>
</option>
<?php } ?>
</select>

<select name="player2" required>
<option value="">Select Player 2</option>
<?php
mysqli_data_seek($players,0);
while($row = mysqli_fetch_assoc($players)){
?>
<option value="<?php echo $row['player_id']; ?>">
<?php echo $row['name']; ?>
</option>
<?php } ?>
</select>

<br>

<button type="submit" name="compare">Compare</button>

</form>

<?php if($p1 && $p2){ ?>

<h3><?php echo $p1['name']; ?> vs <?php echo $p2['name']; ?></h3>

<canvas id="compareChart"></canvas>

<script>

const data = {
labels: ['Speed','Dribbling','Passing','Shooting','Stamina'],
datasets: [
{
label: '<?php echo $p1['name']; ?>',
data: [
<?php echo $p1['speed']; ?>,
<?php echo $p1['dribbling']; ?>,
<?php echo $p1['passes']; ?>,
<?php echo $p1['shooting_accuracy']; ?>,
<?php echo $p1['stamina']; ?>
],
borderColor:'red'
},
{
label: '<?php echo $p2['name']; ?>',
data: [
<?php echo $p2['speed']; ?>,
<?php echo $p2['dribbling']; ?>,
<?php echo $p2['passes']; ?>,
<?php echo $p2['shooting_accuracy']; ?>,
<?php echo $p2['stamina']; ?>
],
borderColor:'blue'
}
]
};

new Chart(document.getElementById("compareChart"),{
type:'radar',
data:data,
options:{
scales:{
r:{
min:0,
max:100
}
}
}
});

</script>

<?php } ?>

</body>
</html>