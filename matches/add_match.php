<?php
include("../db/db_connect.php");

if (isset($_POST['submit'])) {

    $match_date = $_POST['match_date'];
    $opponent   = $_POST['opponent'];

    $query = "INSERT INTO matches (match_date, opponent)
              VALUES ('$match_date', '$opponent')";

    mysqli_query($conn, $query);
}
?>

<h2>Add Match</h2>

<form method="post">

    Match Date:
    <input type="date" name="match_date" required><br><br>

    Opponent:
    <input type="text" name="opponent" required><br><br>

    <input type="submit" name="submit" value="Add Match">

</form>
