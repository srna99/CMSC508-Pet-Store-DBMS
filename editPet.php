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
		
		<h1>Edit a Pet</h1>
	
        <?php
        
        require_once ('connection.php');
        
        session_start();
        
        // first page
        if (!isset($_GET['p_id']) && $_SERVER['REQUEST_METHOD'] != 'POST') {
            
            $stmt = $conn->prepare('select p_id, animal, pet_name, store from Pet order by animal, pet_name, store;');
            $stmt->execute();
            
            // select a pet to get to current related info
            echo "<form method='get'>";
            echo "Select a pet:  ";
            
            // make dropdown menu for pets
            echo "<select name='p_id' onchange='this.form.submit();'>";
            echo "<option disabled selected value> -- select a pet -- </option>";
            
            // show info from query
            while ($row = $stmt->fetch()) {
                echo "<option value='$row[p_id]'>$row[pet_name] the $row[animal] at Store $row[store]</option>";
            }
            
            echo "</select>";
            echo "</form>";
            exit();
            
        }
        
        // second page - form
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            
            $p_id = $_GET["p_id"];
            
            // get related info from pk
            $stmt = $conn->prepare('select pet_name, birthdate, price, store from Pet where p_id = :p_id;');
            $stmt->bindValue(':p_id', $p_id);
            
            $stmt->execute();
            
            $row = $stmt->fetch();
            
            // display current info
            echo "<form method='post' action='editPet.php'>";
            echo "<table>";
            echo "<tbody>";
            echo "<tr><td>Pet name</td><td><input name='pet_name' type='text' value='$row[pet_name]' size='25' required></td></tr>";
            
            if ($row['birthdate'] != null) {
                echo "<tr><td>Birthdate</td><td><input name='birthdate' type='date' value='$row[birthdate]' min='1980-01-01' max=" . date('Y-m-d') . "></td></tr>";
            } else {
                echo "<tr><td>Birthdate</td><td><input name='birthdate' type='date' min='1910-01-01' max=" . date('Y-m-d') . "></td></tr>";
            }
            
            echo "<tr><td>Price</td><td><input name='price' type='number' min='0.01' max='99999.99' step='0.01' size='8' value='$row[price]' required></td></tr>";
            
            $stmt2 = $conn->prepare('select s_id from Store order by s_id;');
            $stmt2->execute();
            
            // make dropdown menu for store with current info automatically selected
            echo "<tr><td>Store</td><td>";
            echo "<select name='store'>";
            
            while ($s_row = $stmt2->fetch()) {
                
                if ($row['store'] == $s_row['s_id']) {
                    echo "<option value='$s_row[s_id]' selected>$s_row[s_id]</option>";
                } else {
                    echo "<option value='$s_row[s_id]'>$s_row[s_id]</option>";
                }
                
            }
            
            echo "</select>";
            echo "</td></tr>";
            
            // submit button
            echo "<tr><td></td><td><input type='submit' value='Submit'></td></tr>";
            echo "</tbody>";
            echo "</table>";
            echo "</form>";
            
            $_SESSION["editPet_p_id"] = $p_id; 
            
        } else { // after submitting form
            
            try {
                
                // update pet with edits
                $stmt = $conn->prepare("update Pet set pet_name = :pet_name, birthdate = :birthdate, price = :price, store = :store where p_id = :p_id;");
                
                $stmt->bindValue(':pet_name', trim($_POST['pet_name']));
                $stmt->bindValue(':price', $_POST['price']);
                $stmt->bindValue(':store', $_POST['store']);
                $stmt->bindValue(':p_id', $_SESSION["editPet_p_id"]);
                
                if($_POST['birthdate'] != "") {
                    $stmt->bindValue(':birthdate', $_POST['birthdate']);
                } else {
                    $stmt->bindValue(':birthdate', null, PDO::PARAM_STR);
                }
                
                $stmt->execute();
                
                echo "Successfully updated pet.";
                
            } catch (PDOException $e) {
                
                echo "Error: " . $e->getMessage();
            }
            
            unset ($_SESSION["editPet_p_id"]);
            
        }
        
        ?>
        
        <!-- click to get back to index -->
		<br><br><a href="index.php">Back to index</a>
		
	</body>
</html>