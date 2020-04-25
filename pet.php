<html>
	<head>
		<style>
            table, th, td {
            	border: 1px solid black;
            	border-collapse: collapse;
            }
            
            td {
                padding: 10px;
                text-align: right;
            }
        </style>
	</head>
	<body>

        <?php
        require_once ('connection.php');
        
        setlocale(LC_MONETARY, 'en_US');
        
        // Retrieve list of employees
        $stmt = $conn->prepare('select p_id, pet_name, birthdate, price, available, store from Pet order by p_id;');
        $stmt->execute();
        
        echo "<table>";
        echo "<thead><tr>
            <th>ID</th>
            <th>Pet name</th>
            <th>Birthdate</th>
            <th>Price</th>
            <th>Availability</th>
            <th>Store</th>
            </tr></thead>";
        echo "<tbody>";
        
        while ($row = $stmt->fetch()) {
            echo "<tr><td>$row[p_id]</td>";
        
            if ($row["pet_name"] == null || $row["pet_name"] == "") {
                echo '<td>No name</td>';
            } else {
                echo "<td>" . $row["pet_name"] . "</td>";
            }
        
            if ($row["birthdate"] == null) {
                echo '<td>N/A</td>';
            } else {
                echo "<td>" . $row["birthdate"] . "</td>";
            }
        
            echo "<td>" . money_format("%.2n", $row["price"]) . "</td>
            <td>$row[available]</td>
            <td>$row[store]</td>
            </tr>";
        }
        
        echo "</tbody>";
        echo "</table>";
        
        ?>

	</body>
</html>