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
		
		<h1>Add New Crate</h1>
	
        <?php
        
        require_once ('connection.php');


        // send post
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {

            echo "<form method='post' action='addCrate.php'>";
            echo "<table>";
            echo "<tbody>";
            echo "<tr><td>Quantity</td><td><input name='quantity' type='number' min='0 step='1' size='11' required></td></tr>";
            echo "<tr><td>Size</td><td><input name='size' type='number' min='1' step='1' size='11' required></td></tr>";
            echo "<tr><td>SN</td><td><input name='SN' type='number' min='1' step='1' size='7'></td></tr>";
            echo "<tr><td>Animal</td><td>";
           
            $stmt = $conn->prepare("SELECT classification FROM Animal");
            $stmt->execute();

            echo "<select name='animal'>"; // get animal for drop down
            echo "<option disabled selected value> -- select an animal -- </option>";
            while ($row = $stmt->fetch()) {
                echo "<option value='" . $row['classification'] . "'>" . $row['classification'] . "</option>";
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
                $stmt = $conn->prepare("insert into Crate values (:quantity,:size,:SN,:animal);");
                
                $stmt->bindValue(':quantity', $_POST['quantity']);
                $stmt->bindValue(':size', $_POST['size']);
                $stmt->bindValue(':SN', $_POST['SN']);
                $stmt->bindValue(':animal', $_POST['animal']);
                
                $stmt->execute();
                
                echo "Successfully added new Crate.";
                
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            
        }
        
        ?>
        
        <!-- click to get back to index -->
		<br><br><a href="index.php">Back to index</a>
		
	</body>
</html>