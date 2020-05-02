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
		
		<h1>Edit a Representative</h1>
	
        <?php
        
        require_once ('connection.php');
        
        session_start();
        
        // first page
        if (!isset($_GET['r_id']) && $_SERVER['REQUEST_METHOD'] != 'POST') {
            
            $stmt = $conn->prepare('select r_id, concat(first_name, " ", last_name) as name, (select shelter_name from Shelter where s_id = shelter) as shelter from Representative order by name;');
            $stmt->execute();
            
            // select a rep to get to current related info
            echo "<form method='get'>";
            echo "Select a representative:  ";
            
            // make dropdown menu for reps
            echo "<select name='r_id' onchange='this.form.submit();'>";
            echo "<option disabled selected value> -- select a representative -- </option>";
            
            // show info from query
            while ($row = $stmt->fetch()) {
                echo "<option value='$row[r_id]'>$row[name] from $row[shelter]</option>";
            }
            
            echo "</select>";
            echo "</form>";
            exit();
            
        }
        
        // second page - form
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            
            $r_id = $_GET["r_id"];
            
            // get related info from pk
            $stmt = $conn->prepare('select first_name, last_name, phone_number, shelter from Representative where r_id = :r_id;');
            $stmt->bindValue(':r_id', $r_id);
            
            $stmt->execute();
            
            $row = $stmt->fetch();
            
            // display current info
            echo "<form method='post' action='editRepresentative.php'>";
            echo "<table>";
            echo "<tbody>";
            echo "<tr><td>First name</td><td><input name='first_name' type='text' size='25' value='$row[first_name]' required></td></tr>";
            echo "<tr><td>Last name</td><td><input name='last_name' type='text' size='25' value='$row[last_name]' required></td></tr>";
            
            if ($row['phone_number'] != null) {
                echo "<tr><td>Phone number</td><td><input name='phone_number' type='tel' pattern='[0-9]{3}-[0-9]{3}-[0-9]{4}' value='$row[phone_number]'><br><small>Format: 123-456-7890</small></td></tr>";
            } else {
                echo "<tr><td>Phone number</td><td><input name='phone_number' type='tel' pattern='[0-9]{3}-[0-9]{3}-[0-9]{4}'><br><small>Format: 123-456-7890</small></td></tr>";
            }
            
            echo "<tr><td>Shelter</td><td>";
            
            $s_stmt = $conn->prepare('select s_id, shelter_name, address from Shelter order by shelter_name;');
            $s_stmt->execute();
            
            // get all shelters
            echo "<select name='shelter'>";
            
            while ($s_row = $s_stmt->fetch()) {
                
                if ($s_row['s_id'] == $row['shelter']) {
                    echo "<option value='$s_row[s_id]' selected>$s_row[shelter_name] at $s_row[address]</option>";
                } else {
                    echo "<option value='$s_row[s_id]'>$s_row[shelter_name] at $s_row[address]</option>";
                }
                
            }
            
            echo "</select>";
            echo "</td></tr>";
            
            // submit button
            echo "<tr><td></td><td><input type='submit' value='Submit'></td></tr>";
            echo "</tbody>";
            echo "</table>";
            echo "</form>";
            
            $_SESSION["editRepresentative_r_id"] = $r_id; 
            
        } else { // after submitting form
            
            try {
                
                // update rep with edits
                $stmt = $conn->prepare("update Representative set first_name = :first_name, last_name = :last_name, phone_number = :phone_number, shelter = :shelter where r_id = :r_id;");
                
                $stmt->bindValue(':first_name', trim($_POST['first_name']));
                $stmt->bindValue(':last_name', trim($_POST['last_name']));
                $stmt->bindValue(':shelter', $_POST['shelter']);
                $stmt->bindValue(':r_id', $_SESSION["editRepresentative_r_id"]);
                
                if($_POST['phone_number'] != "") {
                    $stmt->bindValue(':phone_number', $_POST['phone_number']);
                } else {
                    $stmt->bindValue(':phone_number', null, PDO::PARAM_STR);
                }
                
                $stmt->execute();
                
                echo "Successfully updated representative.";
                
            } catch (PDOException $e) {
                
                echo "Error: " . $e->getMessage();
            }
            
            unset ($_SESSION["editRepresentative_r_id"]);
            
        }
        
        ?>
        
        <!-- click to get back to index -->
		<br><br><a href="index.php">Back to index</a>
		
	</body>
</html>