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
		
		<h1>Delete A Representative</h1>
	
        <?php
        
        require_once ('connection.php');
        
        // first page
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            
            $stmt = $conn->prepare('select r_id, concat(first_name, " ", last_name) as name, (select shelter_name from Shelter where s_id = shelter) as shelter from Representative order by name;');
            $stmt->execute();
            
            // make form for deleting rep
            echo "<form method='post' action='deleteRepresentative.php'>";
            echo "<table>";
            echo "<tbody>";
            echo "<tr><td>Select a representative</td><td>";
           
            // make dropdown menu for rep
            echo "<select name='r_id'>";
            
            // show info from query
            while ($row = $stmt->fetch()) {
                echo "<option value='$row[r_id]'>$row[name] from $row[shelter]</option>";
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
                $stmt = $conn->prepare("delete from Representative where r_id = :r_id;");
                
                $stmt->bindValue(':r_id', $_POST['r_id']);
                
                $stmt->execute();
                
                echo "Successfully deleted representative.";
                
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            
        }
        
        ?>
        
        <!-- click to get back to index -->
		<br><br><a href="index.php">Back to index</a>
		
	</body>
</html>