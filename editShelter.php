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
		
		<h1>Edit A Shelter</h1>
	
        <?php
        
        require_once ('connection.php');
        
        session_start();
        
        // first page
        if (!isset($_GET['s_id']) && $_SERVER['REQUEST_METHOD'] != 'POST') {
            
            $stmt = $conn->prepare('select s_id, shelter_name, address from Shelter order by shelter_name;');
            $stmt->execute();
            
            // select a shelter to get to current related info
            echo "<form method='get'>";
            echo "Select a shelter:  ";
            
            // make dropdown menu for shelters
            echo "<select name='s_id' onchange='this.form.submit();'>";
            echo "<option disabled selected value> -- select a shelter -- </option>";
            
            // show info from query
            while ($row = $stmt->fetch()) {
                echo "<option value='$row[s_id]'>$row[shelter_name] at $row[address]</option>";
            }
            
            echo "</select>";
            echo "</form>";
            exit();
            
        }
        
        // second page - form
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            
            $s_id = $_GET["s_id"];
            
            // get related info from pk
            $stmt = $conn->prepare('select shelter_name, address from Shelter where s_id = :s_id;');
            $stmt->bindValue(':s_id', $s_id);
            
            $stmt->execute();
            
            $row = $stmt->fetch();
            
            // display current info
            echo "<form method='post' action='editShelter.php'>";
            echo "<table>";
            echo "<tbody>";
            echo "<tr><td>Shelter name</td><td><input name='shelter_name' type='text' value='$row[shelter_name]' size='25' required></td></tr>";
            echo "<tr><td>Address</td><td><input name='address' type='text' value='$row[address]' size='25' required></td></tr>";
            
            // submit button
            echo "<tr><td></td><td><input type='submit' value='Submit'></td></tr>";
            echo "</tbody>";
            echo "</table>";
            echo "</form>";
            
            $_SESSION["editShelter_s_id"] = $s_id; 
            
        } else { // after submitting form
            
            try {
                
                // update shelter with edits
                $stmt = $conn->prepare("update Shelter set shelter_name = :shelter_name, address = :address where s_id = :s_id;");
                
                $stmt->bindValue(':shelter_name', trim($_POST['shelter_name']));
                $stmt->bindValue(':address', trim($_POST['address']));
                $stmt->bindValue(':s_id', $_SESSION["editShelter_s_id"]);
                
                $stmt->execute();
                
                echo "Successfully updated shelter.";
                
            } catch (PDOException $e) {
                
                echo "Error: " . $e->getMessage();
            }
            
            unset ($_SESSION["editShelter_s_id"]);
            
        }
        
        ?>
        
        <!-- click to get back to index -->
		<br><br><a href="index.php">Back to index</a>
		
	</body>
</html>