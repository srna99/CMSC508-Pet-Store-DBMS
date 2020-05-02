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
		
		<h1>Disassociate A Representative From Store</h1>
	
        <?php
        
        require_once ('connection.php');
        
        // first page
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            
            $stmt = $conn->prepare('select store, r.r_id as r_id, concat(r.first_name, " ", r.last_name) as representative, (select shelter_name from Shelter where s_id = r.shelter) as shelter from Send_To s left join Representative r on s.representative =r.r_id order by store, representative;');
            $stmt->execute();
            
            // make form for deleting rep
            echo "<form method='post' action='deleteSendRepresentative.php'>";
            echo "<table>";
            echo "<tbody>";
            echo "<tr><td>Select an associated representative</td><td>";
           
            // make dropdown menu for rep
            echo "<select name='rep_store'>";
            
            // show info from query
            while ($row = $stmt->fetch()) {
                echo "<option value='$row[r_id] $row[store]'>$row[representative] from $row[shelter] at Store $row[store]</option>";
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
                $stmt = $conn->prepare("delete from Send_To where representative = :r_id and store = :s_id;");
                
                $rep_store = explode(" ", $_POST['rep_store']);
                
                $stmt->bindValue(':r_id', $rep_store[0]);
                $stmt->bindValue(':s_id', $rep_store[1]);
                
                $stmt->execute();
                
                echo "Successfully disassociated representative from store.";
                
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            
        }
        
        ?>
        
        <!-- click to get back to index -->
		<br><br><a href="index.php">Back to index</a>
		
	</body>
</html>