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
		<h1>List of All Clippers</h1>
	
        <?php
        require_once ('connection.php');
        
        // get all clippers
        $stmt = $conn->prepare('select SN, size, guard, brand, animal from Clipper order by SN;');
        $stmt->execute();
        
        // make table
        echo "<table>";
        // row headings
        echo "<thead><tr>
            <th>SN</th>
            <th>Size</th>
            <th>Guard</th>
            <th>Brand</th>
            <th>Animal</th>
            </tr></thead>";
        echo "<tbody>";
        
        // info from query
        while ($row = $stmt->fetch()) {
            echo "<tr><td>$row[SN]</td>
            <td>$row[size]</td>";
        
            if ($row["guard"] == null) {
                echo '<td>N/A</td>';
            } else {
                echo "<td>" . $row["guard"] . "</td>";
            }
        
            // format price into money 
            echo "<td>$row[brand]</td>
            <td>$row[animal]</td>
            </tr>";
        }
        
        echo "</tbody>";
        echo "</table>";
        
        ?>
        
        <!-- back to index link -->
		<a href="index.php">Back to index</a>
	</body>
</html>