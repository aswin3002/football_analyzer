<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

include "../db.php";

$message = "";
$overall_display = "";

/* FETCH PLAYERS */
$players = mysqli_query($conn,"
    SELECT p.player_id, p.name, pos.position_name
    FROM players p
    LEFT JOIN positions pos ON p.position_id = pos.position_id
    ORDER BY p.name ASC
");

/* VALIDATE PERCENTAGE */
function validatePercentage($value){
    if($value < 0) return 0;
    if($value > 100) return 100;
    return (int)$value;
}

/* UPDATE STATS */
if(isset($_POST['update_stats'])){

    $player_id = (int)$_POST['player_id'];

    $goals = (int)$_POST['goals'];
    $assists = (int)$_POST['assists'];
    $passes = (int)$_POST['passes'];
    $tackles = (int)$_POST['tackles'];
    $clearances = (int)$_POST['clearances'];
    $saves = (int)$_POST['saves'];
    $clean_sheets = (int)$_POST['clean_sheets'];

    $speed = validatePercentage($_POST['speed']);
    $stamina = validatePercentage($_POST['stamina']);
    $strength = validatePercentage($_POST['strength']);
    $dribbling = validatePercentage($_POST['dribbling']);
    $shooting_accuracy = validatePercentage($_POST['shooting_accuracy']);

    $posQuery = mysqli_query($conn,"
        SELECT pos.position_name
        FROM players p
        LEFT JOIN positions pos ON p.position_id = pos.position_id
        WHERE p.player_id = $player_id
    ");
    $posData = mysqli_fetch_assoc($posQuery);
    $position = $posData['position_name'];

    $overall = 0;

    if($position == "Goalkeeper"){
        $overall = round(($strength*0.3)+($stamina*0.3)+($speed*0.2)+($clean_sheets*2));
    }
    elseif($position == "Defender"){
        $defensivePerformance = ($tackles+$clearances)/2;
        $overall = round(($strength*0.25)+($stamina*0.25)+($speed*0.15)+($dribbling*0.10)+($shooting_accuracy*0.05)+($defensivePerformance*0.20));
    }
    elseif($position == "Midfielder"){
        $overall = round(($stamina*0.25)+($speed*0.20)+($dribbling*0.20)+($shooting_accuracy*0.15)+($strength*0.20));
    }
    elseif($position == "Forward"){
        $overall = round(($shooting_accuracy*0.35)+($speed*0.25)+($dribbling*0.20)+($stamina*0.10)+($strength*0.10));
    }
    else{
        $overall = round(($speed+$stamina+$strength+$dribbling+$shooting_accuracy)/5);
    }

    if($overall > 100) $overall = 100;
    if($overall < 0) $overall = 0;

    $stmt = $conn->prepare("
        UPDATE player_stats SET
            goals=?, assists=?, passes=?, tackles=?, clearances=?,
            saves=?, clean_sheets=?, speed=?, stamina=?, strength=?,
            dribbling=?, shooting_accuracy=?, overall_rating=?
        WHERE player_id=?
    ");

    $stmt->bind_param(
        "iiiiiiiiiiiiii",
        $goals,$assists,$passes,$tackles,$clearances,
        $saves,$clean_sheets,$speed,$stamina,$strength,
        $dribbling,$shooting_accuracy,$overall,$player_id
    );

    if($stmt->execute()){
        $message = "<div class='alert alert-success'>Stats Updated Successfully!</div>";
        $overall_display = "<div class='overall-box'>Overall Rating: $overall</div>";
    } else {
        $message = "<div class='alert alert-danger'>Error Updating Stats</div>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Update Player Stats</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background: linear-gradient(135deg,#141e30,#243b55);
    font-family: 'Poppins', sans-serif;
}

.card{
    border-radius:20px;
    border:none;
}

.section-title{
    font-weight:600;
    color:#243b55;
    border-bottom:2px solid #243b55;
    padding-bottom:5px;
    margin-bottom:20px;
}

.overall-box{
    background:linear-gradient(45deg,#00c6ff,#0072ff);
    color:white;
    padding:15px;
    border-radius:15px;
    text-align:center;
    font-size:22px;
    font-weight:bold;
    margin-bottom:20px;
}

.btn-primary{
    background:#243b55;
    border:none;
}
.btn-primary:hover{
    background:#141e30;
}
</style>

</head>
<body>

<div class="container mt-5 mb-5">
<div class="card p-4 shadow-lg">

<h3 class="text-center mb-4">⚽ Player Stats Management</h3>

<?php echo $message; ?>
<?php echo $overall_display; ?>

<form method="POST">

<div class="mb-4">
<label>Select Player</label>
<select name="player_id" class="form-control" required>
<option value="">Select Player</option>
<?php while($row = mysqli_fetch_assoc($players)){ ?>
<option value="<?php echo $row['player_id']; ?>">
<?php echo $row['name']." (".$row['position_name'].")"; ?>
</option>
<?php } ?>
</select>
</div>

<h5 class="section-title">Match Performance</h5>
<div class="row">

<div class="col-md-4 mb-3"><label>Goals</label><input type="number" name="goals" class="form-control" value="0"></div>
<div class="col-md-4 mb-3"><label>Assists</label><input type="number" name="assists" class="form-control" value="0"></div>
<div class="col-md-4 mb-3"><label>Passes</label><input type="number" name="passes" class="form-control" value="0"></div>

<div class="col-md-4 mb-3"><label>Tackles</label><input type="number" name="tackles" class="form-control" value="0"></div>
<div class="col-md-4 mb-3"><label>Clearances</label><input type="number" name="clearances" class="form-control" value="0"></div>
<div class="col-md-4 mb-3"><label>Saves</label><input type="number" name="saves" class="form-control" value="0"></div>

<div class="col-md-4 mb-3"><label>Clean Sheets</label><input type="number" name="clean_sheets" class="form-control" value="0"></div>

</div>

<h5 class="section-title mt-4">Player Ratings (0-100)</h5>
<div class="row">

<div class="col-md-4 mb-3"><label>Speed</label><input type="number" name="speed" min="0" max="100" class="form-control" value="0"></div>
<div class="col-md-4 mb-3"><label>Stamina</label><input type="number" name="stamina" min="0" max="100" class="form-control" value="0"></div>
<div class="col-md-4 mb-3"><label>Strength</label><input type="number" name="strength" min="0" max="100" class="form-control" value="0"></div>

<div class="col-md-4 mb-3"><label>Dribbling</label><input type="number" name="dribbling" min="0" max="100" class="form-control" value="0"></div>
<div class="col-md-4 mb-3"><label>Shooting Accuracy</label><input type="number" name="shooting_accuracy" min="0" max="100" class="form-control" value="0"></div>

</div>

<button type="submit" name="update_stats" class="btn btn-primary w-100 mt-3">
Update Player Stats
</button>

</form>

</div>
</div>

</body>
</html>