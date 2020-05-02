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
		<h1>List of All Shelter Representatives</h1>
	
        <?php
        
        require_once ('connection.php');
        
        // get all reps
        $stmt = $conn->prepare('select r_id, first_name, last_name, phone_number, (select shelter_name from Shelter where s_id = shelter) as shelter from Representative order by first_name, last_name;');
        $stmt->execute();
        
        // make table
        echo "<table>";
        // row headings
        echo "<thead><tr>
            <th>ID</th>
            <th>First name</th>
            <th>Last name</th>
            <th>Phone number</th>
            <th>Shelter</th>
            </tr></thead>";
        echo "<tbody>";
        
        // info from query
        while ($row = $stmt->fetch()) {
            echo "<tr><td>$row[r_id]</td>
            <td>$row[first_name]</td>
            <td>$row[last_name]</td>";
        
            if ($row["phone_number"] == null) {
                echo '<td>N/A</td>';
            } else {
                echo "<td>" . $row["phone_number"] . "</td>";
            }
            
            echo "<td>$row[shelter]</td></tr>";
        }
        
        echo "</tbody>";
        echo "</table>";
        
        ?>
        
        <!-- back to index link -->
		<a href="index.php">Back to index</a>
	</body>
</html>