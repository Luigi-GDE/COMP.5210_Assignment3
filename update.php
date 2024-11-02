<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/scp.css">
    <title>Update Entry</title>
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
                        </div>
                    </ul>
                </div>
            </div>
        </div>
    
    <!-- Main Box -->
    <div class="holder bg-dark mt-5 rounded shadowCard mb-5">
        
        <?php   
            include "connection.php";
            
            
            if($_GET['update'])
            {
                $id = $_GET['update'];
                $recordID = $connection->prepare("SELECT * FROM scp WHERE id = ?");
                if(!$recordID)
                {
                    echo "<div class = 'alert alert-danger p-3 m-2'>Error pairing record for updating</div>";
                    exit;
                }
                
                $recordID -> bind_param("i",$id);
                
                if($recordID->execute())
                {
                    echo "<div class = 'alert alert-success p-3 m-2'>Ready to update</div>";
                    $temp = $recordID -> get_result();
                    $row = $temp -> fetch_assoc();
                }
                else
                {
                    echo "<div class = 'alert alert-danger p-3 m-2'>Error: {$recordID->error}</div>";
                }
            }
            
            
            if(isset($_POST['update']))
            {
                //write prepared statement to insert data 
                $update = $connection->prepare("UPDATE scp SET subject = ?, class = ?, image = ?, description = ?, containment = ? WHERE id = ?");
                $update-> bind_param("sssssi", $_POST['subject'], $_POST['class'], $_POST['image'], $_POST['description'], $_POST['containment'], $_POST['id']);
                
                if($update->execute())
                {
                    echo "
                        <div class='alert alert-success p-3'>Record Successfully Updated</div>
                    ";
                }
                else
                {
                    echo "
                        <div class='alert alert-danger p-3'>Error: {$update->error}</div>
                    ";
                }
            }
            
            
            
        ?>
        
        
        
        <h1>Update record</h1>
        <br>
        
        <form method = "post" action = "update.php" form-group class ="mx-1">
            <input type= "hidden" name= "id" value = <?php echo $row['id']; ?>>
            
            <label>SCP designation</label>
            <br>
            <input type="text" name ="subject" placeholder ="Subject" class = "form-control" required value = <?php echo $row['subject']; ?>> 
            <br>
            <br>
            
            <label>Class</label>
            <br>
            <input type="text" name ="class" placeholder ="Class" class = "form-control" value = <?php echo $row['class']; ?>> 
            <br>
            <br>
            
            <label>Image</label>
            <br>
            <input type="text" name ="image" placeholder ="Image.png" class = "form-control" value = <?php echo $row['image']; ?>> 
            <br>
            <br>
            
            <label>Description</label>
            <br>
            <textarea name ="description" class ="form-control"><?php echo $row['description']; ?></textarea>
            <br>
            <br>
            
            <label>Containment Methods</label>
            <br>
            <textarea name ="containment" class ="form-control"><?php echo $row['containment']; ?></textarea> 
            <br>
            <br>
            <input type ="submit" name ="update" class ="read center">
            
        </form>
        

        
    </div>

    <!-- Footer -->
    <div class="col-12 dark mid footer1"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
