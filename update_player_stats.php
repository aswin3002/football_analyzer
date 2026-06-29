<?php
session_start();
include "db.php";

if(isset($_POST['player_id'])){

$player_id = $_POST['player_id'];

$goals = $_POST['goals'];
$assists = $_POST['assists'];
$passes = $_POST['passes'];
$tackles = $_POST['tackles'];
$clearances = $_POST['clearances'];
$saves = $_POST['saves'];
$clean_sheets = $_POST['clean_sheets'];

$speed = $_POST['speed'];
$stamina = $_POST['stamina'];
$strength = $_POST['strength'];
$dribbling = $_POST['dribbling'];
$shooting_accuracy = $_POST['shooting_accuracy'];

$query = "UPDATE player_stats SET 
goals='$goals',
assists='$assists',
passes='$passes',
tackles='$tackles',
clearances='$clearances',
saves='$saves',
clean_sheets='$clean_sheets',
speed='$speed',
stamina='$stamina',
strength='$strength',
dribbling='$dribbling',
shooting_accuracy='$shooting_accuracy'
WHERE player_id='$player_id'";

mysqli_query($conn,$query);

header("Location: admin_dashboard.php?msg=updated");
}
?>