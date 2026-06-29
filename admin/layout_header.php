<!DOCTYPE html>
<html>
<head>
    <title>Football Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
    margin:0;
    background: linear-gradient(135deg,#0f2027,#203a43,#2c5364);
    font-family: 'Segoe UI', sans-serif;
    color:white;
}

.sidebar {
    height:100vh;
    background:#111;
    padding-top:20px;
    position:fixed;
    width:230px;
}

.sidebar a {
    display:block;
    color:white;
    padding:12px 20px;
    text-decoration:none;
}

.sidebar a:hover {
    background:#0d6efd;
}

.content {
    margin-left:230px;
    padding:30px;
}

.card {
    background:rgba(255,255,255,0.08);
    backdrop-filter:blur(8px);
    border:none;
    border-radius:15px;
    color:white;
}

.btn {
    border-radius:30px;
}

table {
    color:white !important;
}
</style>
</head>
<body>

<div class="sidebar">
    <h4 class="text-center mb-4">⚽ Admin</h4>
    <a href="dashboard.php">Dashboard</a>
    <a href="add_match.php">Matches</a>
    <a href="add_player.php">Add Player</a>
    <a href="add_team.php">Add Team</a>
    <a href="add_stats.php">Add Stats</a>
    <a href="logout.php" class="text-danger">Logout</a>
</div>

<div class="content">