<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

include "../db.php";

function getCount($conn, $table){
    $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM $table");
    if(!$result){
        return 0;
    }
    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}

$total_players = getCount($conn, "players");
$total_matches = getCount($conn, "matches");
$total_stats   = getCount($conn, "player_stats");
$total_users   = getCount($conn, "users");

$recent_players = mysqli_query($conn,"
    SELECT p.name, p.age, p.created_at, 
           t.team_name,
           pos.position_name
    FROM players p
    LEFT JOIN teams t ON p.team_id = t.team_id
    LEFT JOIN positions pos ON p.position_id = pos.position_id
    ORDER BY p.player_id DESC
    LIMIT 5
");

$position_query = mysqli_query($conn, "
    SELECT pos.position_name, COUNT(p.player_id) as total
    FROM positions pos
    LEFT JOIN players p ON pos.position_id = p.position_id
    GROUP BY pos.position_id
");

$position_labels = [];
$position_data = [];

if($position_query){
    while($row = mysqli_fetch_assoc($position_query)){
        $position_labels[] = $row['position_name'];
        $position_data[] = $row['total'];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>⚽ Football Admin Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        body{
            margin:0;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg,#0f2027,#203a43,#2c5364);
            min-height:100vh;
            color:white;
        }

        .sidebar{
            width:250px;
            height:100vh;
            position:fixed;
            background: linear-gradient(180deg,#052e16,#064e3b);
            padding-top:20px;
            box-shadow: 5px 0 20px rgba(0,0,0,0.5);
        }

        .sidebar h4{
            text-align:center;
            margin-bottom:30px;
            font-family:'Orbitron', sans-serif;
            font-size:20px;
            letter-spacing:2px;
            color:#22c55e;
        }

        .sidebar a{
            display:block;
            color:#bbf7d0;
            padding:12px 20px;
            text-decoration:none;
            transition:0.3s;
        }

        .sidebar a:hover{
            background:#16a34a;
            color:white;
            padding-left:28px;
        }

        .main-content{
            margin-left:250px;
            padding:40px;
        }

        .dashboard-title{
            font-family:'Orbitron', sans-serif;
            font-size:32px;
            font-weight:700;
            color:#22c55e;
            text-shadow:0 0 10px rgba(34,197,94,0.8);
        }

        .card-box{
            border-radius:20px;
            padding:25px;
            background: linear-gradient(45deg,#15803d,#22c55e);
            box-shadow:0 8px 25px rgba(0,0,0,0.5);
            transition:0.3s;
        }

        .card-box:hover{
            transform:translateY(-8px);
        }

        .card-box h3{
            font-size:36px;
            font-weight:bold;
        }

        .card{
            background:#0f172a;
            border:none;
            border-radius:20px;
            color:white;
            box-shadow:0 8px 20px rgba(0,0,0,0.5);
        }

        .table{
            color:white;
        }

        .table-dark{
            background:#064e3b;
        }

        .table tbody tr:hover{
            background:#14532d;
        }

        canvas{
            background:#111827;
            border-radius:15px;
            padding:15px;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h4>⚽ ADMIN PANEL</h4>
    <a href="dashboard.php">🏠 Dashboard</a>
    <a href="add_team.php">🏟 Add Team</a>
    <a href="add_player.php">👤 Add Player</a>
    <a href="add_match.php">📅 Add Match</a>
    <a href="add_stats.php">📊 Add Stats</a>
    <a href="view_players.php">📋 View Players</a>
    <a href="logout.php">🚪 Logout</a>
</div>

<div class="main-content">
    <h2 class="dashboard-title mb-4">Dashboard Overview</h2>

    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card-box">
                <h5>Total Players</h5>
                <h3><?php echo $total_players; ?></h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card-box">
                <h5>Total Matches</h5>
                <h3><?php echo $total_matches; ?></h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card-box">
                <h5>Total Stats</h5>
                <h3><?php echo $total_stats; ?></h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card-box">
                <h5>Total Users</h5>
                <h3><?php echo $total_users; ?></h3>
            </div>
        </div>
    </div>

    <h4 class="mb-3">Recent Players</h4>
    <div class="card shadow-sm mb-5">
        <div class="card-body">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Name</th>
                        <th>Team</th>
                        <th>Position</th>
                        <th>Age</th>
                        <th>Joined</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                if($recent_players && mysqli_num_rows($recent_players) > 0){
                    while($row = mysqli_fetch_assoc($recent_players)){
                ?>
                    <tr>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['team_name'] ?? 'No Team'; ?></td>
                        <td><?php echo $row['position_name'] ?? 'Not Set'; ?></td>
                        <td><?php echo $row['age']; ?></td>
                        <td><?php echo date("d M Y", strtotime($row['created_at'])); ?></td>
                    </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>No Players Found</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>

    <h4 class="mb-3">Player Distribution by Position</h4>
    <div class="card shadow-sm p-4">
        <canvas id="positionChart"></canvas>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('positionChart').getContext('2d');

new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: <?php echo json_encode($position_labels); ?>,
        datasets: [{
            label: 'Players',
            data: <?php echo json_encode($position_data); ?>,
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom',
                labels: { color: 'white' }
            }
        }
    }
});
</script>

</body>
</html>