<?php
include("../db/db_connect.php");

/*
Consistency Logic:
Average of match performance
Performance = goals + assists + passes + tackles
*/

$query = "
SELECT 
    p.name AS player_name,
    COUNT(s.stat_id) AS total_matches,
    AVG(s.goals + s.assists + s.passes + s.tackles) AS consistency_score
FROM player_stats s
JOIN players p ON s.player_id = p.player_id
GROUP BY s.player_id
";

$result = mysqli_query($conn, $query);
?>

<h2>⚽ Player Consistency Report</h2>

<table border="1" cellpadding="8">
<tr>
    <th>Player Name</th>
    <th>Total Matches</th>
    <th>Consistency Score</th>
</tr>

<?php while ($row = mysqli_fetch_assoc($result)) { ?>
<tr>
    <td><?php echo $row['player_name']; ?></td>
    <td><?php echo $row['total_matches']; ?></td>
    <td><?php echo round($row['consistency_score'], 2); ?></td>
</tr>
<?php } ?>

</table>
