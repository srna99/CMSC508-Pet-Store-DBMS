<html>
	<head>
		<style>
            table, th, td {
            	border: 1px solid black;
            	border-collapse: collapse;
            }
            
            table {
                margin-bottom: 30px;
                margin-left: 0.5em;
            }
            
            th, td {
                padding-left: 10px;
                padding-right: 10px;
                padding-top: 5px;
                padding-bottom: 5px;
            }
            
            h1 {
                margin-top: 0.8em;
                margin-left: 0.5em;
            }
        </style>
	</head>
	
	<body>
		<h1>List of All Pets</h1>
	
        <?php
        require_once ('connection.php');
        
        setlocale(LC_MONETARY, 'en_US');
        
        // get all pets
        $stmt = $conn->prepare('select p_id, animal, pet_name, birthdate, price, available, store from Pet order by p_id;');
        $stmt->execute();
        
        // make table
        echo "<table>";
        // row headings
        echo "<thead><tr>
            <th>ID</th>
            <th>Animal</th>
            <th>Pet name</th>
            <th>Birthdate</th>
            <th>Price</th>
            <th>Availability</th>
            <th>Store</th>
            </tr></thead>";
        echo "<tbody>";
        
        // info from query
        while ($row = $stmt->fetch()) {
            echo "<tr><td>$row[p_id]</td>
            <td>$row[animal]</td>";
        
            // replace null and "" with text
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
        
            // format price into money 
            echo "<td>" . money_format("%.2n", $row["price"]) . "</td> 
            <td>$row[available]</td>
            <td>$row[store]</td>
            </tr>";
        }
        
        echo "</tbody>";
        echo "</table>";
        
        ?>
        
        <!-- back to index link -->
		<a href="index.php">Back to index</a>
	</body>
</html>