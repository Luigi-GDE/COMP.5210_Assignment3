<?php
session_start();
include "connection.php";

//get scp id
$scpId = isset($_GET['id']) ? intval($_GET['id']) : 0;

//delete functionality
if (isset($_GET['delete'])) {
    $delID = intval($_GET['delete']);
    $delete = $connection->prepare("DELETE FROM scp WHERE id = ?");
    $delete->bind_param('i', $delID);

    if ($delete->execute()) {
        //message for delete
        $_SESSION['message'] = "Subject successfully deleted.";
        header("Location: index.php");
        exit;
    } else {
        echo "<div class='alert alert-danger p-3'>Error: {$delete->error}</div>";
    }
}

//get scp details
$query = $connection->prepare("SELECT id, subject, class, image, containment, description FROM scp WHERE id = ?");
$query->bind_param("i", $scpId);
$query->execute();
$result = $query->get_result();


if ($result->num_rows > 0) {
    $scpItem = $result->fetch_assoc();
    
    $defaultImage = 'images/classified.png'; 
    $update = "update.php?update=" . $scpItem['id'];
    $delete = "subject.php?delete=" . $scpItem['id'];
    
    //check for scp image
    if (!empty($scpItem['image']) && file_exists(trim($scpItem['image']))) {
        $imageSrc = htmlspecialchars(trim($scpItem['image']));
    } else {
        //use default image if none exist
        $imageSrc = $defaultImage;
    }
} else {
    echo "SCP not found.";
    exit;
}

$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/scp.css">
    <title><?= htmlspecialchars($scpItem['subject']) ?></title>
</head>
<body>
    <!-- Navbar and Offcanvas -->
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
                        <a href="create.php">
                            <li class="mt-3">Create Subject</li>
                        </a>
                    </div>
                </ul>
            </div>
        </div>
    </div>
    
    <!-- Main Box -->
    <div class="holder bg-dark mt-5 rounded shadowCard mb-5">
        <div class="desc container-fluid rounded">
            <h1>Item: <?= htmlspecialchars($scpItem['subject']) ?></h1>
            <h2>Object Class: <span class="<?= htmlspecialchars($scpItem['class']) ?>"><?= htmlspecialchars($scpItem['class']) ?></span></h2>
        </div>
        <br>
        
        <img src="<?= htmlspecialchars($imageSrc) ?>" class="holderimg mb-5" alt="SCP image">
        
        <div class="desc container-fluid rounded mt-5">
            <h3>Description:</h3>
            <p><?= htmlspecialchars($scpItem['description']) ?></p>
            
            <h3>Special Containment Procedures:</h3>
            <p><?= htmlspecialchars($scpItem['containment']) ?></p>
        </div>
        
        <div class="mid">
            <a href="<?= $update ?>">
                <button class="read mx-3 my-2 mb-3">Edit</button>
            </a>
            
            <a href="<?= $delete ?>">
                <button class="read mx-3 my-2 mb-3">Delete</button>
            </a>
        </div>
    </div>

    <!-- Footer -->
    <div class="col-12 dark mid footer1"></div>

    <!-- JavaScript for alert -->
    <?php if (isset($_SESSION['message'])): ?>
        <script>
            alert("<?= $_SESSION['message'] ?>");
        </script>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
