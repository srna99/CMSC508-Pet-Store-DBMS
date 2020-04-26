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
		
		<h1>Add New Pet</h1>
	
        <?php
        
        require_once ('connection.php');
        
        // first page
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            
            // make fill-in form for new pet
            echo "<form method='post' action='addPet.php'>";
            echo "<table>";
            echo "<tbody>";
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
            
            echo "<tr><td>Pet name</td><td><input name='pet_name' type='text' size='25'></td></tr>";
            echo "<tr><td>Birthdate</td><td><input name='birthdate' type='date' min='1980-01-01' max=" . date('Y-m-d') . "></td></tr>";            
            echo "<tr><td>Price</td><td><input name='price' type='number' min='0.01' max='99999.99' step='0.01' size='8' value='0.00' required></td></tr>";
            
            echo "<tr><td>Store</td><td>";
            
            $stmt = $conn->prepare('select s_id from Store order by s_id;');
            $stmt->execute();
            
            // get all stores
            echo "<select name='store'>";
            
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
                
                // insert into table
                $stmt = $conn->prepare("insert into Pet(animal, pet_name, birthdate, price, store) values (:animal, :pet_name, :birthdate, :price, :store);");
                
                $stmt->bindValue(':animal', $_POST['animal']);
                $stmt->bindValue(':price', $_POST['price']);
                $stmt->bindValue(':store', $_POST['store']);
                
                if($_POST['pet_name'] != "") {
                    $stmt->bindValue(':pet_name', $_POST['pet_name']);
                } else {
                    $stmt->bindValue(':pet_name', null, PDO::PARAM_STR);
                }
                
                if($_POST['birthdate'] != "") {
                    $stmt->bindValue(':birthdate', $_POST['birthdate']);
                } else {
                    $stmt->bindValue(':birthdate', null, PDO::PARAM_STR);
                }
                
                $stmt->execute();
                
                echo "Successfully added new pet.";
                
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            
        }
        
        ?>
        
        <!-- click to get back to index -->
		<br><br><a href="index.php">Back to index</a>
		
	</body>
</html>