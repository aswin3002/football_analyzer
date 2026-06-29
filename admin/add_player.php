<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

include "../db.php";

$message = "";

/* FETCH TEAMS */
$teams = mysqli_query($conn,"SELECT * FROM teams ORDER BY team_name ASC");

/* FETCH POSITIONS */
$positions = mysqli_query($conn,"SELECT * FROM positions ORDER BY position_name ASC");

/* ADD PLAYER */
if(isset($_POST['add_player'])){

    $name = trim($_POST['name']);
    $age = $_POST['age'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $team_id = $_POST['team_id'];
    $position_id = $_POST['position_id'];

    if($name && $age && $team_id && $position_id){

        $stmt = $conn->prepare("
            INSERT INTO players 
            (name, age, height, weight, team_id, position_id) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");

        $stmt->bind_param("sidiii",
            $name,
            $age,
            $height,
            $weight,
            $team_id,
            $position_id
        );

        if($stmt->execute()){

            $player_id = $stmt->insert_id;

            $conn->query("INSERT INTO player_stats (player_id) VALUES ($player_id)");

            $message = "<div class='alert alert-success'>Player Added Successfully!</div>";

        } else {
            $message = "<div class='alert alert-danger'>Error Adding Player</div>";
        }

        $stmt->close();

    } else {
        $message = "<div class='alert alert-warning'>Please fill all required fields!</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Player</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background: linear-gradient(135deg,#0f2027,#203a43,#2c5364);
            font-family: 'Poppins', sans-serif;
        }

        .form-box{
            max-width:650px;
            margin:60px auto;
            background:white;
            padding:35px;
            border-radius:15px;
            box-shadow:0 15px 35px rgba(0,0,0,0.3);
        }

        h3{
            font-weight:600;
        }

        .btn-primary{
            background:#2c5364;
            border:none;
        }

        .btn-primary:hover{
            background:#203a43;
        }
    </style>
</head>
<body>

<div class="form-box">

    <h3 class="mb-4 text-center">⚽ Add New Player</h3>

    <?php echo $message; ?>

    <form method="POST">

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Name *</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label>Age *</label>
                <input type="number" name="age" class="form-control" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Height (cm)</label>
                <input type="number" step="0.01" name="height" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label>Weight (kg)</label>
                <input type="number" step="0.01" name="weight" class="form-control">
            </div>
        </div>

        <div class="mb-3">
            <label>Team *</label>
            <select name="team_id" class="form-control" required>
                <option value="">Select Team</option>
                <?php while($row = mysqli_fetch_assoc($teams)){ ?>
                    <option value="<?php echo $row['team_id']; ?>">
                        <?php echo $row['team_name']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Position *</label>
            <select name="position_id" class="form-control" required>
                <option value="">Select Position</option>
                <?php while($row = mysqli_fetch_assoc($positions)){ ?>
                    <option value="<?php echo $row['position_id']; ?>">
                        <?php echo $row['position_name']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <button type="submit" name="add_player" class="btn btn-primary w-100">
            Add Player
        </button>

    </form>

    <div class="text-center mt-3">
        <a href="view_players.php" class="btn btn-outline-dark btn-sm">
            View All Players
        </a>
    </div>

</div>

</body>
</html>