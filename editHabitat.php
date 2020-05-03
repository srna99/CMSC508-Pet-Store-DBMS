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
		
		<h1>Edit an Habitat</h1>
	
        <?php
        
        require_once ('connection.php');
        
        error_reporting(E_ALL ^ E_WARNING); 
        
        session_start();
        
        // first page
        if (!isset($_GET['type']) && $_SERVER['REQUEST_METHOD'] != 'POST') {
            
            // $stmt = $conn->prepare('select Habitat.SN, volume, capacity, price, quantity,IFNULL(light,"N/A"),IFNULL(NULLIF(concat(IFNULL(Bowl.substrate,""),IFNULL(Tank.substrate,"")),""),"No Substrate") as substrate,IFNULL(opening_diameter,"N/A"),type_of from Habitat Left join Bowl on Habitat.SN = Bowl.SN left join Tank on Habitat.SN = Tank.SN left join Cage on Habitat.SN = Cage.SN group by SN order by SN;');
            // $stmt->execute();
            
            // select a Habitat to get to current related info
            echo "<form method='get'>";
            echo "Select an Habitat:  ";
            
            // make dropdown menu for Habitat
            echo "<select name='type' onchange='this.form.submit();'>";
            echo "<option disabled selected value> -- select an Habitat type -- </option>";
            echo "<option value='Bowl'>Bowl</option>";
            echo "<option value='Cage'>Cage</option>";
            echo "<option value='Tank'>Tank</option>";
            
            echo "</select>";
            echo "</form>";
            exit();
            
        }
        // if($_SERVER['REQUEST_METHOD'] != 'POST') {
        //     // show info from query
        //     // while ($row = $stmt->fetch()) {
        //     //     echo "<option value='$row[SN]'>$row[type_of] Volume: $row[volume] Capacity: $row[capacity] Price: $row[price] Light SN: $row[light] Opening Diameter: $row[opening_diameter]</option>";
        //     // }
        //     $stmt = $conn->prepare('select Habitat.SN, volume, capacity, price, quantity,IFNULL(light,"N/A"),IFNULL(NULLIF(concat(IFNULL(Bowl.substrate,""),IFNULL(Tank.substrate,"")),""),"No Substrate") as substrate,IFNULL(opening_diameter,"N/A"),type_of from Habitat Left join Bowl on Habitat.SN = Bowl.SN left join Tank on Habitat.SN = Tank.SN left join Cage on Habitat.SN = Cage.SN group by SN order by SN;');
        //     $stmt->execute();

        //     $type = $_GET["type"];

        //     echo "<select name='SN' onchange='this.form.submit();'>";
        //     echo "<option disabled selected value> -- select an Habitat -- </option>";
     
        //     if($type == "Bowl"){
        //         while ($row = $stmt->fetch()) {
        //             echo "<option value='$row[SN]'>$row[type_of] Volume: $row[volume] Capacity: $row[capacity] Price: $row[price] </option>";
        //         }
        //     }

        //     if($type == "Cage"){
        //         while ($row = $stmt->fetch()) {
        //             echo "<option value='$row[SN]'>Opening Diameter: $row[opening_diameter] Volume: $row[volume] Capacity: $row[capacity] Price: $row[price] </option>";
        //         }
        //     }

        //     if($type == "Tank"){
        //         while ($row = $stmt->fetch()) {
        //             echo "<option value='$row[SN]'>Light SN: $row[light] Volume: $row[volume] Capacity: $row[capacity] Price: $row[price] </option>";
        //         }
        //     }
            
        //     echo "</select>";
        //     echo "</form>";
        //     exit();
            
        // }
        
        // second page - form
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            
            $SN = $_GET["SN"];
            $stmt = $conn->prepare('select Habitat.SN, volume, capacity, price, quantity,IFNULL(light,"N/A"),IFNULL(NULLIF(concat(IFNULL(Bowl.substrate,""),IFNULL(Tank.substrate,"")),""),"No Substrate") as substrate,IFNULL(opening_diameter,"N/A"),type_of from Habitat Left join Bowl on Habitat.SN = Bowl.SN left join Tank on Habitat.SN = Tank.SN left join Cage on Habitat.SN = Cage.SN group by SN order by SN;');
            $stmt->execute();

            $type = $_GET["type"];

            echo "<select name='SN' onchange='this.form.submit();'>";
            echo "<option disabled selected value> -- select an Habitat -- </option>";
     
            if($type == "Bowl"){
                while ($row = $stmt->fetch()) {
                    echo "<option value='$row[SN]'>$row[type_of] Volume: $row[volume] Capacity: $row[capacity] Price: $row[price] </option>";
                }
            }

            if($type == "Cage"){
                while ($row = $stmt->fetch()) {
                    echo "<option value='$row[SN]'>Opening Diameter: $row[opening_diameter] Volume: $row[volume] Capacity: $row[capacity] Price: $row[price] </option>";
                }
            }

            if($type == "Tank"){
                while ($row = $stmt->fetch()) {
                    echo "<option value='$row[SN]'>Light SN: $row[light] Volume: $row[volume] Capacity: $row[capacity] Price: $row[price] </option>";
                }
            }
            
            echo "</select>";
            echo "</form>";
            // get related info from pk
            $stmt = $conn->prepare('select SN, volume, capacity, price, quantity from Habitat where SN = :SN;');
            $stmt->bindValue(':SN', $SN);
            
            $stmt->execute();
            
            $row = $stmt->fetch();
            
            // display current info
            echo "<form method='post' action='editHabitat.php'>";
            echo "<table>";
            echo "<tbody>";
            echo "<tr><td>Serial Number</td><td><input name='SN' type='number' min='1' step='1' size='7' required></td></tr>";
            echo "<tr><td>Volume</td><td><input name='volume' type='number' min='1' step='1' size='11' required></td></tr>";
            echo "<tr><td>Capacity</td><td><input name='capacity' type='number' min='1' max='5000' step='1' size='11' required></td></tr>";
            echo "<tr><td>Price</td><td><input name='price' type='number' min='0.01' max='999999.99' step='0.01' size='8' value='0.00' required></td></tr>";
            echo "<tr><td>Quantity</td><td><input name='quantity' type='number' min='1' max='5000' step='1' size='11' required></td></tr>";
            
            echo "</select>";
            echo "</td></tr>";
            
            $stmt = $conn->prepare("select
                                    	case
                                    		when :SN in (select SN from Bowl) then 1
                                    		when :SN in (select SN from Cage) then 2
                                    		when :SN in (select SN from Tank) then 3
                                    		else 0
                                    	end as habitat_type;");
            $stmt->bindValue(':SN', $SN);
            $stmt->execute();
            
            $row = $stmt->fetch();
            
            $_SESSION["editHabitat_habitat_type"] = $type;
            
            switch ($_SESSION["editHabitat_habitat_type"]) {
                
                case 1:
                    
                    echo "<tr><td>Opening Diameter</td><td><input name='opening_diameter' type='number' min='1' max='5000' step='1' size='11' required></td></tr>";
                    echo "<tr><td>Substrate</td><td>";
                    echo "<select name='substrate'>";
                    echo "<option disabled selected value> -- select an Substrate type -- </option>";
                    echo "<option value='sand'>Sand</option>";
                    echo "<option value='gravel'>Gravel</option>";
                    echo "<option value='dirt'>Dirt</option>";
                    echo "<option value='marble'>Marble</option>";
                    echo "<option value='artificial'>Artificial</option>";                    
                    echo "</select></td></tr>";
                    
                    break;
                    
                case 2:
                    
                    echo "<tr><td>Type Of</td><td><input name='type_of' type='text' size='15' required></td></tr>";
                    echo "</select>";
                    echo "</td></tr>";
                    
                    break;
                    
                case 3:
                    
                    echo "<tr><td>Substrate</td><td>";
                    echo "<select name='substrate'>";
                    echo "<option disabled selected value> -- select an Substrate type -- </option>";
                    echo "<option value='sand'>Sand</option>";
                    echo "<option value='gravel'>Gravel</option>";
                    echo "<option value='dirt'>Dirt</option>";
                    echo "<option value='marble'>Marble</option>";
                    echo "<option value='artificial'>Artificial</option>";

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
                    

                    
                    break;
                    
                default:
                    break;
                    
            }
 
            // submit button
            echo "<tr><td></td><td><input type='submit' value='Submit'></td></tr>";
            echo "</tbody>";
            echo "</table>";
            echo "</form>";
            
            $_SESSION["editHabitat_SN"] = $SN; 
            
        } else { // after submitting form
            
            try {
                
                // update Habitat with edits
                $stmt = $conn->prepare("update Habitat set volume = :volume, capacity = :capacity, price = :price, quantity = :quantity where SN = :SN;");
                
                $stmt->bindValue(':SN', trim($_POST['editHabitat_SN']));
                $stmt->bindValue(':volume', trim($_POST['volume']));
                $stmt->bindValue(':capacity', $_SESSION["capacity"]);
                $stmt->bindValue(':price', $_POST['price']);
                $stmt->bindValue(':quantity', $_POST['quantity']);
                
                
                $stmt->execute();
                
                switch ($_SESSION["editHabitat_habitat_type"]) {
                    
                    case 1:
                        
                        $stmt = $conn->prepare("update Bowl set substrate = :substrate, opening_diameter = :opening_diameter where SN = :SN;");
                        $stmt->bindValue(':SN', $_SESSION["editHabitat_SN"]);
                        $stmt->bindValue(':substrate', $_POST['substrate']);
                        $stmt->bindValue(':opening_diameter', $_POST['opening_diameter']);
                        $stmt->execute();
                        
                        break;
                        
                    case 2:
                        
                        $stmt = $conn->prepare("update Cage set type_of = :type_of where SN = :SN;");
                        $stmt->bindValue(':SN', $_SESSION["editHabitat_SN"]);
                        $stmt->bindValue(':type_of', $_SESSION["type_of"]);
                        
                        $stmt->execute();
                        
                        break;
                        
                    case 3:
                        
                        $stmt = $conn->prepare("update Tank set substrate = :substrate, light = :light where SN = :SN;");
                        $stmt->bindValue(':SN', $_SESSION["editHabitat_SN"]);
                        $stmt->bindValue(':substrate', $_POST['substrate']);
                        $stmt->bindValue(':light', $_POST['light']);
                        
                        $stmt->execute();
                        
                        break;
                        
                    default:
                        break;
                        
                }
                
                echo "Successfully updated Habitat.";
                
            } catch (PDOException $e) {
                
                echo "Error: " . $e->getMessage();
            }
            
            unset ($_SESSION["editHabitat_SN"]);
            unset ($_SESSION["editHabitat_habitat_type"]);
            
        }
        
        ?>
        
        <!-- click to get back to index -->
		<br><br><a href="index.php">Back to index</a>
		
	</body>
</html>