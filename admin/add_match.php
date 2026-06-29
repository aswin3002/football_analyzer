<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

include "../db.php";

/* ADD MATCH */
if(isset($_POST['add_match'])){
    $home = $_POST['home_team'];
    $away = $_POST['away_team'];
    $date = $_POST['match_date'];
    $home_score = $_POST['home_score'];
    $away_score = $_POST['away_score'];

    mysqli_query($conn,"
        INSERT INTO matches 
        (home_team_id, away_team_id, match_date, home_score, away_score)
        VALUES
        ('$home','$away','$date','$home_score','$away_score')
    ");
}

/* STATS */
$total_matches = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) as total FROM matches"))['total'];
$total_goals = mysqli_fetch_assoc(mysqli_query($conn,"SELECT SUM(home_score + away_score) as goals FROM matches"))['goals'] ?? 0;

/* GET MATCHES */
$matches = mysqli_query($conn,"
    SELECT m.*, 
           t1.team_name AS home_team, 
           t2.team_name AS away_team
    FROM matches m
    JOIN teams t1 ON m.home_team_id = t1.team_id
    JOIN teams t2 ON m.away_team_id = t2.team_id
    ORDER BY m.match_date DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Match Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background: linear-gradient(135deg,#0f2027,#203a43,#2c5364);
    color:white;
}

.card {
    border-radius:15px;
}

.glass {
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(10px);
    color:white;
}

.table {
    color:white;
}

.btn-custom {
    border-radius:30px;
}
</style>

</head>
<body>

<div class="container mt-5">

    <!-- SUMMARY CARDS -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card glass shadow p-3">
                <h5>Total Matches</h5>
                <h2><?php echo $total_matches; ?></h2>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card glass shadow p-3">
                <h5>Total Goals</h5>
                <h2><?php echo $total_goals; ?></h2>
            </div>
        </div>
    </div>

    <!-- ADD MATCH FORM -->
    <div class="card glass shadow mb-5 p-4">
        <h4 class="mb-4">⚽ Add New Match</h4>

        <form method="POST">

            <div class="row mb-3">
                <div class="col">
                    <select name="home_team" class="form-select" required>
                        <option value="">Home Team</option>
                        <?php
                        $teams = mysqli_query($conn,"SELECT * FROM teams");
                        while($row = mysqli_fetch_assoc($teams)){
                            echo "<option value='".$row['team_id']."'>".$row['team_name']."</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="col">
                    <select name="away_team" class="form-select" required>
                        <option value="">Away Team</option>
                        <?php
                        $teams = mysqli_query($conn,"SELECT * FROM teams");
                        while($row = mysqli_fetch_assoc($teams)){
                            echo "<option value='".$row['team_id']."'>".$row['team_name']."</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <input type="date" name="match_date" class="form-control" required>
                </div>

                <div class="col">
                    <input type="number" name="home_score" class="form-control" placeholder="Home Score" value="0">
                </div>

                <div class="col">
                    <input type="number" name="away_score" class="form-control" placeholder="Away Score" value="0">
                </div>
            </div>

            <button type="submit" name="add_match" class="btn btn-success btn-custom px-4">
                ➕ Add Match
            </button>

        </form>
    </div>

    <!-- MATCH LIST -->
    <div class="card glass shadow p-4">
        <h4 class="mb-4">📋 All Matches</h4>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Match</th>
                    <th>Score</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>

            <?php while($row = mysqli_fetch_assoc($matches)) { ?>

                <tr>
                    <td><?php echo $row['match_date']; ?></td>

                    <td>
                        <?php echo $row['home_team']; ?> 
                        <strong>vs</strong> 
                        <?php echo $row['away_team']; ?>
                    </td>

                    <td>
                        <span class="badge bg-warning text-dark">
                            <?php echo $row['home_score']; ?> - <?php echo $row['away_score']; ?>
                        </span>
                    </td>

                    <td>
                        <a href="add_match_stats.php?match_id=<?php echo $row['match_id']; ?>" 
                           class="btn btn-primary btn-sm btn-custom">
                           Stats
                        </a>
                    </td>
                </tr>

            <?php } ?>

            </tbody>
        </table>

    </div>

</div>

</body>
</html>