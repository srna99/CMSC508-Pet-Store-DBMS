<?php

require_once('connection.php');

setlocale(LC_MONETARY, 'en_US');

// Retrieve list of employees
$stmt = $conn->prepare('select p_id, ifnull(pet_name, "No name"), ifnull(birthdate, "N/A"), price, available, store from Pet order by p_id;');
$stmt->execute();

echo "<table style='border: solid 1px black;'>";
echo "<thead><tr><th>ID</th><th>Pet name</th><th>Birthdate</th><th>Price</th><th>Availability</th><th>Store</th></tr></thead>";
echo "<tbody>";

while ($row = $stmt->fetch()) {
    echo "<tr><td>$row[p_id]</td><td>$row[pet_name]</td><td>$row[birthdate]</td><td>" . money_format("%.2n", $row["price"]) . "</td><td>$row[available]</td><td>$row[store]</td></tr>";
}

echo "</tbody>";
echo "</table>";

?>