<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

include "../db.php";

$query = mysqli_query($conn,"
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
    <title>All Matches</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <div class="d-flex justify-content-between mb-4">
        <h3>All Matches</h3>
        <a href="add_match.php" class="btn btn-success">+ Add New Match</a>
    </div>

    <div class="card shadow">
        <div class="card-body">

            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Date</th>
                        <th>Match</th>
                        <th>Score</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                <?php while($row = mysqli_fetch_assoc($query)) { ?>

                    <tr>
                        <td><?php echo $row['match_date']; ?></td>

                        <td>
                            <?php echo $row['home_team']; ?> 
                            vs 
                            <?php echo $row['away_team']; ?>
                        </td>

                        <td>
                            <?php echo $row['home_score']; ?> 
                            - 
                            <?php echo $row['away_score']; ?>
                        </td>

                        <td>
                            <a href="add_match_stats.php?match_id=<?php echo $row['match_id']; ?>" 
                               class="btn btn-primary btn-sm">
                              <a href="view_match.php?match_id=<?php echo $row['match_id']; ?>" 
   class="btn btn-info btn-sm">
   View
</a>

<a href="add_match_stats.php?match_id=<?php echo $row['match_id']; ?>" 
   class="btn btn-primary btn-sm">
   Add Stats
</a>
                            </a>
                        </td>
                    </tr>

                <?php } ?>

                </tbody>
            </table>

        </div>
    </div>

</div>

</body>
</html>