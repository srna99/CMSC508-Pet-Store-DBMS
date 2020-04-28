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
            
            $stmt = $conn->prepare('select c_id, first_name, last_name, birthdate from Customer order by first_name, last_name, birthdate;');
            $stmt->execute();
            
            // make form for deleting customer
            echo "<form method='post' action='deleteCustomer.php'>";
            echo "<table>";
            echo "<tbody>";
            echo "<tr><td>Select a customer</td><td>";
           
            // make dropdown menu for pets
            echo "<select name='c_id'>";
            
            // show info from query
            while ($row = $stmt->fetch()) {
                echo "<option value='$row[c_id]'>$row[first_name] $row[last_name] (born $row[birthdate])</option>";
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
                $stmt = $conn->prepare("delete from Customer where c_id = :c_id;");
                
                $stmt->bindValue(':c_id', $_POST['c_id']);
                
                $stmt->execute();
                
                echo "Successfully deleted customer.";
                
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            
        }
        
        ?>
        
        <!-- click to get back to index -->
		<br><br><a href="index.php">Back to index</a>
		
	</body>
</html>