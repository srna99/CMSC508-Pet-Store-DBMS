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
		
		<h1>Add New Customer</h1>
	
        <?php
        
        require_once ('connection.php');
        
        // first page
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            
            // make fill-in form for new customer
            echo "<form method='post' action='addCustomer.php'>";
            echo "<table>";
            echo "<tbody>";
            echo "<tr><td>First name</td><td><input name='first_name' type='text' size='25' required></td></tr>";
            echo "<tr><td>Last name</td><td><input name='last_name' type='text' size='25' required></td></tr>";
            echo "<tr><td>Email</td><td><input name='email' type='email' size='25'></td></tr>";
            echo "<tr><td>Birthdate</td><td><input name='birthdate' type='date' min='1910-01-01' max=" . date('Y-m-d') . " required></td></tr>";
            echo "<tr><td>Phone number</td><td><input name='phone_number' type='tel' pattern='[0-9]{3}-[0-9]{3}-[0-9]{4}'><br><small>Format: 123-456-7890</small></td></tr>";
            echo "<tr><td>Address</td><td><input name='address' type='text' size='25'></td></tr>";
            
            // submit form button
            echo "<tr><td></td><td><input type='submit' value='Submit'></td></tr>";
            
            echo "</tbody>";
            echo "</table>";
            echo "</form>";
            
        } else { // after user submitted form
            
            try {
                
                // insert into table
                $stmt = $conn->prepare("insert into Customer(first_name, last_name, email, birthdate, phone_number, address) values (:first_name, :last_name, :email, :birthdate, :phone_number, :address);");
                
                $stmt->bindValue(':first_name', trim($_POST['first_name']));
                $stmt->bindValue(':last_name', trim($_POST['last_name']));
                $stmt->bindValue(':birthdate', $_POST['birthdate']);
                
                if($_POST['email'] != "") {
                    $stmt->bindValue(':email', trim($_POST['email']));
                } else {
                    $stmt->bindValue(':email', null, PDO::PARAM_STR);
                }
                
                if($_POST['phone_number'] != "") {
                    $stmt->bindValue(':phone_number', trim($_POST['phone_number']));
                } else {
                    $stmt->bindValue(':phone_number', null, PDO::PARAM_STR);
                }
                
                if($_POST['address'] != "") {
                    $stmt->bindValue(':address', trim($_POST['address']));
                } else {
                    $stmt->bindValue(':address', null, PDO::PARAM_STR);
                }
                
                $stmt->execute();
                
                echo "Successfully added new customer.";
                
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            
        }
        
        ?>
        
        <!-- click to get back to index -->
		<br><br><a href="index.php">Back to index</a>
		
	</body>
</html>