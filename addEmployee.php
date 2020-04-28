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
		
		<h1>Add New Employee</h1>
	
        <?php
        
        require_once ('connection.php');
        
        // first page
        if (!isset($_GET['type']) && $_SERVER['REQUEST_METHOD'] != 'POST') {
            
            echo "<form method='get'>";
            echo "Select a type of employee:  ";
            
            // make dropdown menu for employee types
            echo "<select name='type' onchange='this.form.submit();'>";
            echo "<option disabled selected value> -- select an employee type -- </option>";
            echo "<option value='General'>General</option>";
            echo "<option value='Cashier'>Cashier</option>";
            echo "<option value='Groomer'>Groomer</option>";
            echo "<option value='Stocker'>Stocker</option>";
            echo "<option value='Trainer'>Trainer</option>";
            echo "</select>";
            echo "</form>";
            exit();
            
        }
        
        // second page - form
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            
            $type = $_GET["type"];
            
            // make fill-in form for new employee
            echo "<form method='post' action='addEmployee.php'>";
            echo "<table>";
            echo "<tbody>";
            echo "<tr><td>First name</td><td><input name='first_name' type='text' size='25' required></td></tr>";
            echo "<tr><td>Last name</td><td><input name='last_name' type='text' size='25' required></td></tr>";
            echo "<tr><td>Salary</td><td><input name='salary' type='number' min='0.01' max='999999.99' step='0.01' size='8' value='0.00' required></td></tr>";
            echo "<tr><td>Birthdate</td><td><input name='birthdate' type='date' min='1910-01-01' max=" . date('Y-m-d') . " required></td></tr>";
            echo "<tr><td>Phone number</td><td><input name='phone_number' type='tel' pattern='[0-9]{3}-[0-9]{3}-[0-9]{4}'><br><small>Format: 123-456-7890</small></td></tr>";
            echo "<tr><td>Address</td><td><input name='address' type='text' size='25'></td></tr>";
            
            $stmt = $conn->prepare('select s_id, s.manager, concat(first_name, " ", last_name) as manager_name from Store s left join Employee e on s.manager = e.e_id order by manager_name;');
            $stmt->execute();
            
            // make dropdown menu for manager
            echo "<tr><td>Manager</td><td>";
            echo "<select name='manager'>";
            echo "<option value='-1'>No manager</option>";
            
            while ($row = $stmt->fetch()) {
                echo "<option value='$row[manager]'>$row[manager_name] at Store $row[s_id]</option>";
            }
            
            $stmt = $conn->prepare('select s_id from Store order by s_id;');
            $stmt->execute();
            
            // make dropdown menu for store
            echo "<tr><td>Store</td><td>";
            echo "<select name='store'>";
            
            while ($row = $stmt->fetch()) {
                echo "<option value='$row[s_id]'>$row[s_id]</option>";
            }
            
            echo "</select>";
            echo "</td></tr>";
            
            if ($type == "Cashier" || $type == "Stocker") {
                
                echo "<tr><td>Employment status</td><td>";
                echo "<select name='employment_status'>";
                echo "<option value='Part-time'>Part-time</option>";
                echo "<option value='Full-time'>Full-time</option>";
                echo "</select></td></tr>";
                
                if ($type == "Stocker") {
                    echo "<tr><td>Product to stock</td><td>";
                    echo "<select name='product_to_stock'>";
                    echo "<option value='-1'>No product to stock</option>";
                    echo "<option value='Accessory'>Accessory</option>";
                    echo "<option value='Bedding'>Bedding</option>";
                    echo "<option value='Collar'>Collar</option>";
                    echo "<option value='Crate'>Crate</option>";
                    echo "<option value='Decor'>Decor</option>";
                    echo "<option value='Filter'>Filter</option>";
                    echo "<option value='Food'>Food</option>";
                    echo "<option value='Habitat'>Habitat</option>";
                    echo "<option value='Leash'>Leash</option>";
                    echo "<option value='Light'>Light</option>";
                    echo "<option value='Litter'>Litter</option>";
                    echo "<option value='Medication'>Medication</option>";
                    echo "<option value='Toy'>Toy</option>";
                    echo "<option value='Vitamin'>Vitamin</option>";
                    echo "</select></td></tr>";
                }
                
            } elseif ($type == "Groomer" || $type == "Trainer") {
                
                echo "<tr><td>Date certified</td><td><input name='date_certified' type='date' min='1910-01-01' max=" . date('Y-m-d') . " required></td></tr>";
                
                if ($type == "Groomer") {
                    echo "<tr><td>Specialty</td><td><input name='specialty' type='text' size='25'></td></tr>";
                } else {
                    
                    $stmt = $conn->prepare('select classification from Animal order by classification;');
                    $stmt->execute();
                    
                    // make dropdown menu for animal
                    echo "<tr><td>Certified animal</td><td>";
                    echo "<select name='animal'>";
                    
                    while ($row = $stmt->fetch()) {
                        echo "<option value='$row[classification]'>$row[classification]</option>";
                    }
                    
                    echo "</select>";
                    echo "</td></tr>";
                    
                    echo "<tr><td>Max lessons per day</td><td><input name='max_lessons_per_day' type='number' min='0' max='50' step='1' size='8' value='0'></td></tr>";
                    
                }
                
            }
            
            // submit form button
            echo "<tr><td></td><td><input type='submit' value='Submit'></td></tr>";
            
            echo "</tbody>";
            echo "</table>";
            echo "</form>";
            
            $_SESSION["addEmployee_type"] = $type; 
            
        } else { // after user submitted form
            
            try {
                
                // insert into Employee table
                $stmt = $conn->prepare("insert into Employee(first_name, last_name, salary, birthdate, phone_number, address, manager, store) values (:first_name, :last_name, :salary, :birthdate, :phone_number, :address, :manager, :store);
                            select last_insert_id() as prev_id;");
                
                $stmt->bindValue(':first_name', trim($_POST['first_name']));
                $stmt->bindValue(':last_name', trim($_POST['last_name']));
                $stmt->bindValue(':salary', $_POST['salary']);
                $stmt->bindValue(':birthdate', $_POST['birthdate']);
                $stmt->bindValue(':store', $_POST['store']);
                
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
                
                if($_POST['manager'] != -1) {
                    $stmt->bindValue(':manager', $_POST['manager']);
                } else {
                    $stmt->bindValue(':manager', null, PDO::PARAM_INT);
                }
                
                $stmt->execute();
                $row = $stmt->fetch();
                
                // get emp auto e_id
                $_SESSION["addEmployee_prev_id"] = $row[prev_id];
                
                // insert into appropriate tables
                if ($_SESSION["addEmployee_type"] == "Cashier") {
                    
                    $c_stmt = $conn->prepare("insert into Cashier(e_id, employment_status) values (:prev_id, :employment_status);");
                    
                    $c_stmt->bindValue(':prev_id', $_SESSION["addEmployee_prev_id"]);
                    $c_stmt->bindValue(':employment_status', $_POST['employment_status']);
                    
                    $c_stmt->execute();
                    
                } elseif ($_SESSION["addEmployee_type"] == "Groomer") {
                    
                    $g_stmt = $conn->prepare("insert into Certification(date_certified, type_of) values (:date_certified, 'Groomer');
                                    insert into Groomer(e_id, specialty, certification) values (:prev_id, :specialty, last_insert_id());");
                    
                    $g_stmt->bindValue(':prev_id', $_SESSION["addEmployee_prev_id"]);
                    $g_stmt->bindValue(':date_certified', $_POST['date_certified']);
                    
                    if($_POST['specialty'] != "") {
                        $g_stmt->bindValue(':specialty', trim($_POST['specialty']));
                    } else {
                        $g_stmt->bindValue(':specialty', null, PDO::PARAM_STR);
                    }
                    
                    $g_stmt->execute();
                    
                } elseif ($_SESSION["addEmployee_type"] == "Stocker") {
                    
                    $s_stmt = $conn->prepare("insert into Stocker(e_id, employment_status, product_to_stock) values (:prev_id, :employment_status, :product_to_stock);");
                    
                    $s_stmt->bindValue(':prev_id', $_SESSION["addEmployee_prev_id"]);
                    $s_stmt->bindValue(':employment_status', $_POST['employment_status']);
                    
                    if($_POST['product_to_stock'] != -1) {
                        $s_stmt->bindValue(':product_to_stock', $_POST['product_to_stock']);
                    } else {
                        $s_stmt->bindValue(':product_to_stock', null, PDO::PARAM_STR);
                    }
                    
                    $s_stmt->execute();
                    
                } elseif ($_SESSION["addEmployee_type"] == "Trainer") {
                    
                    $t_stmt = $conn->prepare("insert into Trainer(e_id, max_lessons_per_day) values (:prev_id, :max_lessons_per_day);
                                    insert into Certification(date_certified, type_of) values (:date_certified, 'Trainer');
                                    insert into Cert_Trainer(trainer, certification, animal) values (:prev_id, last_insert_id(), :animal);");
                    
                    $t_stmt->bindValue(':prev_id', $_SESSION["addEmployee_prev_id"]);
                    $t_stmt->bindValue(':date_certified', $_POST['date_certified']);
                    $t_stmt->bindValue(':animal', $_POST['animal']);
                    
                    if($_POST['max_lessons_per_day'] !=  "" || $_POST['max_lessons_per_day'] != null) {
                        $t_stmt->bindValue(':max_lessons_per_day', $_POST['max_lessons_per_day']);
                    } else {
                        $t_stmt->bindValue(':max_lessons_per_day', null, PDO::PARAM_INT);
                    }
                    
                    $t_stmt->execute();
                    
                }
                
                echo "Successfully added new employee.";
                
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            
            unset ($_SESSION["addEmployee_type"]);
            unset ($_SESSION["addEmployee_prev_id"]);
            
        }
        
        ?>
        
        <!-- click to get back to index -->
		<br><br><a href="index.php">Back to index</a>
		
	</body>
</html>