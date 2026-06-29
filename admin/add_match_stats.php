<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

include "../db.php";

/* =========================
   GET MATCH ID
========================= */
if(!isset($_GET['match_id'])){
    die("Match ID not found");
}

$match_id = $_GET['match_id'];

/* =========================
   GET MATCH DETAILS
========================= */
$match_query = mysqli_query($conn,
    "SELECT * FROM matches WHERE match_id = $match_id"
);

$match = mysqli_fetch_assoc($match_query);

$home = $match['home_team_id'];
$away = $match['away_team_id'];

/* =========================
   GET PLAYERS FROM BOTH TEAMS
========================= */
$players = mysqli_query($conn,
    "SELECT * FROM players 
     WHERE team_id = $home 
     OR team_id = $away"
);

/* =========================
   SAVE PLAYER PERFORMANCE
========================= */
if(isset($_POST['save'])){

    $player_id = $_POST['player_id'];
    $goals = $_POST['goals'];
    $assists = $_POST['assists'];
    $rating = $_POST['rating'];

    // Insert into match_player_stats
    mysqli_query($conn,"
        INSERT INTO match_player_stats
        (match_id, player_id, goals, assists, rating)
        VALUES
        ('$match_id','$player_id','$goals','$assists','$rating')
    ");

    echo "<script>alert('Performance Added Successfully');</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Match Stats</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <h3 class="mb-4">Add Player Performance</h3>

    <form method="POST" class="card p-4 shadow">

        <div class="mb-3">
            <label class="form-label">Select Player</label>
            <select name="player_id" class="form-select" required>
                <option value="">Select Player</option>
                <?php
                while($row = mysqli_fetch_assoc($players)){
                    echo "<option value='".$row['player_id']."'>".$row['name']."</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Goals</label>
            <input type="number" name="goals" class="form-control" value="0">
        </div>

        <div class="mb-3">
            <label class="form-label">Assists</label>
            <input type="number" name="assists" class="form-control" value="0">
        </div>

        <div class="mb-3">
            <label class="form-label">Rating (0-100)</label>
            <input type="number" name="rating" class="form-control" min="0" max="100" required>
        </div>

        <button type="submit" name="save" class="btn btn-primary">
            Save Performance
        </button>

    </form>

</div>

</body>
</html>