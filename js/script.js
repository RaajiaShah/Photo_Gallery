// JavaScript for image modal functionality
document.addEventListener("DOMContentLoaded", function () {
    const modalImage = document.getElementById("modalImage");

    document.querySelectorAll(".gallery-img").forEach(img => {
        img.addEventListener("click", function () {
            modalImage.src = this.src;
        });
    });
});


// Preview the selected image in the upload image modal
function previewImage(input) {
    const preview = document.getElementById("imagePreview");

    if (input.files && input.files[0]) {
        const file = input.files[0];

        // Validate file type
        const validExtensions = ["image/jpeg", "image/png", "image/gif"];
        if (!validExtensions.includes(file.type)) {
            alert("Please upload an image file (jpg, png, gif).");
            input.value = ""; 
            preview.classList.add("d-none");
            return;
        }

        // Validate file size 
        const maxSize = 2 * 1024 * 1024; 
        if (file.size > maxSize) {
            alert("File size should not exceed 2MB.");
            input.value = ""; 
            preview.classList.add("d-none");
            return;
        }

        // Display image preview
        const reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.classList.remove("d-none");
        };
        reader.readAsDataURL(file);
    } else {
        preview.classList.add("d-none");
    }
}

// Function to replace the carousel image with the selected thumbnail
function changeCarouselImage(id) {
    const carousel = document.querySelector('#carouselExample .carousel-inner');
    const items = carousel.querySelectorAll('.carousel-item');

    const selectedItem = document.querySelector(`img[data-id="${id}"]`);

    if (selectedItem) {
       
        const activeItem = carousel.querySelector('.carousel-item.active');
        if (activeItem) {
            activeItem.classList.remove('active');
        }

        const newActiveItem = document.getElementById(`carousel-item-${id}`);
        if (newActiveItem) {
            newActiveItem.classList.add('active');
        }
    }
}


// Preview the selected image in the edit modal
function previewEditImage(input) {
    const preview = document.getElementById('editModalImagePreview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = (e) => {
            preview.src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function openEditForm(id) {
    const modalTitle = document.getElementById('editModalTitle');
    const modalIdInput = document.getElementById('editModalId');
    const modalLabelInput = document.getElementById('editModalLabel');
    const modalImagePreview = document.getElementById('editModalImagePreview');

    const thumbnail = document.querySelector(`[data-id="${id}"]`);
    if (thumbnail) {
        modalTitle.textContent = `Edit Image #${id}`;
        modalIdInput.value = id; 
        modalLabelInput.value = thumbnail.getAttribute('data-label'); 
        modalImagePreview.src = thumbnail.src; 
    }

    const editModal = new bootstrap.Modal(document.getElementById('editModal'));
    editModal.show();
}

// Handle form submission with AJAX
document.getElementById('editForm').addEventListener('submit', function (event) {
    event.preventDefault(); 

    const formData = new FormData(this);

    fetch('update_image.php', {
        method: 'POST',
        body: formData,
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Image updated successfully!');

              
                const carouselItem = document.querySelector(`#carousel-item-${data.id}`);
                if (carouselItem) {
                    const image = carouselItem.querySelector('img');
                    const caption = carouselItem.querySelector('.image-caption');

                   
                    image.src = data.new_image;
                    caption.textContent = data.new_title;
                }

             
                const thumbnail = document.querySelector(`[data-id="${data.id}"]`);
                if (thumbnail) {
                    thumbnail.src = data.new_image;
                    thumbnail.setAttribute('data-label', data.new_title);  
                }

              
                const lightboxLink = carouselItem.querySelector('a');
                if (lightboxLink) {
                    lightboxLink.setAttribute('href', data.new_image); 
                    lightboxLink.setAttribute('data-title', data.new_title);  
                }

              
                if (typeof lightbox !== 'undefined' && lightbox.refresh) {
                    lightbox.refresh();  
                }

                const editModal = new bootstrap.Modal(document.getElementById('editModal'));
                editModal.hide();
            } else {
                alert('There was an error updating the image.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to update the image.');
        });
});

// Function to delete the selected image  
function deleteImage(id) {
    if (confirm('Are you sure you want to delete this image?')) {
        window.location.href = `delete_image.php?id=${id}`;
    }
}
