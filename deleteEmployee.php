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
		
		<h1>Delete An Employee</h1>
	
        <?php
        
        require_once ('connection.php');
        
        // first page
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            
            $stmt = $conn->prepare('select e_id, first_name, last_name, store from Employee order by first_name, last_name, store;');
            $stmt->execute();
            
            // make form for deleting employee
            echo "<form method='post' action='deleteEmployee.php'>";
            echo "<table>";
            echo "<tbody>";
            echo "<tr><td>Select an employee</td><td>";
           
            // make dropdown menu for employees
            echo "<select name='e_id'>";
            
            // show info from query
            while ($row = $stmt->fetch()) {
                echo "<option value='$row[e_id]'>$row[first_name] $row[last_name] at Store $row[store]</option>";
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
                $stmt = $conn->prepare("delete from Employee where e_id = :e_id;");
                
                $stmt->bindValue(':e_id', $_POST['e_id']);
                
                $stmt->execute();
                
                echo "Successfully deleted employee.";
                
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            
        }
        
        ?>
        
        <!-- click to get back to index -->
		<br><br><a href="index.php">Back to index</a>
		
	</body>
</html>
