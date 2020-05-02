<html>
    <head>
    	<title>CMSC 508 Pet Store DBMS</title>
    	
    	<style>
    	    #content {
                max-width: 800px;
                margin: auto;
                padding-bottom: 100px;
                display: flex;
            }
            
            .column {
                flex: 50%;
                padding: 10px;
            }
            
    	    h1 {
                text-align: center;
                margin-top: 0.8em;
            }
            
            h2 {
                text-align: center;
                margin-bottom: 0.8em;
            }
            
            ul {
              text-align: center;
              list-style: inside;
            }
            
            .links {
                text-align: center;
            }
            
            a {
                display: inline-block;
                margin-bottom: 5px;
            }
    	</style>
    </head>
    
    <body>
    	<h1>Pet Store DBMS</h1>
    	
    	<div id="content">
    		<div class="column">
            	<h2>Pets</h2>
            	<div class="links">
            		<a href="animal.php">Display All Types of Animals</a>
            		<br><a href="addAnimal.php">Add New Type of Animal</a>
            		<br><a href="editAnimal.php">Edit Diet Type of Animal</a>
            		<br><a href="deleteAnimal.php">Delete A Type of Animal</a>
            		<br>
            		<br><a href="pet.php">Display All Pets</a>
            		<br><a href="addPet.php">Add New Pet</a>
            		<br><a href="editPet.php">Edit Pet</a>
            		<br><a href="deletePet.php">Delete A Pet</a>
            	</div>
        		
        		<h2>Stock</h2>
            	<div class="links">
        			<a href="accessory.php">Display All Accessories</a>
        			<br><a href="addAccessory.php">Add New Accessory</a>
        			<br><a href="editAccessory.php">Edit An Accessory</a>
        			<br><a href="deleteAccessory.php">Delete An Accessory</a>
        			<br>
        			<br><a href="bedding.php">Display All Beddings</a>
        			<br><a href="addBedding.php">Add New Bedding</a>
        			<br><a href="editBedding.php">Edit A Bedding</a>
        			<br><a href="deleteBedding.php">Delete A Bedding</a>
        			<br>
        			<br><a href="food.php">Display All Foods</a>
        			<br><a href="addFood.php">Add New Food</a>
        			<br><a href="editFood.php">Edit A Food</a>
        			<br><a href="deleteFood.php">Delete A Food</a>
    				<br>
        			<br><a href="bowl.php">Display All Bowls</a>
    				<br><a href="addBowl.php">Add New Bowl</a>
    				<br><a href="editBowl.php">Edit A Bowl</a>
        			<br><a href="deleteBowl.php">Delete A Bowl</a>
        		</div>
        	</div>
        		
        	<div class="column">
            	<h2>Customers</h2>
            	<div class="links">
            		<a href="customer.php">Display All Customers</a>
            		<br><a href="addCustomer.php">Add New Customer</a>
            		<br><a href="editCustomer.php">Edit A Customer</a>
            		<br><a href="deleteCustomer.php">Delete A Customer</a>
            		<br>
            		<br><a href="customerTransactions.php">Display All Customer Transactions</a>
            		<br><a href="addCustomerTransaction.php">Add New Transaction</a>
            		<br><a href="customerVisited.php">Display All Stores Visited By A Customer</a>
            	</div>
            	
            	<h2>Personnel and Related Matters</h2>
            	<div class="links">
            		<a href="employee.php">Display All Employees</a>
                	<br><a href="cashier.php">Display All Cashiers</a>
                	<br><a href="groomer.php">Display All Groomers</a>
                	<br><a href="stocker.php">Display All Stockers</a>
                	<br><a href="trainer.php">Display All Trainers</a>
                	<br><a href="addEmployee.php">Add New Employee</a>
                	<br><a href="editEmployee.php">Edit An Employee</a>
                	<br><a href="deleteEmployee.php">Delete An Employee</a>
                	<br>
                	<br><a href="clipper.php">Display All Clippers</a>
                	<br><a href="clipperUse.php">Display Clipper Usage History</a>
                	<br><a href="addClipper.php">Add New Clipper</a>
                	<br><a href="addClipperUse.php">Add Clipper Usage</a>
                	<br><a href="deleteClipper.php">Delete A Clipper</a>
                	<br>
                	<br><a href="groomingAcc.php">Display All Grooming Accessories</a>
                	<br><a href="groomingAccUse.php">Display Grooming Accessory Usage History</a>
                	<br><a href="addGroomingAcc.php">Add New Grooming Accessory</a>
                	<br><a href="addGroomingAccUse.php">Add Grooming Accessory Usage</a>
                	<br><a href="deleteGroomingAcc.php">Delete A Grooming Accessory</a>
                	<br>
                	<br><a href="treatment.php">Display Treatment History</a>
                	<br><a href="addTreatment.php">Add New Treatment Record</a>
                	<br>
                	<br><a href="lesson.php">Display Lesson History</a>
                	<br><a href="addLesson.php">Add New Lesson</a>
            	</div>
            	
            	<h2>Stores and Businesses</h2>
            	<div class="links">
            		<a href="store.php">Display All Stores</a>
            		<br><a href="addStore.php">Add New Store Location</a>
            		<br><a href="storeAddress.php">Change Store's Address</a>
            		<br><a href="storeManager.php">Update Store's Manager</a>
            		<br><a href="deleteStore.php">Close A Store Location</a>
            	</div>
            </div>
    	</div>
    </body>
</html>