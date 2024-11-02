<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/scp.css">
    <title>Create New Entry</title>
</head>
<body>
    <!-- Navbar and Offcanvas -->
            <!-- Navigation bar -->
        <div class="container-fluid navbar1">
            <a href="index.php">
                <img src="images/logo.png" alt="scp logo" class="fit">
            </a>

            <!-- Hamburger button -->
            <button class="btn btn-primary btn-hamburger" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                <span class="hamburger-icon">&#9776;</span>
            </button>

            <!-- Offcanvas component -->
            <div class="offcanvas offcanvas-end bg-dark" tabindex="-1" id="offcanvasRight" style="width: 20rem;"
                aria-labelledby="offcanvasRightLabel">
                <div class="offcanvas-header">
                    <h5 id="offcanvasRightLabel">Offcanvas right</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul>
                        <div class="rect">
                            <a href="index.php">
                                <li>Home</li>
                            </a>
                            <a href = "create.php">
                                <li class="mt-3">Create Subject</li>
                            </a>
                            <a href = "update.php">
                                <li class="mt-3">Update Subject</li>
                            </a>
                            <a href = "delete.php">
                                <li class="mt-3">Delete Subject</li>
                            </a>
                        </div>
                    </ul>
                </div>
            </div>
        </div>
    
    <!-- Main Box -->
    <div class="holder bg-dark mt-5 rounded shadowCard mb-5">
        
        <?php   
            include "connection.php";
            
            if(isset($_POST['submit']))
            {
                //write prepared statement to insert data
                $insert = $connection->prepare("insert into scp(subject, class, image, description, containment) values (?,?,?,?,?)");
                $insert-> bind_param("sssss", $_POST['subject'], $_POST['class'], $_POST['image'], $_POST['description'], $_POST['containment']);
                
                if($insert->execute())
                {
                    echo "
                        <div class='alert alert-success p-3'>Record Successfully Created</div>
                    ";
                }
                else
                {
                    echo "
                        <div class='alert alert-danger p-3'>Error: {$insert->error}</div>
                    ";
                }
            }
            
            
            
        ?>
        
        
        
        <h1>Create new record</h1>
        <br>
        
        <form method = "post" action = "create.php" form-group class ="mx-1">
            
            <label>Enter SCP designation</label>
            <br>
            <input type="text" name ="subject" placeholder ="Subject" class = "form-control" required> 
            <br>
            <br>
            
            <label>Enter Class</label>
            <br>
            <input type="text" name ="class" placeholder ="Class" class = "form-control"> 
            <br>
            <br>
            
            <label>Enter Image</label>
            <br>
            <input type="text" name ="image" placeholder ="Image.png" class = "form-control"> 
            <br>
            <br>
            
            <label>Enter SCP Description</label>
            <br>
            <textarea name ="description" class ="form-control">Enter description here</textarea>
            <br>
            <br>
            
            <label>Enter SCP Containment Methods</label>
            <br>
            <textarea name ="containment" class ="form-control">Enter description here</textarea> 
            <br>
            <br>
            <input type ="submit" name ="submit" class ="read center">
            
        </form>
        

        
    </div>

    <!-- Footer -->
    <div class="col-12 dark mid footer1"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
