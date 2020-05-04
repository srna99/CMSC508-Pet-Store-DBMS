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
		
		<h1>Delete Bedding</h1>
	
        <?php
        
        require_once ('connection.php');

        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            
            $stmt = $conn->prepare('select SN,brand,animal from Bedding order by SN;');
            $stmt->execute();
            
            echo "<form method='post' action='deleteBedding.php'>";
            echo "<table>";
            echo "<tbody>";
            echo "<tr><td>Select a Bedding</td><td>";
           
            // make dropdown menu
            echo "<select name='SN'>";
            echo "<option disabled selected value> -- select Bedding -- </option>";
            while ($row = $stmt->fetch()) {
                echo "<option value='$row[SN]'>$row[SN]: $row[brand] for $row[animal]</option>";
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
                $stmt = $conn->prepare("delete from Bedding where SN = :SN;");
                
                $stmt->bindValue(':SN', $_POST['SN']);
                
                $stmt->execute();
                
                echo "Successfully deleted Bedding.";
                
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            
        }
        
        ?>
        
        <!-- click to get back to index -->
		<br><br><a href="index.php">Back to index</a>
		
	</body>
</html>