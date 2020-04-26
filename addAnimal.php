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
		
		<h1>Add New Animal</h1>
	
        <?php
        
        require_once ('connection.php');
        
        // first page
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            
            // make fill-in form for new animal
            echo "<form method='post' action='addAnimal.php'>";
            echo "<table>";
            echo "<tbody>";
            echo "<tr><td>Species</td><td><input name='classification' type='text' size='25' required></td></tr>";
            echo "<tr><td>Diet type</td><td>";
           
            // make dropdown menu for diet type
            echo "<select name='diet_type'>";
            
            echo "<option value='Carnivore'>Carnivore</option>";
            echo "<option value='Herbivore'>Herbivore</option>";
            echo "<option value='Omnivore'>Omnivore</option>";
            
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
                $stmt = $conn->prepare("insert into Animal values (:classification, :diet_type);");
                
                $stmt->bindValue(':classification', $_POST['classification']);
                $stmt->bindValue(':diet_type', $_POST['diet_type']);
                
                $stmt->execute();
                
                echo "Successfully added new animal.";
                
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            
        }
        
        ?>
        
        <!-- click to get back to index -->
		<br><br><a href="index.php">Back to index</a>
		
	</body>
</html>