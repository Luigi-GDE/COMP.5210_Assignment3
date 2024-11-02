<?php
session_start();
include "connection.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles/main.css">
    <title>SCP Catalogue</title>
</head>
<body>

    <!-- message if theres been a delete-->
    <?php if (isset($_SESSION['message'])): ?>
        <script>
            // save message
            const message = "<?= $_SESSION['message'] ?>";
        </script>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <!-- Navbar -->
    <div class="container-fluid navbar1">
        <a href="index.php">
            <img src="images/logo.png" alt="scp logo" class="fit">
        </a>

        <!-- Hamburger Button -->
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

    <!-- Banner -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-4 dark mid"></div>
            <div class="col-4 dark mid">
                <img src="images/logo2.png" class="img-fluid" alt="scp banner" id="banner">
            </div>
            <div class="col-4 dark mid"></div>
        </div>
    </div>

    <!-- Intro Section -->
    <h1 class="textcent">Welcome to SCP</h1>
    <p class="intro">
        Explore the world of anomalous entities, objects, and phenomena meticulously cataloged and contained for global safety.
        Our secure facilities house the SCPs—strange and inexplicable objects—each with their own unique and often dangerous properties.
        As a Foundation researcher, you are granted access to classified information about these entities, as well as the latest
        containment protocols and research updates. Browse through our database to uncover the mysteries and ensure the protection
        of humanity from the unknown.
    </p>
    <hr>
    <h1 class="textcent">Catalogue</h1>
    <hr>  

    <!-- SCP Catalogue -->
    <div id="root">
        <?php
            $AllRecords = $connection->prepare("SELECT id, subject, class, image, description, containment FROM scp");
            $AllRecords->execute();
            $result = $AllRecords->get_result();

            while ($scp = $result->fetch_assoc()) {
                $defaultImage = 'images/classified.png';

                // Check if the SCP image is set and exists
                if (!empty($scp['image']) && file_exists(trim($scp['image']))) {
                    $imageSrc = htmlspecialchars(trim($scp['image']));
                } else {
                    $imageSrc = $defaultImage;
                }

                echo '
                <div class="container bg-dark mt-5 rounded shadowCard" id="' . htmlspecialchars($scp['subject']) . '">
                    <div class="row">
                        <div class="col-md-4 purple rounded-start">
                            <img src="' . htmlspecialchars($imageSrc) . '" class="rounded img-fluid img-fixed-size" alt="SCP image">
                        </div>
                        <div class="col-md-8 d-flex align-items-center">
                            <div class="container-fluid desc rounded">
                                <h1>' . htmlspecialchars($scp['subject']) . '</h1>
                                <h2>Containment Class: <span class="' . htmlspecialchars($scp['class']) . '">' . htmlspecialchars($scp['class']) . '</span></h2>

                                <a href="subject.php?id=' . htmlspecialchars($scp['id']) . '">
                                    <button class="read">View</button>
                                </a>

                                <div class="details">
                                    <p>' . htmlspecialchars($scp['description']) . '</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
            }

            $connection->close();
        ?>
    </div>

    <!-- Footer -->
    <div class="col-12 dark mid footer1"></div>

    <!-- script to show the delete message -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.onload = function() {
            if (typeof message !== "undefined" && message) {
                alert(message);
            }
        };
    </script>
</body>
</html>
