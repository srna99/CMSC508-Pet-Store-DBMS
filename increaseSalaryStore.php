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
		
		<h1>Increase Salary of Employees By Store</h1>
	
        <?php
        
        require_once ('connection.php');
        
        // first page
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            
            echo "<form method='post' action='increaseSalaryStore.php'>";
            echo "<table>";
            echo "<tbody>";
            echo "<tr><td>Salary increase percentage</td><td><input name='percentage' type='number' min='0.01' max='1.0' step='0.01' size='8' value='0.00' required></td></tr>";
            
            echo "<tr><td>Store</td><td>";
            
            $stmt = $conn->prepare('select s_id from Store order by s_id;');
            $stmt->execute();
           
            // make dropdown menu for stores
            echo "<select name='store'>";
            
            // show info from query
            while ($row = $stmt->fetch()) {
                echo "<option value='$row[s_id]'>$row[s_id]</option>";
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
                $stmt = $conn->prepare("call increase_salary_by_percentage_of_store(:percentage, :store);");
                
                $stmt->bindValue(':percentage', $_POST['percentage']);
                $stmt->bindValue(':store', $_POST['store']);
                
                $stmt->execute();
                
                echo "Successfully increased salary of employees.";
                
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            
        }
        
        ?>
        
        <!-- click to get back to index -->
		<br><br><a href="index.php">Back to index</a>
		
	</body>
</html>