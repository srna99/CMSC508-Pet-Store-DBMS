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
		
		<h1>Add New Donation Received</h1>
	
        <?php
        
        require_once ('connection.php');
        
        // first page
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            
            // make fill-in form for new donation
            echo "<form method='post' action='addDonation.php'>";
            echo "<table>";
            echo "<tbody>";
            echo "<tr><td>From company</td><td>";
            
            $stmt = $conn->prepare('select c_id, company_name, address from Company order by company_name;');
            $stmt->execute();
            
            // get all companies
            echo "<select name='company'>";
            
            while ($row = $stmt->fetch()) {
                echo "<option value='$row[c_id]'>$row[company_name] at $row[address]</option>";
            }
            
            echo "</select>";
            echo "</td></tr>";
            
            echo "<tr><td>Store</td><td>";
            
            $stmt = $conn->prepare('select s_id from Store order by s_id;');
            $stmt->execute();
            
            // get all stores
            echo "<select name='store'>";
            
            while ($row = $stmt->fetch()) {
                echo "<option value='$row[s_id]'>$row[s_id]</option>";
            }
            
            echo "</select>";
            echo "</td></tr>";
            
            echo "<tr><td>Amount</td><td><input name='amount' type='number' min='0.01' max='9999999.99' step='0.01' size='8' value='0.00' required></td></tr>";
            echo "<tr><td>Date received</td><td><input name='date_donated' type='date' min='1910-01-01' max=" . date('Y-m-d') . " required></td></tr>";
            
            // submit form button
            echo "<tr><td></td><td><input type='submit' value='Submit'></td></tr>";
            
            echo "</tbody>";
            echo "</table>";
            echo "</form>";
            
        } else { // after user submitted form
            
            try {
                
                // insert into table
                $stmt = $conn->prepare("insert into Donates(company, store, amount, date_donated) values (:company, :store, :amount, :date_donated);");
                
                $stmt->bindValue(':company', $_POST['company']);
                $stmt->bindValue(':store', $_POST['store']);
                $stmt->bindValue(':amount', $_POST['amount']);
                $stmt->bindValue(':date_donated', $_POST['date_donated']);
                
                $stmt->execute();
                
                echo "Successfully added new donation.";
                
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            
        }
        
        ?>
        
        <!-- click to get back to index -->
		<br><br><a href="index.php">Back to index</a>
		
	</body>
</html>