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
		
		<h1>Add New Decor for Habitat</h1>
	
        <?php
        
        require_once ('connection.php');
        
        // first page
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            
            // make fill-in form
            echo "<form method='post' action='addDecorates.php'>";
            echo "<table>";
            echo "<tbody>";

            echo "<tr><td>Habitat</td><td>";
            
            $stmt = $conn->prepare('select SN,volume,capacity,price from Habitat order by SN;');
            $stmt->execute();
            
            // get all habitats
            echo "<select name='habitat'>";
            
            while ($row = $stmt->fetch()) {
                echo "<option value='$row[SN]'>$row[SN]: Volume: $row[volume] Capacity: $row[capacity] Price: $row[price]</option>";
            }
            
            echo "</select>";
            echo "</td></tr>";

            $stmt = $conn->prepare('select SN,type_of,price,animal from Decor order by SN;');
            $stmt->execute();
            
            // get all Decor
            echo "<tr><td>Decor</td><td>";
            echo "<select name='decor'>";
            
            while ($row = $stmt->fetch()) {
                echo "<option value='$row[SN]'>$row[type_of]: for $row[animal] Price: $row[price] </option>";
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
                $stmt = $conn->prepare("insert into Decorates values (:habitat,:decor);");
                
                $stmt->bindValue(':habitat', $_POST['habitat']);
                $stmt->bindValue(':decor', $_POST['decor']);
                
                $stmt->execute();
                
                echo "Successfully added new Decor For Habitat record.";
                
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            
        }
        
        ?>
        
        <!-- click to get back to index -->
		<br><br><a href="index.php">Back to index</a>
		
	</body>
</html>