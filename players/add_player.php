<?php
include("../db/db_connect.php");

$team_result = mysqli_query($conn, "SELECT * FROM teams");

if (isset($_POST['submit'])) {

    $name     = $_POST['name'];
    $position = $_POST['position'];
    $team_id  = $_POST['team_id'];

    $query = "INSERT INTO players (name, position, team_id)
              VALUES ('$name', '$position', '$team_id')";

    mysqli_query($conn, $query);
}
?>

<h2>Add Player</h2>

<form method="post">

    Name:
    <input type="text" name="name" required><br><br>

    Position:
    <input type="text" name="position" required><br><br>

    Team:
    <select name="team_id">
        <?php while ($row = mysqli_fetch_assoc($team_result)) { ?>
            <option value="<?php echo $row['team_id']; ?>">
                <?php echo $row['team_name']; ?>
            </option>
        <?php } ?>
    </select><br><br>

    <input type="submit" name="submit" value="Add Player">

</form>
