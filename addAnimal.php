<html>
	<head>
		<style>
            table, th, td {
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
            
            a {
                margin-top: 30px;
            }
        </style>
	</head>
	
	<body>
		<h1>List of All Types of Animals</h1>
	
        <?php
        
        /*
         *
if ($_SERVER['REQUEST_METHOD'] != 'POST') {

    echo "<form method='post' action='addEmployee.php'>";
    echo "<table style='border: solid 1px black;'>";
    echo "<tbody>";
    echo "<tr><td>First name</td><td><input name='first_name' type='text' size='25'></td></tr>";
    echo "<tr><td>Last name</td><td><input name='last_name' type='text' size='25'></td></tr>";
    echo "<tr><td>Email</td><td><input name='email' type='email' size='25'></td></tr>";
    echo "<tr><td>Salary</td><td><input name='salary' type='number' min='0.01' step='0.01' size='8'></td></tr>";
    echo "<tr><td>Manager</td><td>";
    
    // Retrieve list of employees as potential manager of the new employee
    $stmt = $conn->prepare("SELECT employee_id, first_name, last_name FROM employees");
    $stmt->execute();
    
    echo "<select name='manager_id'>";
    
    echo "<option value='-1'>No manager</option>";
    
    while ($row = $stmt->fetch()) {
        echo "<option value='$row[employee_id]'>$row[first_name] $row[last_name]</option>";
    }
    
    echo "</select>";
    echo "</td></tr>";
    
    echo "<tr><td>Department</td><td>";
    
    // Retrieve list of departments
    $stmt = $conn->prepare("SELECT department_id, department_name FROM departments");
    $stmt->execute();
    
    echo "<select name='department_id'>";
    
    echo "<option value='-1'>No department</option>";
    
    while ($row = $stmt->fetch()) {
        echo "<option value='$row[department_id]'>$row[department_name]</option>";
    }
    
    echo "</select>";
    echo "</td></tr>";
    
    echo "<tr><td>Job</td><td>";
    
    // Retrieve list of jobs
    $stmt = $conn->prepare("SELECT job_id, job_title FROM jobs");
    $stmt->execute();
    
    echo "<select name='job_id'>";
    
    while ($row = $stmt->fetch()) {
        echo "<option value='$row[job_id]'>$row[job_title]</option>";
    }
    
    echo "</select>";
    echo "</td></tr>";
    
    echo "<tr><td></td><td><input type='submit' value='Submit'></td></tr>";
    
    echo "</tbody>";
    echo "</table>";
    echo "</form>";
} else {
    
    try {
        $stmt = $conn->prepare("INSERT INTO employees (first_name, last_name, email, hire_date, job_id, salary, manager_id, department_id)
                                VALUES (:first_name, :last_name, :email, CURDATE(), :job_id, :salary, :manager_id, :department_id)");

        $stmt->bindValue(':first_name', $_POST['first_name']);
        $stmt->bindValue(':last_name', $_POST['last_name']);
        $stmt->bindValue(':email', $_POST['email']);
        $stmt->bindValue(':job_id', $_POST['job_id']);
        $stmt->bindValue(':salary', $_POST['salary']);
        
        if($_POST['manager_id'] != -1) {
            $stmt->bindValue(':manager_id', $_POST['manager_id']);
        } else {
            $stmt->bindValue(':manager_id', null, PDO::PARAM_INT);
        }
        
        if($_POST['department_id'] != -1) {
            $stmt->bindValue(':department_id', $_POST['department_id']);
        } else {
            $stmt->bindValue(':department_id', null, PDO::PARAM_INT);
        }
        
        $stmt->execute();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    echo "Success";    
}
         */
        
        require_once ('connection.php');
        
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            
            echo "<form method='post' action='addAnimal.php'>";
            echo "<table>";
            echo "<tbody>";
            echo "<tr><td>Species</td><td><input name='classification' type='text' size='25'></td></tr>";
            echo "<tr><td>Diet type</td><td>";
           
            echo "<select name='diet_type'>";
            
            echo "<option value='1'>Carnivore</option>";
            echo "<option value='2'>Herbivore</option>";
            echo "<option value='3'>Omnivore</option>";
            
            echo "</select>";
            echo "</td></tr>";
            
            echo "<tr><td></td><td><input type='submit' value='Submit'></td></tr>";
            
            echo "</tbody>";
            echo "</table>";
            echo "</form>";
            
        } else {
            
            try {
                
                $stmt = $conn->prepare("insert into Animal values (:classification, :diet_type);");
                
                $stmt->bindValue(':classification', $_POST['classification']);
                $stmt->bindValue(':diet_type', $_POST['diet_type']);
                
                $stmt->execute();
                
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            
            echo "Success";
        }
        
//         // get all animals
//         $stmt = $conn->prepare('select classification, diet_type from Animal;');
//         $stmt->execute();
        
//         echo "<table>";
//         echo "<thead><tr>
//             <th>Species</th>
//             <th>Diet type</th>
//             </tr></thead>";
//         echo "<tbody>";
        
//         // show info from query
//         while ($row = $stmt->fetch()) {
//             echo "<tr><td>$row[classification]</td><td>$row[diet_type]</td></tr>";
//         }
        
//         echo "</tbody>";
//         echo "</table>";
        
        ?>
        
        <!-- click to get back to index -->
		<a href="index.php">Back to index</a>
	</body>
</html>