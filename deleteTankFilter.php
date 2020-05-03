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
            
            // make fill-in form
            echo "<form method='post' action='deleteTankFilter.php'>";
            echo "<table>";
            echo "<tbody>";
            
            $stmt = $conn->prepare('select SN, light, substrate from Tank order by SN;');
            $stmt->execute();
            
            // get all tanks
            echo "<tr><td>Tank</td><td>";
            echo "<select name='tank'>";
            
            while ($row = $stmt->fetch()) {
                echo "<option value='$row[SN]'>$row[SN]: Substrate: $row[substrate] Light: $row[light]</option>";
            }
            
            echo "</select>";
            echo "</td></tr>";

            echo "<tr><td>Filter</td><td>";
            
            $stmt = $conn->prepare('select SN,type_of,brand,size from Filter order by SN;');
            $stmt->execute();
            
            // get all filters
            echo "<select name='filter'>";
            
            while ($row = $stmt->fetch()) {
                echo "<option value='$row[SN]'>$row[SN]: $row[type_of] filter from $row[brand] size: $row[size]</option>";
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
                $stmt = $conn->prepare("delete from Tank_Filter where tank = :tank,filter = :filter;");
                
                $stmt->bindValue(':tank', $_POST['tank']);
                $stmt->bindValue(':filter', $_POST['filter']);
                
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