<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-logo">
            <i class="fas fa-tree"></i>
            <span>Tree Explorer</span>
        </div>
        <nav class="sidebar-menu">
            <div class="menu-item">
                <a href="home.php" class="menu-link">
                    <div class="menu-icon">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                    <span>Dashboard</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="qr.php" class="menu-link">
                    <div class="menu-icon">
                        <i class="fas fa-qrcode"></i>
                    </div>
                    <span>Tree & QR</span>
                </a>
            </div>
        </nav>
        <div class="sidebar-footer">
            <p>&copy; 2024 Tree Explorer</p>
        </div>
    </div>
    
    <div class="main-content">
        <div class="header">
            <div class="header-content">
                <h1>Central Philippine State University</h1>
                <p>Main - Campus Kabankalan City</p>
            </div>
        </div>
        
        <div class="content-containers">
            <div class="video-gallery-section">
                <div class="section-title">
                    <h2>Video Gallery</h2>
                </div>
                <div class="video-gallery-container">
                    <div class="video-player">
                        <div class="video-wrapper">
                            <video id="main-video" controls poster="path/to/poster1.jpg">
                                <source src="path/to/video1.mp4" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                        <div class="video-details">
                            <h4 id="video-title">Video Title 1</h4>
                            <p id="video-description">Description of video 1</p>
                        </div>
                    </div>
                    
                    <div class="video-navigation">
                        <div class="video-nav-icons">
                            <button id="prev-video" class="nav-icon-btn" title="Previous Video">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <button id="next-video" class="nav-icon-btn" title="Next Video">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                        <div class="video-action-icons">
                            <button id="upload-video" class="nav-icon-btn" title="Upload Video">
                                <i class="fas fa-cloud-upload-alt"></i>
                            </button>
                            <button id="edit-video" class="nav-icon-btn" title="Edit Video">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button id="delete-video" class="nav-icon-btn" title="Delete Video">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="map-section">
                <div class="section-title">
                    <h2>Location Map</h2>
                </div>
                <div class="map-container">
                    <div id="map" class="map-wrapper"></div>
                    <div class="map-actions">
                        <button id="locate-me" class="btn btn-primary">
                            <i class="fas fa-location-arrow"></i> Locate Me
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Simplified Nature-Inspired Upload Modal -->
    <div class="modal fade" id="uploadVideoModal" tabindex="-1" aria-labelledby="uploadVideoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg nature-modal">
            <div class="modal-content">
                <div class="modal-header nature-header">
                    <div class="nature-header-content">
                        <div class="nature-icon">
                            <i class="fas fa-leaf"></i>
                        </div>
                        <div class="nature-header-text">
                            <h5 class="modal-title">Share Your Tree's Story</h5>
                            <p class="modal-subtitle">Contribute to our forest knowledge</p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body nature-modal-body">
                    <form id="uploadTreeVideoForm" class="nature-form" method="POST" enctype="multipart/form-data" action="upload.php">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="treeName" class="form-label">Tree Name</label>
                                <input type="text" class="form-control nature-input" id="treeName" name="treeName" 
                                       placeholder="e.g., Ancient Oak" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="scientificName" class="form-label">Scientific Name</label>
                                <input type="text" class="form-control nature-input" id="scientificName" name="scientificName" 
                                       placeholder="e.g., Quercus robur" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="treeDescription" class="form-label">Tree Description</label>
                            <textarea class="form-control nature-textarea" id="treeDescription" name="treeDescription" 
                                      rows="3" placeholder="Share the unique story of this tree" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="videoFile" class="form-label">Upload Tree Video</label>
                            <div class="nature-drag-zone" id="dragDropZone">
                                <input type="file" id="videoFile" name="videoFile" accept="video/*" class="file-input" required>
                                <div class="drag-content">
                                    <i class="fas fa-cloud-upload-alt upload-icon"></i>
                                    <p class="upload-text">Drag Your Tree's Video Here</p>
                                    <span class="upload-subtitle">or</span>
                                    <label for="videoFile" class="btn nature-btn">Browse Files</label>
                                </div>
                                <div class="file-preview" id="filePreview" style="display:none;">
                                    <div class="file-info">
                                        <i class="fas fa-file-video"></i>
                                        <div class="file-details">
                                            <span id="fileName">No file selected</span>
                                            <span id="fileSize">0 KB</span>
                                        </div>
                                        <button type="button" class="btn-close" id="removeFile" aria-label="Remove file"></button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-text">Accepted formats: MP4, AVI, MOV (Max 100MB)</div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer nature-footer">
                    <button type="button" class="btn nature-btn-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="button" class="btn nature-btn-success" id="submitVideoUpload">
                        <i class="fas fa-upload"></i> Contribute
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Video Modal -->
    <div class="modal fade" id="editVideoModal" tabindex="-1" aria-labelledby="editVideoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg nature-modal">
            <div class="modal-content">
                <div class="modal-header nature-header">
                    <div class="nature-header-content">
                        <div class="nature-icon">
                            <i class="fas fa-edit"></i>
                        </div>
                        <div class="nature-header-text">
                            <h5 class="modal-title">Edit Tree Video</h5>
                            <p class="modal-subtitle">Update your tree's information</p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body nature-modal-body">
                    <form id="editTreeVideoForm" class="nature-form">
                        <input type="hidden" id="editVideoIndex">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="editTreeName" class="form-label">Tree Name</label>
                                <input type="text" class="form-control nature-input" id="editTreeName" 
                                       placeholder="e.g., Ancient Oak" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="editScientificName" class="form-label">Scientific Name</label>
                                <input type="text" class="form-control nature-input" id="editScientificName" 
                                       placeholder="e.g., Quercus robur" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="editTreeDescription" class="form-label">Tree Description</label>
                            <textarea class="form-control nature-textarea" id="editTreeDescription" 
                                      rows="3" placeholder="Share the unique story of this tree" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="editVideoFile" class="form-label">Update Video (Optional)</label>
                            <div class="nature-drag-zone" id="editDragDropZone">
                                <input type="file" id="editVideoFile" accept="video/*" class="file-input">
                                <div class="drag-content">
                                    <i class="fas fa-cloud-upload-alt upload-icon"></i>
                                    <p class="upload-text">Drag New Video Here</p>
                                    <span class="upload-subtitle">or</span>
                                    <label for="editVideoFile" class="btn nature-btn">Browse Files</label>
                                </div>
                                <div class="file-preview" id="editFilePreview" style="display:none;">
                                    <div class="file-info">
                                        <i class="fas fa-file-video"></i>
                                        <div class="file-details">
                                            <span id="editFileName">No file selected</span>
                                            <span id="editFileSize">0 KB</span>
                                        </div>
                                        <button type="button" class="btn-close" id="editRemoveFile" aria-label="Remove file"></button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-text">Optional: Replace current video (MP4, AVI, MOV)</div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer nature-footer">
                    <button type="button" class="btn nature-btn-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="button" class="btn nature-btn-success" id="submitEditVideo">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteVideoModal" tabindex="-1" aria-labelledby="deleteVideoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header nature-header">
                    <div class="nature-header-content">
                        <div class="nature-icon" style="background-color: rgba(231, 76, 60, 0.2);">
                            <i class="fas fa-trash-alt" style="color: #e74c3c;"></i>
                        </div>
                        <div class="nature-header-text">
                            <h5 class="modal-title">Confirm Deletion</h5>
                            <p class="modal-subtitle">Are you sure you want to delete this video?</p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <div class="delete-video-details">
                        <h6>Video Details:</h6>
                        <p><strong>Tree Name:</strong> <span id="deleteTreeName">-</span></p>
                        <p><strong>Scientific Name:</strong> <span id="deleteScientificName">-</span></p>
                    </div>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i> 
                        This action cannot be undone. The video will be permanently removed.
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteVideo">
                        <i class="fas fa-trash-alt"></i> Delete
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="map.js"></script>
</body>
</html>

