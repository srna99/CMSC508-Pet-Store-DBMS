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
		
		<h1>Edit A Company</h1>
	
        <?php
        
        require_once ('connection.php');
        
        session_start();
        
        // first page
        if (!isset($_GET['c_id']) && $_SERVER['REQUEST_METHOD'] != 'POST') {
            
            $stmt = $conn->prepare('select c_id, company_name, address from Company order by company_name;');
            $stmt->execute();
            
            // select a company to get to current related info
            echo "<form method='get'>";
            echo "Select a company:  ";
            
            // make dropdown menu for companies
            echo "<select name='c_id' onchange='this.form.submit();'>";
            echo "<option disabled selected value> -- select a company -- </option>";
            
            // show info from query
            while ($row = $stmt->fetch()) {
                echo "<option value='$row[c_id]'>$row[company_name] at $row[address]</option>";
            }
            
            echo "</select>";
            echo "</form>";
            exit();
            
        }
        
        // second page - form
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            
            $c_id = $_GET["c_id"];
            
            // get related info from pk
            $stmt = $conn->prepare('select company_name, address from Company where c_id = :c_id;');
            $stmt->bindValue(':c_id', $c_id);
            
            $stmt->execute();
            
            $row = $stmt->fetch();
            
            // display current info
            echo "<form method='post' action='editPet.php'>";
            echo "<table>";
            echo "<tbody>";
            echo "<tr><td>Company name</td><td><input name='company_name' type='text' size='25' value='$row[company_name]' required></td></tr>";
            echo "<tr><td>Address</td><td><input name='address' type='text' size='25' value='$row[address]' required></td></tr>";
            
            // submit button
            echo "<tr><td></td><td><input type='submit' value='Submit'></td></tr>";
            echo "</tbody>";
            echo "</table>";
            echo "</form>";
            
            $_SESSION["editCompany_c_id"] = $c_id; 
            
        } else { // after submitting form
            
            try {
                
                // update company with edits
                $stmt = $conn->prepare("update Company set company_name = :company_name, address = :address where c_id = :c_id;");
                
                $stmt->bindValue(':company_name', trim($_POST['company_name']));
                $stmt->bindValue(':address', trim($_POST['address']));
                $stmt->bindValue(':c_id', $_SESSION["editCompany_c_id"]);
                
                $stmt->execute();
                
                echo "Successfully updated company.";
                
            } catch (PDOException $e) {
                
                echo "Error: " . $e->getMessage();
            }
            
            unset ($_SESSION["editCompany_c_id"]);
            
        }
        
        ?>
        
        <!-- click to get back to index -->
		<br><br><a href="index.php">Back to index</a>
		
	</body>
</html>