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
		<h1>Lesson History</h1>
	
        <?php
        
        require_once ('connection.php');
        
        // get all treatments
        $stmt = $conn->prepare('select trainer, lesson, scheduled_date, capacity, animal, date_added from Lesson_History order by date_added;');
        $stmt->execute();
        
        // make table
        echo "<table>";
        // row headings
        echo "<thead><tr>
            <th>Trainer</th>
            <th>Lesson</th>
            <th>Scheduled date</th>
            <th>Capacity</th>
            <th>Animal</th>
            <th>Date added</th>
            </tr></thead>";
        echo "<tbody>";
        
        // info from query
        while ($row = $stmt->fetch()) {
            echo "<tr><td>$row[trainer]</td>
            <td>$row[lesson]</td>
            <td>$row[scheduled_date]</td>";
            
            if ($row["capacity"] == null) {
                echo '<td>N/A</td>';
            } else {
                echo "<td>" . $row["capacity"] . "</td>";
            }
            
            echo "<td>$row[animal]</td>
            <td>$row[date_added]</td></tr>";
        }
        
        echo "</tbody>";
        echo "</table>";
        
        ?>
        
        <!-- back to index link -->
		<a href="index.php">Back to index</a>
	</body>
</html>