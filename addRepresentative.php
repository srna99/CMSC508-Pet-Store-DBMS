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
		
		<h1>Add New Representative</h1>
	
        <?php
        
        require_once ('connection.php');
        
        // first page
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            
            // make fill-in form for new rep
            echo "<form method='post' action='addRepresentative.php'>";
            echo "<table>";
            echo "<tbody>";
            echo "<tr><td>First name</td><td><input name='first_name' type='text' size='25' required></td></tr>";
            echo "<tr><td>Last name</td><td><input name='last_name' type='text' size='25' required></td></tr>";
            echo "<tr><td>Phone number</td><td><input name='phone_number' type='tel' pattern='[0-9]{3}-[0-9]{3}-[0-9]{4}'><br><small>Format: 123-456-7890</small></td></tr>";
            
            echo "<tr><td>Shelter</td><td>";
            
            $stmt = $conn->prepare('select s_id, shelter_name, address from Shelter order by shelter_name;');
            $stmt->execute();
            
            // get all shelters
            echo "<select name='shelter'>";
            
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
                
                // insert into table
                $stmt = $conn->prepare("insert into Representative(first_name, last_name, phone_number, shelter) values (:first_name, :last_name, :phone_number, :shelter);");
                
                $stmt->bindValue(':first_name', trim($_POST['first_name']));
                $stmt->bindValue(':last_name', trim($_POST['last_name']));
                $stmt->bindValue(':shelter', $_POST['shelter']);
                
                if($_POST['phone_number'] != "") {
                    $stmt->bindValue(':phone_number', $_POST['phone_number']);
                } else {
                    $stmt->bindValue(':phone_number', null, PDO::PARAM_STR);
                }
                
                $stmt->execute();
                
                echo "Successfully added new representative.";
                
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            
        }
        
        ?>
        
        <!-- click to get back to index -->
		<br><br><a href="index.php">Back to index</a>
		
	</body>
</html>