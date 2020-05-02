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
		
		<h1>Associate Representative With Store</h1>
	
        <?php
        
        require_once ('connection.php');
        
        // first page
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            
            // make fill-in form for new rep
            echo "<form method='post' action='addSendRepresentative.php'>";
            echo "<table>";
            echo "<tbody>";
            echo "<tr><td>Representative</td><td>";
            
            $stmt = $conn->prepare('select r_id, concat(first_name, " ", last_name) as name, (select shelter_name from Shelter where s_id = shelter) as shelter from Representative order by name;');
            $stmt->execute();
            
            // get all reps
            echo "<select name='representative'>";
            
            while ($row = $stmt->fetch()) {
                echo "<option value='$row[r_id]'>$row[name] from $row[shelter]</option>";
            }
            
            echo "</select>";
            echo "</td></tr>";
            
            echo "<tr><td>Store</td><td>";
            
            $stmt = $conn->prepare('select s_id, address from Store order by s_id;');
            $stmt->execute();
            
            // get all stores
            echo "<select name='store'>";
            
            while ($row = $stmt->fetch()) {
                echo "<option value='$row[s_id]'>Store $row[s_id] at $row[address]</option>";
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
                $stmt = $conn->prepare("insert into Send_To values (:representative, :store);");
                
                $stmt->bindValue(':representative', $_POST['representative']);
                $stmt->bindValue(':store', $_POST['store']);
                
                $stmt->execute();
                
                echo "Successfully added associated representative with store.";
                
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            
        }
        
        ?>
        
        <!-- click to get back to index -->
		<br><br><a href="index.php">Back to index</a>
		
	</body>
</html>