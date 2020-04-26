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
		
		<h1>Delete Pet</h1>
	
        <?php
        
        require_once ('connection.php');
        
        // first page
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            
            $stmt = $conn->prepare('select p_id, animal, pet_name, store from Pet order by animal, pet_name, store;');
            $stmt->execute();
            
            // make form for deleting pet
            echo "<form method='post' action='deletePet.php'>";
            echo "<table>";
            echo "<tbody>";
            echo "<tr><td>Select a pet</td><td>";
           
            // make dropdown menu for pets
            echo "<select name='p_id'>";
            
            // show info from query
            while ($row = $stmt->fetch()) {
                echo "<option value='$row[p_id]'>$row[pet_name] the $row[animal] at Store $row[store]</option>";
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
                
                // delete from table
                $stmt = $conn->prepare("delete from Pet where p_id = :p_id;");
                
                $stmt->bindValue(':p_id', $_POST['p_id']);
                
                $stmt->execute();
                
                echo "Successfully deleted pet.";
                
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            
        }
        
        ?>
        
        <!-- click to get back to index -->
		<br><br><a href="index.php">Back to index</a>
		
	</body>
</html>