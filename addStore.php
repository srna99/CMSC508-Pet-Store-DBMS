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
		
		<h1>Add New Store Location</h1>
	
        <?php
        
        require_once ('connection.php');
        
        // first page
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            
            // make fill-in form for new store
            echo "<form method='post' action='addStore.php'>";
            echo "<table>";
            echo "<tbody>";
            
            echo "<tr><td>Address</td><td><input name='address' type='text' size='25' required></td></tr>";
            
            echo "<tr><td>Manager</td><td>";
            
            $stmt = $conn->prepare('select e_id, concat(first_name, " ", last_name) as name, store from Employee 
                            where e_id not in (select manager from Store) and e_id not in (select e_id from Cashier) and e_id not in (select e_id from Groomer) and e_id not in (select e_id from Stocker) and e_id not in (select e_id from Trainer);');
            $stmt->execute();
            
            // get all emp
            echo "<select name='manager'>";
            
            while ($row = $stmt->fetch()) {
                echo "<option value='$row[e_id]'>$row[name] at Store $row[store]</option>";
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
                
                // insert into table
                $stmt = $conn->prepare("insert into Store(address, manager) values (:address, :manager);");
                
                $stmt->bindValue(':address', trim($_POST['address']));
                $stmt->bindValue(':manager', $_POST['manager']);
                
                $stmt->execute();
                
                $stmt = $conn->prepare("update Employee set manager = null and store = :s_id where e_id = :e_id;");
                
                $stmt->bindValue(":s_id", $_POST['s_id']);
                $stmt->bindValue(":e_id", $_POST['e_id']);
                
                $stmt->execute();
                
                echo "Successfully added new store location.";
                
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            
        }
        
        ?>
        
        <!-- click to get back to index -->
		<br><br><a href="index.php">Back to index</a>
		
	</body>
</html>