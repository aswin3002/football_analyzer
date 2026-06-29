<?php
include "db.php";

$sql = "SELECT * FROM players";
$result = mysqli_query($conn,$sql);
?>

<!DOCTYPE html>
<html>
<head>
<title>Players List</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500&display=swap" rel="stylesheet">

<style>

body{
    font-family:Poppins;
    background:#0f172a;
    margin:0;
    padding:0;
    color:white;
}

.header{
    background:#020617;
    padding:20px;
    text-align:center;
    font-size:28px;
    font-weight:500;
    letter-spacing:2px;
}

.container{
    display:flex;
    flex-wrap:wrap;
    justify-content:center;
    margin-top:30px;
}

.card{
    background:#1e293b;
    width:260px;
    margin:15px;
    border-radius:10px;
    text-align:center;
    padding:20px;
    transition:0.3s;
}

.card:hover{
    transform:scale(1.05);
    box-shadow:0px 0px 20px rgba(0,255,255,0.4);
}

.player-img{
    width:120px;
    height:120px;
    border-radius:50%;
    object-fit:cover;
    margin-bottom:10px;
}

.name{
    font-size:20px;
    margin:10px 0;
}

.info{
    font-size:14px;
    color:#cbd5f5;
}

.btn{
    display:inline-block;
    margin-top:12px;
    padding:8px 16px;
    background:#22c55e;
    color:white;
    text-decoration:none;
    border-radius:5px;
    transition:0.3s;
}

.btn:hover{
    background:#16a34a;
}

</style>

</head>

<body>

<div class="header">
⚽ Football Player Analyzer
</div>

<div class="container">

<?php
while($row=mysqli_fetch_assoc($result)){
?>

<div class="card">

<img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" class="player-img">

<div class="name">
<?php echo $row['name']; ?>
</div>

<div class="info">
Age : <?php echo $row['age']; ?> yrs <br>
Height : <?php echo $row['height']; ?> cm <br>
Weight : <?php echo $row['weight']; ?> kg
</div>

<a href="player_profile.php?id=<?php echo $row['player_id']; ?>" class="btn">
View Details
</a>

</div>

<?php
}
?>

</div>

</body>
</html>