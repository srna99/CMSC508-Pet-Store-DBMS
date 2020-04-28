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
		<h1>List of All Customers</h1>
	
        <?php
        require_once ('connection.php');
        
        // get all pets
        $stmt = $conn->prepare('select c_id, first_name, last_name, email, birthdate, phone_number, address from Customer order by first_name, last_name;');
        $stmt->execute();
        
        // make table
        echo "<table>";
        // row headings
        echo "<thead><tr>
            <th>ID</th>
            <th>First name</th>
            <th>Last name</th>
            <th>Email</th>
            <th>Birthdate</th>
            <th>Phone number</th>
            <th>Address</th>
            </tr></thead>";
        echo "<tbody>";
        
        // info from query
        while ($row = $stmt->fetch()) {
            echo "<tr><td>$row[c_id]</td>
            <td>$row[first_name]</td>
            <td>$row[last_name]</td>";
        
            if ($row["email"] == null) {
                echo '<td>N/A</td>';
            } else {
                echo "<td>" . $row["email"] . "</td>";
            }
        
            echo "<td>$row[birthdate]</td>";
            
            if ($row["phone_number"] == null) {
                echo '<td>N/A</td>';
            } else {
                echo "<td>" . $row["phone_number"] . "</td>";
            }
            
            if ($row["address"] == null) {
                echo '<td>N/A</td>';
            } else {
                echo "<td>" . $row["address"] . "</td>";
            }

            echo "</tr>";
        }
        
        echo "</tbody>";
        echo "</table>";
        
        ?>
        
        <!-- back to index link -->
		<a href="index.php">Back to index</a>
	</body>
</html>