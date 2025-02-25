document.addEventListener('DOMContentLoaded', function() {
    const mainVideo = document.getElementById('main-video');
    const videoWrapper = document.querySelector('.video-wrapper');
    const videoTitle = document.getElementById('video-title');
    const videoDescription = document.getElementById('video-description');
    const prevButton = document.getElementById('prev-video');
    const nextButton = document.getElementById('next-video');
    
    const videos = [
        { 
            src: 'path/to/video1.mp4', 
            title: 'Video Title 1', 
            description: 'Description of video 1',
            poster: 'path/to/poster1.jpg'
        },
        { 
            src: 'path/to/video2.mp4', 
            title: 'Video Title 2', 
            description: 'Description of video 2',
            poster: 'path/to/poster2.jpg'
        },
        { 
            src: 'path/to/video3.mp4', 
            title: 'Video Title 3', 
            description: 'Description of video 3',
            poster: 'path/to/poster3.jpg'
        }
    ];
    
    let currentVideoIndex = 0;

    function updateVideo(index) {
        if (videos.length === 0) {
            // No videos available
            mainVideo.src = '';
            videoTitle.textContent = 'No Videos';
            videoDescription.textContent = 'Add a new video to get started';
            return;
        }

        const video = videos[index];
        
        // Add fade-out effect
        videoWrapper.classList.add('video-transition-out');
        
        // Wait for transition to complete
        setTimeout(() => {
            mainVideo.src = video.src;
            mainVideo.poster = video.poster;
            videoTitle.textContent = video.title;
            videoDescription.textContent = video.description;
            
            // Remove fade-out, add fade-in
            videoWrapper.classList.remove('video-transition-out');
            videoWrapper.classList.add('video-transition-in');
            
            // Auto play the video
            mainVideo.play();
            
            // Remove fade-in after transition
            setTimeout(() => {
                videoWrapper.classList.remove('video-transition-in');
            }, 500);
        }, 250);
    }

    // Next Video Button
    nextButton.addEventListener('click', function() {
        if (videos.length > 0) {
            currentVideoIndex = (currentVideoIndex + 1) % videos.length;
            updateVideo(currentVideoIndex);
        }
    });

    // Previous Video Button
    prevButton.addEventListener('click', function() {
        if (videos.length > 0) {
            currentVideoIndex = (currentVideoIndex - 1 + videos.length) % videos.length;
            updateVideo(currentVideoIndex);
        }
    });

    // New Action Button Event Listeners
    const uploadButton = document.getElementById('upload-video');
    const editButton = document.getElementById('edit-video');
    const deleteButton = document.getElementById('delete-video');

    uploadButton.addEventListener('click', function() {
        const uploadModal = new bootstrap.Modal(document.getElementById('uploadVideoModal'));
        uploadModal.show();
    });

    editButton.addEventListener('click', function() {
        // Get current video details
        const currentVideo = videos[currentVideoIndex];

        // Populate edit form
        document.getElementById('editTreeName').value = currentVideo.treeName;
        document.getElementById('editScientificName').value = currentVideo.scientificName;
        document.getElementById('editTreeDescription').value = currentVideo.description;
        
        // Store current video index
        document.getElementById('editVideoIndex').value = currentVideoIndex;

        // Open modal
        const editModal = new bootstrap.Modal(document.getElementById('editVideoModal'));
        editModal.show();
    });

    deleteButton.addEventListener('click', function() {
        // Prevent deletion if no videos exist
        if (videos.length === 0) {
            alert('No videos to delete.');
            return;
        }

        // Populate delete modal with current video details
        const currentVideo = videos[currentVideoIndex];
        document.getElementById('deleteTreeName').textContent = currentVideo.treeName;
        document.getElementById('deleteScientificName').textContent = currentVideo.scientificName;

        // Show delete confirmation modal
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteVideoModal'));
        deleteModal.show();
    });

    // Confirm Delete Button
    document.getElementById('confirmDeleteVideo').addEventListener('click', function() {
        // Remove current video
        videos.splice(currentVideoIndex, 1);

        // Adjust current video index
        if (videos.length === 0) {
            // No videos left
            mainVideo.src = '';
            videoTitle.textContent = 'No Videos';
            videoDescription.textContent = 'Add a new video to get started';
            currentVideoIndex = -1;
        } else {
            // Ensure index is within bounds
            currentVideoIndex = currentVideoIndex % videos.length;
            updateVideo(currentVideoIndex);
        }

        // Close delete modal
        const deleteModal = bootstrap.Modal.getInstance(document.getElementById('deleteVideoModal'));
        deleteModal.hide();

        // Show success message
        alert('Video deleted successfully!');
    });

    // Leaflet Map Initialization
    const map = L.map('map').setView([0, 0], 2);
    
    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: ' OpenStreetMap contributors'
    }).addTo(map);

    // Add Geocoder Control
    L.Control.geocoder({
        defaultMarkGeocode: false
    })
    .on('markgeocode', function(e) {
        const { center, name } = e.geocode;
        
        // Clear previous markers
        map.eachLayer((layer) => {
            if (layer instanceof L.Marker) {
                map.removeLayer(layer);
            }
        });

        // Add new marker
        const marker = L.marker(center)
            .addTo(map)
            .bindPopup(name)
            .openPopup();

        // Center and zoom to location
        map.setView(center, 15);
    })
    .addTo(map);

    // Locate Me Button
    const locateButton = document.getElementById('locate-me');
    locateButton.addEventListener('click', function() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const { latitude, longitude } = position.coords;
                    
                    // Clear previous markers
                    map.eachLayer((layer) => {
                        if (layer instanceof L.Marker) {
                            map.removeLayer(layer);
                        }
                    });

                    // Add new marker and center map
                    const marker = L.marker([latitude, longitude])
                        .addTo(map)
                        .bindPopup(`Your Location<br>Lat: ${latitude.toFixed(4)}, Lng: ${longitude.toFixed(4)}`)
                        .openPopup();

                    // Center and zoom to location
                    map.setView([latitude, longitude], 15);
                },
                () => {
                    alert('Unable to retrieve your location');
                }
            );
        } else {
            alert('Geolocation is not supported by your browser');
        }
    });

    // Drag and Drop File Upload
    const dragDropZone = document.getElementById('dragDropZone');
    const fileInput = document.getElementById('videoFile');
    const filePreview = document.getElementById('filePreview');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');
    const removeFileBtn = document.getElementById('removeFile');
    const submitButton = document.getElementById('submitVideoUpload');

    // Drag and Drop Event Listeners
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dragDropZone.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        dragDropZone.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dragDropZone.addEventListener(eventName, unhighlight, false);
    });

    function highlight() {
        dragDropZone.classList.add('highlight');
    }

    function unhighlight() {
        dragDropZone.classList.remove('highlight');
    }

    // Handle file drop
    dragDropZone.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        handleFiles(files);
    }

    // Handle file input change
    fileInput.addEventListener('change', function(e) {
        handleFiles(this.files);
    });

    // Remove file
    removeFileBtn.addEventListener('click', function() {
        fileInput.value = ''; // Clear the file input
        filePreview.style.display = 'none';
        dragDropZone.classList.remove('file-selected');
    });

    function handleFiles(files) {
        if (files.length > 0) {
            const file = files[0];
            
            // Validate file type
            const validTypes = ['video/mp4', 'video/avi', 'video/mov'];
            if (!validTypes.includes(file.type)) {
                alert('Invalid file type. Please upload MP4, AVI, or MOV files.');
                return;
            }

            // Validate file size (100MB limit)
            if (file.size > 100 * 1024 * 1024) {
                alert('File is too large. Maximum size is 100MB.');
                return;
            }

            // Update file preview
            fileName.textContent = file.name;
            fileSize.textContent = formatFileSize(file.size);
            
            filePreview.style.display = 'block';
            dragDropZone.classList.add('file-selected');
        }
    }

    function formatFileSize(bytes) {
        if (bytes < 1024) return bytes + ' bytes';
        else if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
        else return (bytes / 1048576).toFixed(1) + ' MB';
    }

    // Submit Contribution
    submitButton.addEventListener('click', function() {
        const form = document.getElementById('uploadTreeVideoForm');
        
        // Validate form
        if (form.checkValidity()) {
            // Collect form data
            const treeName = document.getElementById('treeName').value;
            const scientificName = document.getElementById('scientificName').value;
            const treeDescription = document.getElementById('treeDescription').value;
            const videoFile = fileInput.files[0];

            if (videoFile) {
                // Create URL for the uploaded video
                const videoURL = URL.createObjectURL(videoFile);

                // Create new video object
                const newVideo = {
                    src: videoURL,
                    title: treeName,
                    description: treeDescription,
                    poster: '', // You might want to generate a poster from the video
                    treeName: treeName,
                    scientificName: scientificName
                };

                // Add to videos array (assuming this is defined in another script)
                if (typeof videos !== 'undefined') {
                    videos.push(newVideo);
                    
                    // Switch to the newly added video
                    currentVideoIndex = videos.length - 1;
                    updateVideo(currentVideoIndex);
                }

                // Close modal
                bootstrap.Modal.getInstance(document.getElementById('uploadVideoModal')).hide();

                // Optional: Show success message
                alert('Video successfully added to the gallery!');
            }
        } else {
            form.reportValidity();
        }
    });

    // Edit Video Functionality
    const editModal = new bootstrap.Modal(document.getElementById('editVideoModal'));
    const submitEditButton = document.getElementById('submitEditVideo');
    
    // Drag and Drop Event Listeners for Edit Modal
    const editFileName = document.getElementById('editFileName');
    const editFileSize = document.getElementById('editFileSize');
    const editRemoveFileBtn = document.getElementById('editRemoveFile');

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        editDragDropZone.addEventListener(eventName, preventDefaults, false);
    });

    ['dragenter', 'dragover'].forEach(eventName => {
        editDragDropZone.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        editDragDropZone.addEventListener(eventName, unhighlight, false);
    });

    // Edit File Input Handling
    editFileInput.addEventListener('change', function(e) {
        handleEditFiles(this.files);
    });

    editRemoveFileBtn.addEventListener('click', function() {
        editFileInput.value = ''; // Clear the file input
        editFilePreview.style.display = 'none';
        editDragDropZone.classList.remove('file-selected');
    });

    function handleEditFiles(files) {
        if (files.length > 0) {
            const file = files[0];
            
            // Validate file type
            const validTypes = ['video/mp4', 'video/avi', 'video/mov'];
            if (!validTypes.includes(file.type)) {
                alert('Invalid file type. Please upload MP4, AVI, or MOV files.');
                return;
            }

            // Validate file size (100MB limit)
            if (file.size > 100 * 1024 * 1024) {
                alert('File is too large. Maximum size is 100MB.');
                return;
            }

            // Update file preview
            editFileName.textContent = file.name;
            editFileSize.textContent = formatFileSize(file.size);
            
            editFilePreview.style.display = 'block';
            editDragDropZone.classList.add('file-selected');
        }
    }

    // Submit Edit
    submitEditButton.addEventListener('click', function() {
        const form = document.getElementById('editTreeVideoForm');
        
        if (form.checkValidity()) {
            const index = parseInt(document.getElementById('editVideoIndex').value);
            
            // Update video details
            videos[index].treeName = document.getElementById('editTreeName').value;
            videos[index].scientificName = document.getElementById('editScientificName').value;
            videos[index].description = document.getElementById('editTreeDescription').value;
            videos[index].title = videos[index].treeName;

            // Check if new video file is uploaded
            const newVideoFile = editFileInput.files[0];
            if (newVideoFile) {
                const videoURL = URL.createObjectURL(newVideoFile);
                videos[index].src = videoURL;
            }

            // Update current view
            updateVideo(index);

            // Close modal
            editModal.hide();

            // Show success message
            alert('Video details updated successfully!');
        } else {
            form.reportValidity();
        }
    });

    // Function to reset drag and drop zone
    function resetDragDropZone(dropZone, filePreview, fileInput) {
        fileInput.value = ''; // Clear file input
        filePreview.style.display = 'none';
        dropZone.classList.remove('file-selected', 'highlight');
    }

    // Upload Modal Reset
    const uploadModal = document.getElementById('uploadVideoModal');
    const uploadForm = document.getElementById('uploadTreeVideoForm');
    const uploadDragDropZone = document.getElementById('dragDropZone');
    const uploadFilePreview = document.getElementById('filePreview');
    const uploadFileInput = document.getElementById('videoFile');

    // Submit Upload Button
    document.getElementById('submitVideoUpload').addEventListener('click', function() {
        const form = document.getElementById('uploadTreeVideoForm');
        
        if (form.checkValidity()) {
            // Existing upload logic...

            // Reset form after successful upload
            form.reset();
            resetDragDropZone(uploadDragDropZone, uploadFilePreview, uploadFileInput);
            
            // Clear specific fields
            document.getElementById('treeName').value = '';
            document.getElementById('scientificName').value = '';
            document.getElementById('treeDescription').value = '';
        } else {
            form.reportValidity();
        }
    });

    // Edit Modal Reset
    const editForm = document.getElementById('editTreeVideoForm');
    const editDragDropZone = document.getElementById('editDragDropZone');
    const editFilePreview = document.getElementById('editFilePreview');
    const editFileInput = document.getElementById('editVideoFile');

    // Submit Edit Button
    document.getElementById('submitEditVideo').addEventListener('click', function() {
        const form = document.getElementById('editTreeVideoForm');
        
        if (form.checkValidity()) {
            // Existing edit logic...

            // Reset form after successful edit
            form.reset();
            resetDragDropZone(editDragDropZone, editFilePreview, editFileInput);
            
            // Clear specific edit fields
            document.getElementById('editTreeName').value = '';
            document.getElementById('editScientificName').value = '';
            document.getElementById('editTreeDescription').value = '';
        } else {
            form.reportValidity();
        }
    });

    // Additional reset on modal close
    uploadModal.addEventListener('hidden.bs.modal', function() {
        uploadForm.reset();
        resetDragDropZone(uploadDragDropZone, uploadFilePreview, uploadFileInput);
        
        // Clear specific fields
        document.getElementById('treeName').value = '';
        document.getElementById('scientificName').value = '';
        document.getElementById('treeDescription').value = '';
    });

    editModal.addEventListener('hidden.bs.modal', function() {
        editForm.reset();
        resetDragDropZone(editDragDropZone, editFilePreview, editFileInput);
        
        // Clear specific edit fields
        document.getElementById('editTreeName').value = '';
        document.getElementById('editScientificName').value = '';
        document.getElementById('editTreeDescription').value = '';
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const steps = document.querySelectorAll('.step');
    const sections = document.querySelectorAll('.upload-section');
    const nextStepBtn = document.getElementById('nextStep');
    const prevStepBtn = document.getElementById('prevStep');
    const submitBtn = document.getElementById('submitVideoUpload');

    let currentStep = 1;

    // Step Navigation Logic
    function updateStepUI() {
        // Update steps
        steps.forEach(step => {
            step.classList.remove('active', 'completed');
            if (parseInt(step.dataset.step) < currentStep) {
                step.classList.add('completed');
            }
            if (parseInt(step.dataset.step) === currentStep) {
                step.classList.add('active');
            }
        });

        // Update sections
        sections.forEach(section => {
            section.classList.remove('active');
        });
        document.getElementById(`${sections[currentStep-1].id}`).classList.add('active');

        // Update buttons
        prevStepBtn.style.display = currentStep > 1 ? 'inline-block' : 'none';
        nextStepBtn.style.display = currentStep < 3 ? 'inline-block' : 'none';
        submitBtn.style.display = currentStep === 3 ? 'inline-block' : 'none';

        // Update review section
        if (currentStep === 3) {
            document.getElementById('reviewTreeName').textContent = 
                document.getElementById('treeName').value || '-';
            document.getElementById('reviewScientificName').textContent = 
                document.getElementById('scientificName').value || '-';
            document.getElementById('reviewVideoName').textContent = 
                document.getElementById('fileName').textContent || '-';
        }
    }

    // Next Step
    nextStepBtn.addEventListener('click', function() {
        const currentSection = document.querySelector('.upload-section.active');
        const inputs = currentSection.querySelectorAll('input, textarea');
        
        // Validate inputs
        let isValid = true;
        inputs.forEach(input => {
            if (!input.checkValidity()) {
                input.reportValidity();
                isValid = false;
            }
        });

        if (isValid && currentStep < 3) {
            currentStep++;
            updateStepUI();
        }
    });

    // Previous Step
    prevStepBtn.addEventListener('click', function() {
        if (currentStep > 1) {
            currentStep--;
            updateStepUI();
        }
    });

    // Submit Contribution
    submitBtn.addEventListener('click', function() {
        // TODO: Implement actual upload logic
        alert('Thank you for your contribution!');
        // Close modal
        bootstrap.Modal.getInstance(document.getElementById('uploadVideoModal')).hide();
    });
});

document.addEventListener('DOMContentLoaded', function() {
    // Video Gallery Management
    let videos = [
        { 
            src: 'path/to/video1.mp4', 
            title: 'Video Title 1', 
            description: 'Description of video 1',
            poster: 'path/to/poster1.jpg',
            treeName: 'Initial Tree',
            scientificName: 'Initial Scientific Name'
        }
    ];

    const mainVideo = document.getElementById('main-video');
    const videoWrapper = document.querySelector('.video-wrapper');
    const videoTitle = document.getElementById('video-title');
    const videoDescription = document.getElementById('video-description');
    const prevButton = document.getElementById('prev-video');
    const nextButton = document.getElementById('next-video');
    
    let currentVideoIndex = 0;

    function updateVideo(index) {
        if (videos.length === 0) {
            // No videos available
            mainVideo.src = '';
            videoTitle.textContent = 'No Videos';
            videoDescription.textContent = 'Add a new video to get started';
            return;
        }

        const video = videos[index];
        
        // Add fade-out effect
        videoWrapper.classList.add('video-transition-out');
        
        // Wait for transition to complete
        setTimeout(() => {
            mainVideo.src = video.src;
            mainVideo.poster = video.poster;
            videoTitle.textContent = video.title;
            videoDescription.textContent = video.description;
            
            // Remove fade-out, add fade-in
            videoWrapper.classList.remove('video-transition-out');
            videoWrapper.classList.add('video-transition-in');
            
            // Auto play the video
            mainVideo.play();
            
            // Remove fade-in after transition
            setTimeout(() => {
                videoWrapper.classList.remove('video-transition-in');
            }, 500);
        }, 250);
    }

    // Next Video Button
    nextButton.addEventListener('click', function() {
        if (videos.length > 0) {
            currentVideoIndex = (currentVideoIndex + 1) % videos.length;
            updateVideo(currentVideoIndex);
        }
    });

    // Previous Video Button
    prevButton.addEventListener('click', function() {
        if (videos.length > 0) {
            currentVideoIndex = (currentVideoIndex - 1 + videos.length) % videos.length;
            updateVideo(currentVideoIndex);
        }
    });

    // Submit Contribution (Modified to add video to gallery)
    document.getElementById('submitVideoUpload').addEventListener('click', function() {
        const formData = new FormData(document.getElementById('uploadTreeVideoForm'));
    
        fetch('upload.php', {
            method: 'POST',
            body: formData
        }).then(response => response.text())
          .then(data => {
              console.log(data);
              if (data.includes("Video uploaded successfully!")) {
                  // Optional: Add the video to the gallery as you did before
                  const videoFile = document.getElementById('videoFile').files[0];
                  const videoURL = URL.createObjectURL(videoFile);
    
                  const newVideo = {
                      src: videoURL,
                      title: formData.get('treeName'),
                      description: formData.get('treeDescription'),
                      poster: '', // You might want to generate a poster from the video
                      treeName: formData.get('treeName'),
                      scientificName: formData.get('scientificName')
                  };
    
                  videos.push(newVideo);
                  currentVideoIndex = videos.length - 1;
                  updateVideo(currentVideoIndex);
    
                  // Close modal
                  bootstrap.Modal.getInstance(document.getElementById('uploadVideoModal')).hide();
    
                  // Optional: Show success message
                  alert('Video successfully added to the gallery!');
              } else {
                  // Show error message
                  alert('Error uploading video: ' + data);
              }
          }).catch(error => {
              console.error('Error:', error);
              alert('Error uploading video.');
          });
    });
    
            // Close modal
            bootstrap.Modal.getInstance(document.getElementById('uploadVideoModal')).hide();

            // Optional: Show success message
            alert('Video successfully added to the gallery!');
        }
    );

    // Existing upload modal and drag-drop logic remains the same
;


