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
		
		<h1>Edit a Customer</h1>
	
        <?php
        
        require_once ('connection.php');
        
        error_reporting(E_ALL ^ E_WARNING); 
        
        session_start();
        
        // first page
        if (!isset($_GET['c_id']) && $_SERVER['REQUEST_METHOD'] != 'POST') {
            
            $stmt = $conn->prepare('select c_id, first_name, last_name, birthdate from Customer order by first_name, last_name, birthdate;');
            $stmt->execute();
            
            // select a customer to get to current related info
            echo "<form method='get'>";
            echo "Select a pet:  ";
            
            // make dropdown menu for customer
            echo "<select name='c_id' onchange='this.form.submit();'>";
            echo "<option disabled selected value> -- select a customer -- </option>";
            
            // show info from query
            while ($row = $stmt->fetch()) {
                echo "<option value='$row[c_id]'>$row[first_name] $row[last_name] (born $row[birthdate])</option>";
            }
            
            echo "</select>";
            echo "</form>";
            exit();
            
        }
        
        // second page - form
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            
            $c_id = $_GET["c_id"];
            
            // get related info from pk
            $stmt = $conn->prepare('select first_name, last_name, email, phone_number, address from Customer where c_id = :c_id;');
            $stmt->bindValue(':c_id', $c_id);
            
            $stmt->execute();
            
            $row = $stmt->fetch();
            
            // display current info
            echo "<form method='post' action='editCustomer.php'>";
            echo "<table>";
            echo "<tbody>";
            echo "<tr><td>First name</td><td><input name='first_name' type='text' value='$row[first_name]' size='25' required></td></tr>";
            echo "<tr><td>Last name</td><td><input name='last_name' type='text' value='$row[last_name]' size='25' required></td></tr>";
            
            if ($row[email] != null) {
                echo "<tr><td>Email</td><td><input name='email' type='email' value='$row[email]' size='25'></td></tr>";
            } else {
                echo "<tr><td>Email</td><td><input name='email' type='email' size='25'></td></tr>";
            }
            
            if ($row[phone_number] != null) {
                echo "<tr><td>Phone number</td><td><input name='phone_number' type='tel' pattern='[0-9]{3}-[0-9]{3}-[0-9]{4}' value='$row[phone_number]'>";
            } else {
                echo "<tr><td>Phone number</td><td><input name='phone_number' type='tel' pattern='[0-9]{3}-[0-9]{3}-[0-9]{4}'>";
            }
            echo "<br><small>Format: 123-456-7890</small></td></tr>";
            
            if ($row[address] != null) {
                echo "<tr><td>Address</td><td><input name='address' type='text' value='$row[address]' size='25'></td></tr>";
            } else {
                echo "<tr><td>Address</td><td><input name='address' type='text' size='25'></td></tr>";
            }
 
            // submit button
            echo "<tr><td></td><td><input type='submit' value='Submit'></td></tr>";
            echo "</tbody>";
            echo "</table>";
            echo "</form>";
            
            $_SESSION["editCustomer_c_id"] = $c_id; 
            
        } else { // after submitting form
            
            try {
                
                // update pet with edits
                $stmt = $conn->prepare("update Customer set first_name = :first_name, last_name = :last_name, email = :email, phone_number = :phone_number, address = :address where c_id = :c_id;");
                
                $stmt->bindValue(':first_name', trim($_POST['first_name']));
                $stmt->bindValue(':last_name', trim($_POST['last_name']));
                $stmt->bindValue(':c_id', $_SESSION["editCustomer_c_id"]);
                
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
                
                echo "Successfully updated customer.";
                
            } catch (PDOException $e) {
                
                echo "Error: " . $e->getMessage();
            }
            
            unset ($_SESSION["editPet_p_id"]);
            
        }
        
        ?>
        
        <!-- click to get back to index -->
		<br><br><a href="index.php">Back to index</a>
		
	</body>
</html>