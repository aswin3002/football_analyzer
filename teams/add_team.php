<?php
include("../db/db_connect.php");

if (isset($_POST['submit'])) {
    $team_name = $_POST['team_name'];
    mysqli_query($conn, "INSERT INTO teams (team_name) VALUES ('$team_name')");
    echo "Team Added Successfully";
}
?>

<h2>Add Team</h2>

<form method="post">
    Team Name:
    <input type="text" name="team_name" required>
    <input type="submit" name="submit" value="Add Team">
</form>
