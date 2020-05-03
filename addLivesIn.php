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
		
		<h1>Add New Animal to Habitat</h1>
	
        <?php
        
        require_once ('connection.php');
        
        // first page
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            
            // make fill-in form
            echo "<form method='post' action='addLivesIn.php'>";
            echo "<table>";
            echo "<tbody>";
            
            $stmt = $conn->prepare('select classification,diet_type from Animal order by classification;');
            $stmt->execute();
            
            // get all animals
            echo "<tr><td>Animal</td><td>";
            echo "<select name='animal'>";
            
            while ($row = $stmt->fetch()) {
                echo "<option value='$row[classification]'>$row[classification]: Diet Type: $row[diet_type] </option>";
            }
            
            echo "</select>";
            echo "</td></tr>";

            echo "<tr><td>Filter</td><td>";
            
            $stmt = $conn->prepare('select SN,volume,capacity,price from Habitat order by SN;');
            $stmt->execute();
            
            // get all habitats
            echo "<select name='habitat'>";
            
            while ($row = $stmt->fetch()) {
                echo "<option value='$row[SN]'>$row[SN]: Volume: $row[volume] Capacity: $row[capacity] Price: $row[price]</option>";
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
                $stmt = $conn->prepare("insert into Lives_In values (:animal,:habitat);");
                
                $stmt->bindValue(':animal', $_POST['animal']);
                $stmt->bindValue(':habitat', $_POST['habitat']);
                
                $stmt->execute();
                
                echo "Successfully added new Animal Lives In Habitat record.";
                
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            
        }
        
        ?>
        
        <!-- click to get back to index -->
		<br><br><a href="index.php">Back to index</a>
		
	</body>
</html>