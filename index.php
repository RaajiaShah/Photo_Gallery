<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photo Gallery</title>
    <!-- Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
    <!-- Font-Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Custom CSS Files -->
    <link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
    <link rel="stylesheet" href="css/responsive.css" type="text/css" media="all" />

</head>

<body>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="fas fa-camera-retro"></i> Photo Gallery
            </a>
        </div>
    </nav>

    <!-- Header Section -->
    <header class="text-white text-center py-5">
        <h1 class="display-4">Welcome to the <span class="text-photo">Photo Gallery</span></h1>
        <p class="lead">
            Browse and upload your favorite images
        </p>
        <button type="button" class="btn btn-primary w-50 py-2" data-bs-toggle="modal" data-bs-target="#uploadModal">
            Upload Image
            <i class="fas fa-upload"></i>
        </button>
    </header>

    <!-- Upload Image Modal -->
    <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadModalLabel">Upload New Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="upload_image.php" method="post" enctype="multipart/form-data" id="uploadForm" class="row g-3">
                        <div class="col-md-6">
                            <label for="imageTitle" class="form-label">Image Title</label>
                            <input type="text" class="form-control" name="imageTitle" id="imageTitle" placeholder="Enter image title" required>
                        </div>
                        <div class="col-md-6">
                            <label for="imageFile" class="form-label">Upload Image</label>
                            <input type="file" class="form-control" name="imageFile" id="imageFile" accept="image/*" onchange="previewImage(this)">
                        </div>
                        <div class="col-12">
                            <img id="imagePreview" src="" class="img-fluid mt-3 d-none" alt="Current Image" style="max-width: 300px;">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary w-100 py-2">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Photo Gallery Section -->
    <div class="container my-5">
        <div class="row">
            <!-- Heading and Text-->
            <div class="col-12 text-center mb-4">
                <h2 class="display-4 heading-with-underline">Explore Our Photo Gallery</h2>
                <p>
                    Browse through a collection of stunning images showcasing our products and services.
                </p>
            </div>

            <!-- Main Carousel Section -->
            <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner" id="carouselItems">
                    <?php
                    include 'db_config.php';

                    $query = "SELECT * FROM images";
                    $result = mysqli_query($conn, $query);

                    if (mysqli_num_rows($result) > 0) {
                        $active = "active";
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "
                            <div class='carousel-item $active' id='carousel-item-{$row['id']}'>
                                <a href='{$row['file_path']}' data-lightbox='carousel' data-title='{$row['title']}'>
                                    <img src='{$row['file_path']}' class='d-block w-100 img-fluid rounded' alt='{$row['title']}'>
                                </a>
                                <div class='image-caption text-center position-absolute bottom-0 start-0 w-100 p-2 bg-dark bg-opacity-50 text-white'>
                                    {$row['title']}
                                </div>
                            </div>
                        ";
                            $active = ''; // Remove active class after first image
                        }
                    } else {
                        echo "<p>No images found in the gallery.</p>";
                    }
                    ?>
                </div>

                <!-- Carousel Controls -->
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>

            <!-- Thumbnails Section -->
            <div class="d-flex mt-3" id="thumbnail-container">
                <?php
                mysqli_data_seek($result, 0);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "
                    <div class='thumbnail-item position-relative'>
                        <img src='{$row['file_path']}' class='img-thumbnail thumbnail-image' data-id='{$row['id']}' alt='{$row['title']}' onclick='changeCarouselImage({$row['id']})'>
                        <button class='icon-btn edit-icon position-absolute top-0 start-0' onclick='openEditForm({$row['id']})'>
                            <i class='fas fa-pencil-alt'></i>
                        </button>
                        <button class='icon-btn delete-icon position-absolute top-0 end-0' onclick='deleteImage({$row['id']})'>
                            <i class='fas fa-trash'></i>
                        </button>
                    </div>
                ";
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Edit Form Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm" action="update_image.php" method="post" enctype="multipart/form-data" class="row g-3">
                        <input type="hidden" id="editModalId" name="id">
                        <div class="col-md-6">
                            <label for="editModalLabel" class="form-label">Image Title</label>
                            <input type="text" class="form-control" id="editModalTitle" name="imageTitle" required>
                        </div>
                        <div class="col-md-6">
                            <label for="editModalImage" class="form-label">Update Image</label>
                            <input type="file" class="form-control" id="editModalImage" name="image" accept="image/*" onchange="previewEditImage(this)">
                        </div>
                        <div class="col-12">
                            <img id="editModalImagePreview" src="" class="img-fluid mt-3" alt="Current Image" style="max-width: 300px;">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary w-100 py-2">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-white text-center py-3 mt-5">
        <p>
            &copy; 2024 Photo Gallery. All rights reserved.
        </p>
    </footer>

    <!-- JavaScript Files -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox-plus-jquery.min.js"></script>
    <!-- Custom JS File -->
    <script src="js/script.js"></script>

</body>
</html>