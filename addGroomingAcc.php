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
		
		<h1>Add New Grooming Accessory</h1>
	
        <?php
        
        require_once ('connection.php');
        
        // first page
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            
            // make fill-in form for new pet
            echo "<form method='post' action='addGroomingAcc.php'>";
            echo "<table>";
            echo "<tbody>";
            echo "<tr><td>SN</td><td><input name='sn' type='number' min='1' max='99999' step='1' size='8' required></td></tr>";
            echo "<tr><td>Type</td><td><input name='type_of' type='text' size='25' required></td></tr>";
            echo "<tr><td>Size</td><td><input name='size' type='number' min='1' max='50' step='1' size='8' required></td></tr>";
            
            echo "<tr><td>Animal</td><td>";
            
            $stmt = $conn->prepare('select classification from Animal order by classification;');
            $stmt->execute();
            
            // get all animals
            echo "<select name='animal'>";
            
            while ($row = $stmt->fetch()) {
                echo "<option value='$row[classification]'>$row[classification]</option>";
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
                $stmt = $conn->prepare("insert into Grooming_Accessory values (:sn, :type_of, :size, :animal);");
                
                $stmt->bindValue(':sn', $_POST['sn']);
                $stmt->bindValue(':type_of', trim($_POST['type_of']));
                $stmt->bindValue(':size', $_POST['size']);
                $stmt->bindValue(':animal', $_POST['animal']);
                
                $stmt->execute();
                
                echo "Successfully added new grooming accessory.";
                
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            
        }
        
        ?>
        
        <!-- click to get back to index -->
		<br><br><a href="index.php">Back to index</a>
		
	</body>
</html>