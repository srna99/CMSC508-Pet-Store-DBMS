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
		
		<h1>Add New Habitat</h1>
	
        <?php
        
        require_once ('connection.php');
        
        session_start();
        
        // first page
        if (!isset($_GET['type']) && $_SERVER['REQUEST_METHOD'] != 'POST') {
            
            echo "<form method='get'>";
            echo "Select a type of Habitat:  ";
            
            // make dropdown menu for Habitat types
            echo "<select name='type' onchange='this.form.submit();'>";
            echo "<option disabled selected value> -- select an Habitat type -- </option>";
            echo "<option value='General'>General</option>";
            echo "<option value='Bowl'>Bowl</option>";
            echo "<option value='Cage'>Cage</option>";
            echo "<option value='Tank'>Tank</option>";
            echo "</select>";
            echo "</form>";
            exit();
            
        }
        
        // second page - form
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            
            $type = $_GET["type"];
            
            // make fill-in form for new Habitat
            echo "<form method='post' action='addHabitat.php'>";
            echo "<table>";
            echo "<tbody>";
            echo "<tr><td>Serial Number</td><td><input name='SN' type='number' min='1' step='1' size='7' required></td></tr>";
            echo "<tr><td>Volume</td><td><input name='volume' type='number' min='1' step='1' size='11' required></td></tr>";
            echo "<tr><td>Capacity</td><td><input name='capacity' type='number' min='1' max='5000' step='1' size='11' required></td></tr>";
            echo "<tr><td>Salary</td><td><input name='price' type='number' min='0.01' max='999999.99' step='0.01' size='8' value='0.00' required></td></tr>";
            echo "<tr><td>Quantity</td><td><input name='quantity' type='number' min='1' max='5000' step='1' size='11' required></td></tr>";
            

            
            echo "</select>";
            echo "</td></tr>";
            
            if ($type == "Bowl") {
                
                echo "<option value='SN'>Serial Number</option>";
                echo "<option value='substrate'>Substrate</option>";
                echo "<option value='opening_diameter'>Opening Diameter</option>";
                echo "</select></td></tr>";
                
                
            } 
            elseif ($type == "Cage") {
                
                echo "<option value='SN'>Serial Number</option>";
                echo "<option value='type_of'>Type Of</option>";
                echo "</select>";
                echo "</td></tr>";
                                        
                
            }
            elseif ($type == "Tank") {
                
                echo "<option value='SN'>Serial Number</option>";
                echo "<option value='substrate'>substrate</option>";

                $stmt = $conn->prepare('select SN, brand, size from Light order by SN;');
                $stmt->execute();
                
                // make dropdown menu for manager
                echo "<tr><td>Light</td><td>";
                echo "<select name='light'>";
                
                while ($row = $stmt->fetch()) {
                    echo "<option value='$row[SN]'>$row[SN]: Size: $row[size] Brand $row[brand]</option>";
                }                 
                echo "</select>";
                echo "</td></tr>";
                                    
            }
            
            // submit form button
            echo "<tr><td></td><td><input type='submit' value='Submit'></td></tr>";
            
            echo "</tbody>";
            echo "</table>";
            echo "</form>";
            
            $_SESSION["addHabitat_type"] = $type; 
            
        } 
        else { // after user submitted form
            
            try {
                
                // insert into Habitat table
                $stmt = $conn->prepare("insert into Habitat(SN, volume, capacity, price, quantity) values (:SN, :volume, :capacity, :price, :quantity);");
               
                $stmt->bindValue(':SN', trim($_POST['SN']));
                $stmt->bindValue(':volume', trim($_POST['volume']));
                $stmt->bindValue(':capacity', trim($_POST['capacity']));
                $stmt->bindValue(':price', $_POST['price']);
                $stmt->bindValue(':quantity', $_POST['quantity']);
                
                $stmt->execute();
                
                // get last inserted sn
                $_SESSION["addHabitat_prev_id"] = $conn->lastInsertId();
                

                // insert into appropriate tables
                if ($_SESSION["addHabitat_type"] == "Bowl") {
                    
                    $b_stmt = $conn->prepare("insert into Cashier(SN,substrate,opening_diameter) values (:prev_id, :substrate, :opening_diameter);");
                    
                    $b_stmt->bindValue(':prev_id', $_SESSION["addHabitat_prev_id"]);
                    $b_stmt->bindValue(':substrate', $_POST['substrate']);
                    $b_stmt->bindValue(':opening_diameter', $_POST['opening_diameter']);

                    $b_stmt->execute();
                    
                } 
                elseif ($_SESSION["addHabitat_type"] == "Cage") {
                    
                    $c_stmt = $conn->prepare("insert into Cage (type_of) values (:type_of);");
                    $c_stmt->bindValue(':type_of', $_POST['type_of']);
                    $c_stmt2->bindValue(':prev_id', $_SESSION["addHabitat_prev_id"]);

                    $c_stmt->execute();
                                        
                } 
                elseif ($_SESSION["addHabitat_type"] == "Tank") {
                    
                    $t_stmt = $conn->prepare("insert into Stocker(SN, light, substrate) values (:prev_id, :substrate, :product_to_stock);");
                    
                    $t_stmt->bindValue(':prev_id', $_SESSION["addHabitat_prev_id"]);
                    $t_stmt->bindValue(':light', $_POST['light']);
                    $t_stmt->bindValue(':substrate', $_POST['substrate']);

                    
                    $t_stmt->execute();
                    
                } 
                
                echo "Successfully added new Habitat.";
                
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            
            unset ($_SESSION["addHabitat_type"]);
            unset ($_SESSION["addHabitat_prev_id"]);
            
        }
        
        ?>
        
        <!-- click to get back to index -->
		<br><br><a href="index.php">Back to index</a>
		
	</body>
</html>