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
		
		<h1>Delete Animal to Habitat Connection</h1>
	
        <?php
        
        require_once ('connection.php');

        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            
            // make fill-in form
            $stmt = $conn->prepare('select animal,habitat from Lives_In order by animal,habitat;');
            $stmt->execute();
            
            echo "<form method='post' action='deleteLivesIn.php'>";
            echo "<table>";
            echo "<tbody>";

            echo "<tr><td>Tank Filter</td><td>";
            // make dropdown menu
            echo "<select name='livesIn'>";
            echo "<option disabled selected value> -- select Lives in -- </option>";
            while ($row = $stmt->fetch()) {
                echo "<option value='$row[animal] $row[habitat]'>Animal: $row[animal] Habitat: $row[habitat] </option>";
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
                $stmt = $conn->prepare("delete from Lives_In where animal = :animal and habitat = :habitat;");
                
                $Lives_in = explode(" ", $_POST['livesIn']);

                $stmt->bindValue(':animal', $Lives_in[0]);
                $stmt->bindValue(':habitat', $Lives_in[1]);
                
                $stmt->execute();
                
                echo "Successfully deleted Lives In Entry.";
                
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            
        }
        
        ?>
        
        <!-- click to get back to index -->
		<br><br><a href="index.php">Back to index</a>
		
	</body>
</html>