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
		
		<h1>Add New Bowl</h1>
	
        <?php
        
        require_once ('connection.php');


        // send post
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {

            echo "<form method='post' action='addBowl.php'>";
            echo "<table>";
            echo "<tbody>";
            echo "<tr><td>Serial Number</td><td><input name='SN' type='number' min='1' step='1' size='7'></td></tr>";
            echo "<tr><td>Substrate</td><td><input name='substrate' type='text' size='10'></td></tr>";
            echo "<tr><td>Opening Diameter</td><td><input name='opening_diameter' type='number' min='0 step='1' size='11'></td></tr>";
            
            
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
                $stmt = $conn->prepare("insert into Bowl values (:SN,:substrate,:opening_diameter);");
                
                $stmt->bindValue(':SN', $_POST['SN']);
                $stmt->bindValue(':substrate', $_POST['substrate']);
                $stmt->bindValue(':opening_diameter', $_POST['opening_diameter']);
                
                $stmt->execute();
                
                echo "Successfully added new Bowl.";
                
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            
        }
        
        ?>
        
        <!-- click to get back to index -->
		<br><br><a href="index.php">Back to index</a>
		
	</body>
</html>