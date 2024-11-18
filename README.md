# Photo Gallery CRUD Application

## Description
This project is a dynamic photo gallery web application that allows users to:
- **Create**: Upload new images with titles.
- **Read**: Browse and view images in a carousel and thumbnail layout.
- **Update**: Edit image titles and replace existing images.
- **Delete**: Remove images from the gallery.

The application uses PHP and MySQL for the backend and Bootstrap for the frontend.

---

## Features
- **Image Uploading**: Upload images with titles via a modal form.
- **Carousel View**: View images in a responsive carousel with captions.
- **Thumbnail Navigation**: Easily navigate the gallery through thumbnails.
- **Edit**: Update image with titles via a modal form.
- **Delete**: Delete images with a single click.
- **Lightbox Integration**: View full-sized images in a lightbox.

---

## Installation Instructions

### Prerequisites
1. Install **XAMPP** or any LAMP/WAMP stack with PHP and MySQL support.
2. A web browser (e.g., Chrome, Firefox).

### Steps
1. Clone or download the project:
    ```bash
    git clone https://github.com/RaajiaShah/Photo_Gallery.git
    ```
2. Place the project in the `htdocs` folder of your XAMPP or equivalent server directory.

3. Start Apache and MySQL from the XAMPP control panel.

4. Import the database:
   - Open `phpMyAdmin`.
   - Create a database named `photo_gallery`.
   - Import the `photo_gallery.sql` file located in the project folder named database.

5. Update `db_config.php` with your database credentials:
    ```php
    $host = "localhost";
    $username = "root"; // Replace with your username
    $password = "";     // Replace with your password
    $dbname = "photo_gallery";
    ```

---

## How to Operate

### Adding Images
1. Click the **Upload Image** button on the homepage.
2. Fill out the form with the image title and select the image file.
3. Submit the form to add the image to the gallery.

### Viewing Images
1. Browse the images through the carousel.
2. Click on a thumbnail to navigate to a specific image.
3. Use the lightbox to view larger versions of images.

### Editing Images
1. Click the **Edit** icon (pencil) on the desired thumbnail.
2. Update the image title or upload a new image file.
3. Save changes.

### Deleting Images
1. Click the **Delete** icon (trash) on the desired thumbnail.
2. Confirm the deletion to remove the image from the gallery.

---

## Folder Structure

Photo_Gallery/
├── css/
│   ├── style.css
│   ├── responsive.css
├── js/
│   └── script.js
├── database/
│   └── gallery_db.sql
├── upload/
│   └── (Uploaded Images)
├── db_config.php
├── index.php
├── upload_image.php
├── update_image.php
├── delete_image.php
└── README.md

---

## Technologies Used
- **Frontend**: HTML, CSS, JavaScript, Bootstrap 5
- **Backend**: PHP
- **Database**: MySQL
- **Additional Libraries**: Lightbox2, FontAwesome

---

## License
This project is free to use for personal and educational purposes.

