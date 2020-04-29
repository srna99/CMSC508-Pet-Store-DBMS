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
		
		<h1>Edit an Employee</h1>
	
        <?php
        
        require_once ('connection.php');
        
        error_reporting(E_ALL ^ E_WARNING); 
        
        session_start();
        
        // first page
        if (!isset($_GET['e_id']) && $_SERVER['REQUEST_METHOD'] != 'POST') {
            
            $stmt = $conn->prepare('select e_id, first_name, last_name, store from Employee order by first_name, last_name, store;');
            $stmt->execute();
            
            // select a employee to get to current related info
            echo "<form method='get'>";
            echo "Select an employee:  ";
            
            // make dropdown menu for employee
            echo "<select name='e_id' onchange='this.form.submit();'>";
            echo "<option disabled selected value> -- select an employee -- </option>";
            
            // show info from query
            while ($row = $stmt->fetch()) {
                echo "<option value='$row[e_id]'>$row[first_name] $row[last_name] at $row[store]</option>";
            }
            
            echo "</select>";
            echo "</form>";
            exit();
            
        }
        
        // second page - form
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            
            $e_id = $_GET["e_id"];
            
            // get related info from pk
            $stmt = $conn->prepare('select first_name, last_name, salary, phone_number, address, manager, store from Employee where e_id = :e_id;');
            $stmt->bindValue(':e_id', $e_id);
            
            $stmt->execute();
            
            $row = $stmt->fetch();
            
            // display current info
            echo "<form method='post' action='editEmployee.php'>";
            echo "<table>";
            echo "<tbody>";
            echo "<tr><td>First name</td><td><input name='first_name' type='text' value='$row[first_name]' size='25' required></td></tr>";
            echo "<tr><td>Last name</td><td><input name='last_name' type='text' value='$row[last_name]' size='25' required></td></tr>";
            echo "<tr><td>Salary</td><td><input name='salary' type='number' min='0.01' max='999999.99' step='0.01' size='8' value='$row[salary]' required></td></tr>";
            
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
            
            $m_stmt = $conn->prepare('select s_id, s.manager, concat(first_name, " ", last_name) as manager_name from Store s left join Employee e on s.manager = e.e_id order by manager_name;');
            $m_stmt->execute();
            
            // make dropdown menu for manager
            echo "<tr><td>Manager</td><td>";
            echo "<select name='manager'>";
            echo "<option value='-1'>No manager</option>";
            
            while ($m_row = $m_stmt->fetch()) {
                
                if ($row[manager] == $m_row[manager]) {
                    echo "<option value='$m_row[manager]' selected>$m_row[manager_name] at Store $m_row[s_id]</option>";
                } else {
                    echo "<option value='$m_row[manager]'>$m_row[manager_name] at Store $m_row[s_id]</option>";
                }
                
            }
            
            $s_stmt = $conn->prepare('select s_id from Store order by s_id;');
            $s_stmt->execute();
            
            // make dropdown menu for store
            echo "<tr><td>Store</td><td>";
            echo "<select name='store'>";
            
            while ($s_row = $s_stmt->fetch()) {
                
                if ($row[store] == $m_row[s_id]) {
                    echo "<option value='$s_row[s_id]' selected>$s_row[s_id]</option>";
                } else {
                    echo "<option value='$s_row[s_id]'>$s_row[s_id]</option>";
                }
                
            }
            
            echo "</select>";
            echo "</td></tr>";
            
            $stmt = $conn->prepare("select
                                    	case
                                    		when :e_id in (select e_id from Cashier) then 1
                                    		when :e_id in (select e_id from Groomer) then 2
                                    		when :e_id in (select e_id from Stocker) then 3
                                    		when :e_id in (select e_id from Trainer) then 4
                                    		else 0
                                    	end as emp_type;");
            $stmt->bindValue(':e_id', $e_id);
            $stmt->execute();
            
            $row = $stmt->fetch();
            
            $_SESSION["editEmployee_emp_type"] = $row[emp_type];
            
            switch ($_SESSION["editEmployee_emp_type"]) {
                
                case 1:
                    
                    $stmt = $conn->prepare("select employment_status from Cashier where e_id = :e_id");
                    $stmt->bindValue(':e_id', $e_id);
                    $stmt->execute();
                    
                    $row = $stmt->fetch();
                    
                    echo "<tr><td>Employment status</td><td>";
                    echo "<select name='employment_status'>";
                    
                    if (strtolower($row[employment_status]) == "part-time") {
                        echo "<option value='Part-time' selected>Part-time</option>";
                        echo "<option value='Full-time'>Full-time</option>";
                    } else {
                        echo "<option value='Part-time'>Part-time</option>";
                        echo "<option value='Full-time' selected>Full-time</option>";
                    }
                    
                    echo "</select></td></tr>";
                    
                    break;
                    
                case 2:
                    
                    $stmt = $conn->prepare("select specialty from Groomer where e_id = :e_id");
                    $stmt->bindValue(':e_id', $e_id);
                    $stmt->execute();
                    
                    $row = $stmt->fetch();
                    
                    echo "<tr><td>Specialty</td><td><input name='specialty' type='text' size='25' value='$row[specialty]'></td></tr>";
                    
                    break;
                    
                case 3:
                    
                    $stmt = $conn->prepare("select employment_status, product_to_stock from Stocker where e_id = :e_id");
                    $stmt->bindValue(':e_id', $e_id);
                    $stmt->execute();
                    
                    $row = $stmt->fetch();
                    
                    echo "<tr><td>Employment status</td><td>";
                    echo "<select name='employment_status'>";
                    
                    if (strtolower($row[employment_status]) == "part-time") {
                        echo "<option value='Part-time' selected>Part-time</option>";
                        echo "<option value='Full-time'>Full-time</option>";
                    } else {
                        echo "<option value='Part-time'>Part-time</option>";
                        echo "<option value='Full-time' selected>Full-time</option>";
                    }
                    
                    echo "</select></td></tr>";
                    
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
                    
                    break;
                    
                case 4:
                    
                    $stmt = $conn->prepare("select max_lessons_per_day from Trainer where e_id = :e_id");
                    $stmt->bindValue(':e_id', $e_id);
                    $stmt->execute();
                    
                    $row = $stmt->fetch();
                    
                    echo "<tr><td>Max lessons per day</td><td><input name='max_lessons_per_day' type='number' min='0' max='50' step='1' size='8' value='$row[max_lessons_per_day]'></td></tr>";
                    
                    break;
                    
                default:
                    break;
                    
            }
 
            // submit button
            echo "<tr><td></td><td><input type='submit' value='Submit'></td></tr>";
            echo "</tbody>";
            echo "</table>";
            echo "</form>";
            
            $_SESSION["editEmployee_e_id"] = $e_id; 
            
        } else { // after submitting form
            
            try {
                
                // update employee with edits
                $stmt = $conn->prepare("update Employee set first_name = :first_name, last_name = :last_name, salary = :salary, phone_number = :phone_number, address = :address, manager = :manager, store = :store
                                where e_id = :e_id;");
                
                $stmt->bindValue(':first_name', trim($_POST['first_name']));
                $stmt->bindValue(':last_name', trim($_POST['last_name']));
                $stmt->bindValue(':e_id', $_SESSION["editEmployee_e_id"]);
                $stmt->bindValue(':salary', $_POST['salary']);
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
                
                switch ($_SESSION["editEmployee_emp_type"]) {
                    
                    case 1:
                        
                        $stmt = $conn->prepare("update Cashier set employment_status = :employment_status where e_id = :e_id;");
                        $stmt->bindValue(':e_id', $_SESSION["editEmployee_e_id"]);
                        $stmt->bindValue(':employment_status', $_POST['employment_status']);
                        $stmt->execute();
                        
                        break;
                        
                    case 2:
                        
                        $stmt = $conn->prepare("update Groomer set specialty = :specialty where e_id = :e_id;");
                        $stmt->bindValue(':e_id', $_SESSION["editEmployee_e_id"]);
                        
                        if($_POST['specialty'] != "") {
                            $stmt->bindValue(':specialty', trim($_POST['specialty']));
                        } else {
                            $stmt->bindValue(':specialty', null, PDO::PARAM_STR);
                        }
                        
                        $stmt->execute();
                        
                        break;
                        
                    case 3:
                        
                        $stmt = $conn->prepare("update Stocker set employment_status = :employment_status, product_to_stock = :product_to_stock where e_id = :e_id;");
                        $stmt->bindValue(':e_id', $_SESSION["editEmployee_e_id"]);
                        $stmt->bindValue(':employment_status', $_POST['employment_status']);
                        
                        if($_POST['product_to_stock'] != -1) {
                            $stmt->bindValue(':product_to_stock', $_POST['product_to_stock']);
                        } else {
                            $stmt->bindValue(':product_to_stock', null, PDO::PARAM_STR);
                        }
                        
                        $stmt->execute();
                        
                        break;
                        
                    case 4:
                        
                        $stmt = $conn->prepare("update Trainer set max_lessons_per_day = :max_lessons_per_day where e_id = :e_id;");
                        $stmt->bindValue(':e_id', $_SESSION["editEmployee_e_id"]);
                        
                        if($_POST['max_lessons_per_day'] !=  "" || $_POST['max_lessons_per_day'] != null) {
                            $stmt->bindValue(':max_lessons_per_day', $_POST['max_lessons_per_day']);
                        } else {
                            $stmt->bindValue(':max_lessons_per_day', null, PDO::PARAM_INT);
                        }
                        
                        $stmt->execute();
                        
                        break;
                        
                    default:
                        break;
                        
                }
                
                echo "Successfully updated employee.";
                
            } catch (PDOException $e) {
                
                echo "Error: " . $e->getMessage();
            }
            
            unset ($_SESSION["editEmployee_e_id"]);
            unset ($_SESSION["editEmployee_emp_type"]);
            
        }
        
        ?>
        
        <!-- click to get back to index -->
		<br><br><a href="index.php">Back to index</a>
		
	</body>
</html>