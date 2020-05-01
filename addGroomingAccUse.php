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
		
		<h1>Add New Grooming Accessory Usage Record</h1>
	
        <?php
        
        require_once ('connection.php');
        
        // first page
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            
            // make fill-in form
            echo "<form method='post' action='addGroomingAccUse.php'>";
            echo "<table>";
            echo "<tbody>";
            echo "<tr><td>Groomer</td><td>";
            
            $stmt = $conn->prepare('select e_id, concat(first_name, " ", last_name) as name, store from Employee where e_id in (select e_id from Groomer);');
            $stmt->execute();
            
            // get all groomers
            echo "<select name='groomer'>";
            
            while ($row = $stmt->fetch()) {
                echo "<option value='$row[e_id]'>$row[name] at Store $row[store]</option>";
            }
            
            echo "</select>";
            echo "</td></tr>";
            
            echo "<tr><td>Grooming Accessory</td><td>";
            
            $stmt = $conn->prepare('select SN, type_of, animal from Grooming_Accessory order by SN;');
            $stmt->execute();
            
            // get all grooming acc
            echo "<select name='grooming_acc'>";
            
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
                
                // insert into table
                $stmt = $conn->prepare("insert into Groomer_Grooming_Acc values (:groomer, :grooming_acc, now());");
                
                $stmt->bindValue(':groomer', $_POST['groomer']);
                $stmt->bindValue(':grooming_acc', $_POST['grooming_acc']);
                
                $stmt->execute();
                
                echo "Successfully added new groomer accessory usage record.";
                
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            
        }
        
        ?>
        
        <!-- click to get back to index -->
		<br><br><a href="index.php">Back to index</a>
		
	</body>
</html>