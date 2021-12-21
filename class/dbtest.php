<?php try {$pdo = new PDO("mysql:host=localhost;dbname=test","db","dbpass");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
$sql="select * from test";
$stmt = $pdo->prepare($sql);
$stmt->execute();
echo "<table border='1' align='center'>";
while (($row = $stmt->fetch(PDO::FETCH_ASSOC) ) !== false){
echo "<tr>";
echo "<td>".$row['顧客id']."</td>";

echo "<td>".$row['name']."</td>";
echo "</tr>";}
echo "</table>";}
catch(PDOException $e){
echo $e->getMessage(); } ?>