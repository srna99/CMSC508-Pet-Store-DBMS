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
		
		<h1>Add New Light</h1>
	
        <?php
        
        require_once ('connection.php');


        // send post
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {

            echo "<form method='post' action='addLight.php'>";
            echo "<table>";
            echo "<tbody>";
            echo "<tr><td>SN</td><td><input name='SN' type='number' min='1' step='1' size='7'></td></tr>";
            echo "<tr><td>Wattage</td><td><input name='wattage' type='number' min='0 step='1' size='11'></td></tr>";
            echo "<tr><td>Brand</td><td><input name='brand' type='text' size='20'></td></tr>";
            echo "<tr><td>Size</td><td><input name='size' type='number' min='1' step='1' size='11'></td></tr>";
            
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
                $stmt = $conn->prepare("insert into Light values (:SN,:wattage,:brand,:size);");
                
                $stmt->bindValue(':SN', $_POST['SN']);
                $stmt->bindValue(':wattage', $_POST['wattage']);
                $stmt->bindValue(':brand', $_POST['brand']);
                $stmt->bindValue(':size', $_POST['size']);
                
                
                $stmt->execute();
                
                echo "Successfully added new Light.";
                
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            
        }
        
        ?>
        
        <!-- click to get back to index -->
		<br><br><a href="index.php">Back to index</a>
		
	</body>
</html>