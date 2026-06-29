<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

include "../db.php";

$message = "";

/* ADD TEAM */
if(isset($_POST['add_team'])){

    $team_name = trim($_POST['team_name']);
    $coach_name = trim($_POST['coach_name']);
    $stadium = trim($_POST['stadium']);

    if($team_name){

        $stmt = $conn->prepare("
            INSERT INTO teams (team_name, coach_name, stadium)
            VALUES (?, ?, ?)
        ");

        if(!$stmt){
            die("Prepare Failed: " . $conn->error);
        }

        $stmt->bind_param("sss",
            $team_name,
            $coach_name,
            $stadium
        );

        if($stmt->execute()){
            $message = "<div class='alert alert-success'>Team Added Successfully!</div>";
        } else {
            $message = "<div class='alert alert-danger'>Error Adding Team</div>";
        }

        $stmt->close();

    } else {
        $message = "<div class='alert alert-warning'>Team Name is Required!</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Team</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background: linear-gradient(135deg,#0f2027,#203a43,#2c5364);
}

.team-card{
    max-width:600px;
    margin:70px auto;
    background:white;
    padding:35px;
    border-radius:20px;
    box-shadow:0 15px 40px rgba(0,0,0,0.3);
}
</style>
</head>

<body>

<div class="team-card">

<h3 class="text-center mb-4">🏆 Add New Team</h3>

<?php echo $message; ?>

<form method="POST">

<div class="mb-3">
<label>Team Name *</label>
<input type="text" name="team_name" class="form-control" required>
</div>

<div class="mb-3">
<label>Coach Name</label>
<input type="text" name="coach_name" class="form-control">
</div>

<div class="mb-3">
<label>Home Stadium</label>
<input type="text" name="stadium" class="form-control">
</div>

<button type="submit" name="add_team" class="btn btn-primary w-100">
Add Team
</button>

</form>

<div class="text-center mt-3">
<a href="view_teams.php" class="btn btn-outline-dark btn-sm">
View All Teams
</a>
</div>

</div>

</body>
</html>