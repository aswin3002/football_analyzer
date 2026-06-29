<?php
include "db.php";

$id = $_GET['id'];

/* PLAYER DETAILS */
$player = mysqli_query($conn,"SELECT * FROM players WHERE player_id='$id'");
$p = mysqli_fetch_assoc($player);

/* LATEST PLAYER STATS */
$stats = mysqli_query($conn,"
SELECT * FROM player_stats 
WHERE player_id='$id' 
ORDER BY stat_id DESC 
LIMIT 1
");

$s = mysqli_fetch_assoc($stats);

/* NULL values fix */
$speed = $s['speed'] ?? 0;
$dribbling = $s['dribbling'] ?? 0;
$passes = $s['passes'] ?? 0;
$shooting = $s['shooting_accuracy'] ?? 0;
$defense = $s['tackles'] ?? 0;
$stamina = $s['stamina'] ?? 0;

?>

<!DOCTYPE html>
<html>
<head>

<title>Player Profile</title>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>

body{
font-family:Arial;
background:#f4f6f9;
padding:30px;
}

/* player card */

.player-card{
background:white;
padding:20px;
border-radius:10px;
box-shadow:0 5px 10px rgba(0,0,0,0.1);
width:600px;
margin:auto;
}

/* stats grid */

.stats{
display:grid;
grid-template-columns:repeat(3,1fr);
gap:15px;
margin-top:20px;
}

.stat{
background:#f1f1f1;
padding:10px;
border-radius:8px;
text-align:center;
font-weight:bold;
}

/* chart */

.chart-box{
width:400px;
margin:auto;
margin-top:30px;
}

</style>

</head>

<body>

<div class="player-card">

<h2><?php echo $p['name']; ?></h2>

Age : <?php echo $p['age']; ?> <br>
Height : <?php echo $p['height']; ?> cm<br>
Weight : <?php echo $p['weight']; ?> kg<br>

<div class="stats">

<div class="stat">⚡ Speed<br><?php echo $speed; ?>%</div>

<div class="stat">⚽ Dribbling<br><?php echo $dribbling; ?>%</div>

<div class="stat">🎯 Passing<br><?php echo $passes; ?>%</div>

<div class="stat">🥅 Shooting<br><?php echo $shooting; ?>%</div>

<div class="stat">🛡 Defense<br><?php echo $defense; ?>%</div>

<div class="stat">💪 Stamina<br><?php echo $stamina; ?>%</div>

</div>

<div class="chart-box">
<canvas id="radarChart"></canvas>
</div>

</div>

<script>

const data = {
labels:['Speed','Dribbling','Passing','Shooting','Defense','Stamina'],

datasets:[{
label:'Skill Level',

data:[
<?php echo $speed; ?>,
<?php echo $dribbling; ?>,
<?php echo $passes; ?>,
<?php echo $shooting; ?>,
<?php echo $defense; ?>,
<?php echo $stamina; ?>
],

backgroundColor:'rgba(54,162,235,0.2)',
borderColor:'#3498db',
borderWidth:2,
pointBackgroundColor:'#3498db'

}]
};

new Chart(document.getElementById("radarChart"),{
type:'radar',
data:data,
options:{
responsive:true,
plugins:{
legend:{
display:false
}
},
scales:{
r:{
min:0,
max:100,
ticks:{
stepSize:20
}
}
}
}
});

</script>

</body>
</html>