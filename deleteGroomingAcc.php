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
		
		<h1>Delete Pet</h1>
	
        <?php
        
        require_once ('connection.php');
        
        // first page
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            
            $stmt = $conn->prepare('select SN, type_of, animal from Grooming_Accessory order by SN;');
            $stmt->execute();
            
            // make form for deleting grooming accessory
            echo "<form method='post' action='deleteGroomingAcc.php'>";
            echo "<table>";
            echo "<tbody>";
            echo "<tr><td>Select a grooming accessory</td><td>";
           
            // make dropdown menu
            echo "<select name='sn'>";
            
            // show info from query
            while ($row = $stmt->fetch()) {
                echo "<option value='$row[SN]'>$row[SN]: $row[type_of] for $row[animal]</option>";
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
                
                // delete from table
                $stmt = $conn->prepare("delete from Grooming_Accessory where SN = :sn;");
                
                $stmt->bindValue(':sn', $_POST['sn']);
                
                $stmt->execute();
                
                echo "Successfully deleted grooming accessory.";
                
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            
        }
        
        ?>
        
        <!-- click to get back to index -->
		<br><br><a href="index.php">Back to index</a>
		
	</body>
</html>