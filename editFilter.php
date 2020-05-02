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
		
		<h1>Update Filter</h1>
	
        <?php
        
        require_once ('connection.php');
        
        session_start();
        
        // first page
        if (!isset($_GET['SN']) && $_SERVER['REQUEST_METHOD'] != 'POST') {
            
            $stmt = $conn->prepare('select SN,brand,size,type_of from Filter order by SN;');
            $stmt->execute();
            
            // select an accessory to get to current related info
            echo "<form method='get'>";
            echo "Select Filter:  ";
            echo "<select name='SN' onchange='this.form.submit();'>";
            echo "<option disabled selected value> -- select Filter -- </option>";

            while ($row = $stmt->fetch()) {
                echo "<option value='$row[SN]'>$row[SN]: $row[type_of] brand: $row[brand] Size: $row[size] </option>";
            }
            
            echo "</select>";
            echo "</form>";
            exit();
            
        }
        
        // second page - form
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            
            $SN = $_GET["SN"];
            
            // get related info from pk
            $stmt = $conn->prepare('select SN,brand,size,type_of from Filter where SN = :SN;');
            $stmt->bindValue(':SN', $SN);
            
            $stmt->execute();
            
            $row = $stmt->fetch();
            
            // display current info
            echo "<form method='post' action='editFilter.php'>";
            echo "<table>";
            echo "<tbody>";
            echo "<tr><td>SN</td><td><input name='SN' type='number' min='1' step='1' size='7'></td></tr>";
            echo "<tr><td>Brand</td><td><input name='brand' type='text' size='20'></td></tr>";
            echo "<tr><td>Size</td><td><input name='size' type='number' min='1' step='1' size='11'></td></tr>";
            echo "<tr><td>Type</td><td><input name='type_of' type='text' size='10'></td></tr>";
            
            echo "</select>";
            echo "</td></tr>";
            
            // submit button
            echo "<tr><td></td><td><input type='submit' value='Submit'></td></tr>";
            echo "</tbody>";
            echo "</table>";
            echo "</form>";
            
            $_SESSION["editFilter_SN"] = $SN; 
            
        } else { // after submitting form
            
            try {
                
                // update Filter with edits
                $stmt = $conn->prepare("update Filter set brand = :brand, size = :size, type_of = :type_of where SN = :SN;");
                
                $stmt->bindValue(':brand', $_POST['brand']);
                $stmt->bindValue(':size', $_POST['size']);
                $stmt->bindValue(':type_of', $_POST['type_of']);
                $stmt->bindValue(':SN', $_SESSION["editFilter_SN"]);
                
                $stmt->execute();
                
                echo "Successfully updated Filter.";
                
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            
            unset ($_SESSION["editFilter_SN"]);
            
        }
        
        ?>
        
        <!-- click to get back to index -->
		<br><br><a href="index.php">Back to index</a>
		
	</body>
</html>