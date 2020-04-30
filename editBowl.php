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
		
		<h1>Update Bedding</h1>
	
        <?php
        
        require_once ('connection.php');
        
        session_start();
        
        // first page
        if (!isset($_GET['SN']) && $_SERVER['REQUEST_METHOD'] != 'POST') {
            
            $stmt = $conn->prepare('select SN,substrate,opening_diameter from Bowl order by SN;');
            $stmt->execute();
            
            // select an accessory to get to current related info
            echo "<form method='get'>";
            echo "Select Bowl:  ";
            echo "<select name='SN' onchange='this.form.submit();'>";
            echo "<option disabled selected value> -- select Bowl -- </option>";

            while ($row = $stmt->fetch()) {
                echo "<option value='$row[SN]'>$row[SN]: substrate: $row[substrate], opening diameter: $row[opening_diameter]</option>";
            }
            
            echo "</select>";
            echo "</form>";
            exit();
            
        }
        
        // second page - form
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            
            $SN = $_GET["SN"];
            
            // get related info from pk
            $stmt = $conn->prepare('select SN,substrate,opening_diameter from Bowl where SN = :SN;');
            $stmt->bindValue(':SN', $SN);
            
            $stmt->execute();
            
            $row = $stmt->fetch();
            
            // display current info
            echo "<form method='post' action='editBedding.php'>";
            echo "<table>";
            echo "<tbody>";
            echo "<tr><td>Serial Number</td><td><input name='SN' type='number' min='1' step='1' size='7'></td></tr>";
            echo "<tr><td>Substrate</td><td><input name='substrate' type='text' size='10'></td></tr>";
            echo "<tr><td>Opening Diameter</td><td><input name='opening_diameter' type='number' min='0 step='1' size='11'></td></tr>";
            
            
            echo "</select>";
            echo "</td></tr>";
            
            // submit button
            echo "<tr><td></td><td><input type='submit' value='Submit'></td></tr>";
            echo "</tbody>";
            echo "</table>";
            echo "</form>";
            
            $_SESSION["editBowl_SN"] = $SN; 
            
        } else { // after submitting form
            
            try {
                
                // update Bedding with edits
                $stmt = $conn->prepare("update Bowl set substrate = :substrate, opening_diameter = :opening_diameter, where SN = :SN;");
                
                $stmt->bindValue(':substrate', $_POST['substrate']);
                $stmt->bindValue(':opening_diameter', $_POST['opening_diameter']);
                $stmt->bindValue(':SN', $_SESSION["editBowl_SN"]);
                
                $stmt->execute();
                
                echo "Successfully updated Bowl.";
                
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            
            unset ($_SESSION["editBowl_SN"]);
            
        }
        
        ?>
        
        <!-- click to get back to index -->
		<br><br><a href="index.php">Back to index</a>
		
	</body>
</html>