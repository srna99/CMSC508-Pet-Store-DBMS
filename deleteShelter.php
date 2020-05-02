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
		
		<h1>Delete A Shelter</h1>
	
        <?php
        
        require_once ('connection.php');
        
        // first page
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            
            $stmt = $conn->prepare('select s_id, shelter_name, address from Shelter order by shelter_name;');
            $stmt->execute();
            
            // make form for deleting shelter
            echo "<form method='post' action='deleteShelter.php'>";
            echo "<table>";
            echo "<tbody>";
            echo "<tr><td>Select a shelter</td><td>";
           
            // make dropdown menu for shelter
            echo "<select name='s_id'>";
            
            // show info from query
            while ($row = $stmt->fetch()) {
                echo "<option value='$row[s_id]'>$row[shelter_name] at $row[address]</option>";
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
                $stmt = $conn->prepare("delete from Shelter where s_id = :s_id;");
                
                $stmt->bindValue(':s_id', $_POST['s_id']);
                
                $stmt->execute();
                
                echo "Successfully deleted shelter.";
                
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            
        }
        
        ?>
        
        <!-- click to get back to index -->
		<br><br><a href="index.php">Back to index</a>
		
	</body>
</html>