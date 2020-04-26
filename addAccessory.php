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
		
		<h1>Add New Accessory</h1>
	
        <?php
        
        require_once ('connection.php');
        mysql_connect('localhost', 'project_21', 'V00809310');
        mysql_select_db('project_21');

        // send post
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            $sql = "SELECT animal FROM Animal"
            $result = mysql_query($sql);

            echo "<form method='post' action='addAccessory.php'>";
            echo "<table>";
            echo "<tbody>";
            echo "<tr><td>SN</td><td><input name='SN' type='number' min='1' step='1' size='8'></td></tr>";
            echo "<tr><td>Brand</td><td><input name='brand' type='text' size='25'></td></tr>";
            echo "<tr><td>Price</td><td><input name='price' type='number' min='0.01' step='0.01' size='8'></td></tr>";
            echo "<tr><td>Quantity</td><td><input name='quantity' type='number' min='0 step='1' size='8'></td></tr>";
            echo "<tr><td>Type Of</td><td><input name='type_of' type='text' size='25'></td></tr>";
            echo "<tr><td>Animal</td><td>";
           
        //  $stmt = $conn->prepare("SELECT animal FROM Animal");
        //     $stmt->execute();

        //     while ($row = $stmt->fetch()) {
        //         echo "<option value='$row[employee_id]'>$row[first_name] $row[last_name]</option>";
        //     }   

            echo "<select name='animal'>"; // get animal for drop down
            while ($row = mysql_fetch_array($result)) {
                echo "<option value='" . $row['animal'] . "'>" . $row['animal'] . "</option>";
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
                $stmt = $conn->prepare("insert into Accessory values (:SN, :type_of,:brand,:price,:quantity,:animal);");
                
                $stmt->bindValue(':SN', $_POST['SN']);
                $stmt->bindValue(':type_of', $_POST['type_of']);
                $stmt->bindValue(':brand', $_POST['brand']);
                $stmt->bindValue(':price', $_POST['price']);
                $stmt->bindValue(':quantity', $_POST['quantity']);
                $stmt->bindValue(':animal', $_POST['animal']);
                
                $stmt->execute();
                
                echo "Successfully added new Accessory.";
                
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            
        }
        
        ?>
        
        <!-- click to get back to index -->
		<br><br><a href="index.php">Back to index</a>
		
	</body>
</html>