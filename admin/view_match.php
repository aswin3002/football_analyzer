<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

include "../db.php";

if(!isset($_GET['match_id'])){
    die("Match ID missing");
}

$match_id = $_GET['match_id'];

/* Match Details */
$match = mysqli_fetch_assoc(mysqli_query($conn,"
    SELECT m.*, 
           t1.team_name AS home_team, 
           t2.team_name AS away_team
    FROM matches m
    JOIN teams t1 ON m.home_team_id = t1.team_id
    JOIN teams t2 ON m.away_team_id = t2.team_id
    WHERE m.match_id = $match_id
"));

/* Player Stats */
$stats = mysqli_query($conn,"
    SELECT mp.*, p.name
    FROM match_player_stats mp
    JOIN players p ON mp.player_id = p.player_id
    WHERE mp.match_id = $match_id
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Match Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <div class="card shadow mb-4">
        <div class="card-header bg-dark text-white">
            <h4>
                <?php echo $match['home_team']; ?> 
                <?php echo $match['home_score']; ?> -
                <?php echo $match['away_score']; ?>
                <?php echo $match['away_team']; ?>
            </h4>
            <small><?php echo $match['match_date']; ?></small>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-header">
            <h5>Player Performances</h5>
        </div>
        <div class="card-body">

            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Player</th>
                        <th>Goals</th>
                        <th>Assists</th>
                        <th>Rating</th>
                    </tr>
                </thead>
                <tbody>

                <?php while($row = mysqli_fetch_assoc($stats)) { ?>

                    <tr>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['goals']; ?></td>
                        <td><?php echo $row['assists']; ?></td>
                        <td><?php echo $row['rating']; ?></td>
                    </tr>

                <?php } ?>

                </tbody>
            </table>

        </div>
    </div>

</div>

</body>
</html>