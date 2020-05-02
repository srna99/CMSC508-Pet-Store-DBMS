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
		
		<h1>Add New Shelter</h1>
	
        <?php
        
        require_once ('connection.php');
        
        // first page
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            
            // make fill-in form for new shelter
            echo "<form method='post' action='addShelter.php'>";
            echo "<table>";
            echo "<tbody>";
            
            echo "<tr><td>Shelter name</td><td><input name='shelter_name' type='text' size='25' required></td></tr>";
            echo "<tr><td>Address</td><td><input name='address' type='text' size='25' required></td></tr>";
           
            // submit form button
            echo "<tr><td></td><td><input type='submit' value='Submit'></td></tr>";
            
            echo "</tbody>";
            echo "</table>";
            echo "</form>";
            
        } else { // after user submitted form
            
            try {
                
                // insert into table
                $stmt = $conn->prepare("insert into Shelter(shelter_name, address) values (:shelter_name, :address);");
                
                $stmt->bindValue(':shelter_name', trim($_POST['shelter_name']));
                $stmt->bindValue(':address', trim($_POST['address']));
                
                $stmt->execute();
                
                echo "Successfully added new shelter.";
                
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            
        }
        
        ?>
        
        <!-- click to get back to index -->
		<br><br><a href="index.php">Back to index</a>
		
	</body>
</html>