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
		
		<h1>Add New Transaction</h1>
	
        <?php
        
        require_once ('connection.php');
        
        // first page
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            
            // make fill-in form for new transaction
            echo "<form method='post' action='addCustomerTransaction.php'>";
            echo "<table>";
            echo "<tbody>";
            echo "<tr><td>Customer</td><td>";
            
            $stmt = $conn->prepare('select c_id, first_name, last_name, birthdate from Customer order by first_name, last_name;');
            $stmt->execute();
            
            // get all customers
            echo "<select name='customer'>";
            
            while ($row = $stmt->fetch()) {
                echo "<option value='$row[c_id]'>$row[first_name] $row[last_name] (born $row[birthdate])</option>";
            }
            
            echo "</select>";
            echo "</td></tr>";
            
            $stmt = $conn->prepare('select p_id, pet_name, animal, store from Pet order by animal, pet_name, store;');
            $stmt->execute();
            
            // get all pets
            echo "<tr><td>Pet</td><td>";
            echo "<select name='pet'>";
            
            while ($row = $stmt->fetch()) {
                echo "<option value='$row[p_id]'>$row[pet_name] the $row[animal] at Store $row[store]</option>";
            }
            
            // submit form button
            echo "<tr><td></td><td><input type='submit' value='Submit'></td></tr>";
            
            echo "</tbody>";
            echo "</table>";
            echo "</form>";
            
        } else { // after user submitted form
            
            try {
                
                // insert into table
                $stmt = $conn->prepare("insert into Buys(customer, pet, date_bought) values (:c_id, :p_id, curdate());");
                
                $stmt->bindValue(':customer', $_POST['customer']);
                $stmt->bindValue(':pet', trim($_POST['pet']));
                
                $stmt->execute();
                
                echo "Successfully added new transaction.";
                
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            
        }
        
        ?>
        
        <!-- click to get back to index -->
		<br><br><a href="index.php">Back to index</a>
		
	</body>
</html>