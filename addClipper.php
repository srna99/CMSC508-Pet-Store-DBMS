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
		
		<h1>Add New Clipper</h1>
	
        <?php
        
        require_once ('connection.php');
        
        // first page
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            
            // make fill-in form for new clipper
            echo "<form method='post' action='addClipper.php'>";
            echo "<table>";
            echo "<tbody>";
            echo "<tr><td>SN</td><td><input name='sn' type='number' min='1' max='99999' step='1' size='8' required></td></tr>";
            echo "<tr><td>Size (in inches)</td><td><input name='size' type='number' min='0.001' max='1.25' step='0.001' size='8' value='1.0' required></td></tr>";
            
            echo "<tr><td>Guard</td><td>";
            echo "<select name='guard'>";
            
            while ($row = $stmt->fetch()) {
                echo "<option value='-1'>No guard</option>";
                echo "<option value='#1'>#1</option>";
                echo "<option value='#2'>#2</option>";
                echo "<option value='#3'>#3</option>";
                echo "<option value='#4'>#4</option>";
                echo "<option value='#5'>#5</option>";
                echo "<option value='#6'>#6</option>";
                echo "<option value='#7'>#7</option>";
                echo "<option value='#8'>#8</option>";
            }
            
            echo "</select>";
            echo "</td></tr>";
            
            echo "<tr><td>Brand</td><td><input name='brand' type='text' size='25' required></td></tr>";
            
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
            
            // submit form button
            echo "<tr><td></td><td><input type='submit' value='Submit'></td></tr>";
            
            echo "</tbody>";
            echo "</table>";
            echo "</form>";
            
        } else { // after user submitted form
            
            try {
                
                // insert into table
                $stmt = $conn->prepare("insert into Clipper(SN, size, guard, brand, animal) values (:sn, :size, :guard, :brand, :animal);");
                
                $stmt->bindValue(':sn', $_POST['sn']);
                $stmt->bindValue(':size', $_POST['size']);
                $stmt->bindValue(':brand', trim($_POST['brand']));
                $stmt->bindValue(':animal', $_POST['animal']);
                
                if($_POST['guard'] != -1) {
                    $stmt->bindValue(':guard', $_POST['guard']);
                } else {
                    $stmt->bindValue(':guard', null, PDO::PARAM_STR);
                }
                
                $stmt->execute();
                
                echo "Successfully added new clipper.";
                
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            
        }
        
        ?>
        
        <!-- click to get back to index -->
		<br><br><a href="index.php">Back to index</a>
		
	</body>
</html>