<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500&display=swap" rel="stylesheet">

    <style>
        body{
            margin:0;
            font-family:'Orbitron', sans-serif;
            background:linear-gradient(to right, #0f2027, #203a43, #2c5364);
            color:white;
        }

        .navbar{
            background:#111;
            padding:15px 40px;
            display:flex;
            justify-content:space-between;
            align-items:center;
        }

        .navbar h2{
            margin:0;
            color:#22c55e;
        }

        .logout{
            background:#dc2626;
            padding:8px 15px;
            color:white;
            text-decoration:none;
            border-radius:5px;
        }

        .container{
            text-align:center;
            padding:60px 20px;
        }

        .card{
            background:#1c1c1c;
            padding:40px;
            width:350px;
            margin:30px auto;
            border-radius:15px;
            box-shadow:0 0 20px rgba(34,197,94,0.5);
            transition:0.3s;
        }

        .card:hover{
            transform:scale(1.05);
        }

        .btn{
            display:inline-block;
            margin-top:20px;
            padding:12px 25px;
            background:#22c55e;
            color:white;
            text-decoration:none;
            border-radius:8px;
        }

        .btn:hover{
            background:#15803d;
        }

        .leaderboard{
            background:#f59e0b;
        }

        .leaderboard:hover{
            background:#b45309;
        }

        .compare{
            background:#3b82f6;
        }

        .compare:hover{
            background:#1d4ed8;
        }

        h1{
            font-size:40px;
        }

    </style>
</head>

<body>

<div class="navbar">
    <h2>⚽ Football Analyzer</h2>
    <a href="logout.php" class="logout">Logout</a>
</div>

<div class="container">

    <h1>Welcome User ⚽🔥</h1>

    <!-- Explore Players -->
    <div class="card">
        <h3>View Player Performance</h3>
        <a href="players_list.php" class="btn">Explore Players</a>
    </div>

    <!-- Leaderboard -->
    <div class="card">
        <h3>Top Players Ranking</h3>
        <a href="leaderboard.php" class="btn leaderboard">🏆 View Leaderboard</a>
    </div>

    <!-- Player Comparison -->
    <div class="card">
        <h3>Compare Two Players</h3>
        <a href="compare_players.php" class="btn compare">⚔️ Compare Players</a>
    </div>

</div>

</body>
</html>