<html>
	<head>
		<style>
            table {
            	border: 1px solid black;
            	border-collapse: collapse;
            }
            
            table {
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
		
		<h1>Add New Filter for Tank</h1>
	
        <?php
        
        require_once ('connection.php');
        
        // first page
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            
            // make fill-in form
            echo "<form method='post' action='addTankFilter.php'>";
            echo "<table>";
            echo "<tbody>";
            echo "<tr><td>Filter</td><td>";
            
            $stmt = $conn->prepare('select SN from Filter order by SN;');
            $stmt->execute();
            
            // get all filters
            echo "<select name='filter'>";
            
            while ($row = $stmt->fetch()) {
                echo "<option value='$row[SN]'>$row[SN]: $row[type_of] filter from $row[brand] size: $row[size]</option>";
            }
            
            echo "</select>";
            echo "</td></tr>";
            
            echo "<tr>Tank<td></td><td>";
            
            $stmt = $conn->prepare('select SN, light, substrate from Tank order by SN;');
            $stmt->execute();
            
            // get all tanks
            echo "<select name='tank'>";
            
            while ($row = $stmt->fetch()) {
                echo "<option value='$row[SN]'>$row[SN]: Substrate: $row[substrate] Light: $row[light]</option>";
            }
            
            echo "</select>";
            echo "</td></tr>";
            
            // submit form button
            echo "<tr><td></td><td><input type='submit' value='Submit'></td></tr>";
            
            echo "</tbody>";
            echo "</table>";
            echo "</form>";
            
        } else { // after user submitted form
            
            try {
                
                // insert into table
                $stmt = $conn->prepare("insert into Tank_Filter values (:filter, :tank);");
                
                $stmt->bindValue(':filter', $_POST['filter']);
                $stmt->bindValue(':tank', $_POST['tank']);
                
                $stmt->execute();
                
                echo "Successfully added new Tank Filter usage record.";
                
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            
        }
        
        ?>
        
        <!-- click to get back to index -->
		<br><br><a href="index.php">Back to index</a>
		
	</body>
</html>