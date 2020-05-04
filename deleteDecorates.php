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
		
		<h1>Delete Decor for Habitat</h1>
	
        <?php
        
        require_once ('connection.php');

        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            
            // make fill-in form
            $stmt = $conn->prepare('select habitat,decor from Decorates order by decor,habitat;');
            $stmt->execute();
            
            echo "<form method='post' action='deleteDecorates.php'>";
            echo "<table>";
            echo "<tbody>";

            echo "<tr><td>Decorates</td><td>";
            // make dropdown menu
            echo "<select name='Decorates'>";
            echo "<option disabled selected value> -- select decor for habitat -- </option>";
            while ($row = $stmt->fetch()) {
                echo "<option value='$row[habitat] $row[decor]'>Habitat: $row[habitat] decor: $row[decor]</option>";
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
                $stmt = $conn->prepare("delete from Decorates where habitat = :habitat and decor = :decor;");
                
                $Decor = explode(" ", $_POST['Decorates']);

                $stmt->bindValue(':habitat', $Decor[0]);
                $stmt->bindValue(':decor', $Decor[1]);
                
                $stmt->execute();
                
                echo "Successfully deleted decor Entry.";
                
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            
        }
        
        ?>
        
        <!-- click to get back to index -->
		<br><br><a href="index.php">Back to index</a>
		
	</body>
</html>