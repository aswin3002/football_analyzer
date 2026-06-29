<?php
include("../db/db_connect.php");

$players = mysqli_query($conn, "SELECT * FROM players");
$matches = mysqli_query($conn, "SELECT * FROM matches");

if (isset($_POST['submit'])) {

    $query = "INSERT INTO player_stats
    (player_id, match_id, goals, assists, passes, tackles, minutes_played)
    VALUES (
        '$_POST[player_id]',
        '$_POST[match_id]',
        '$_POST[goals]',
        '$_POST[assists]',
        '$_POST[passes]',
        '$_POST[tackles]',
        '$_POST[minutes]'
    )";

    mysqli_query($conn, $query);
}
?>

<h2>Add Match Performance</h2>

<form method="post">

Player:
<select name="player_id">
<?php while ($p = mysqli_fetch_assoc($players)) { ?>
<option value="<?php echo $p['player_id']; ?>">
<?php echo $p['name']; ?>
</option>
<?php } ?>
</select><br><br>

Match:
<select name="match_id">
<?php while ($m = mysqli_fetch_assoc($matches)) { ?>
<option value="<?php echo $m['match_id']; ?>">
<?php echo $m['opponent']; ?>
</option>
<?php } ?>
</select><br><br>

Goals: <input type="number" name="goals" value="0"><br><br>
Assists: <input type="number" name="assists" value="0"><br><br>
Passes: <input type="number" name="passes" value="0"><br><br>
Tackles: <input type="number" name="tackles" value="0"><br><br>
Minutes Played: <input type="number" name="minutes" value="90"><br><br>

<input type="submit" name="submit" value="Save Performance">

</form>
