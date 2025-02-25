
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tree Management System</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 d-md-block sidebar">
                <div class="sidebar-sticky">
                    <div class="sidebar-logo mb-4">
                        <i class="fas fa-tree"></i>
                        <span>Tree Explorer</span>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">
                                <i class="fas fa-qrcode me-2"></i>Tree Management
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="home.php">
                                <i class="fas fa-home me-2"></i>Dashboard
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Tree Management</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTreeModal">
                            <i class="fas fa-plus me-2"></i>Add New Tree
                        </button>
                    </div>
                </div>

                <!-- Tree Inventory Table -->
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-tree me-2"></i>Tree Inventory
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0" id="treeInventoryTable">
                                <thead>
                                    <tr>
                                        <th>QR Code</th>
                                        <th>Tree Name</th>
                                        <th>Scientific Name</th>
                                        <th>Description</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="treeTableBody">
                                    <!-- Dynamically populated rows will go here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Add Tree Modal -->
    <div class="modal fade" id="addTreeModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-plus-circle me-2"></i>Add New Tree
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addTreeForm" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="treeName" class="form-label">Tree Name</label>
                                <input type="text" class="form-control" id="treeName" name="treeName" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="scientificName" class="form-label">Scientific Name</label>
                                <input type="text" class="form-control" id="scientificName" name="scientificName" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="latitude" class="form-label">Latitude</label>
                                <input type="number" step="any" class="form-control" id="latitude" name="latitude" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="longitude" class="form-label">Longitude</label>
                                <input type="number" step="any" class="form-control" id="longitude" name="longitude" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="treeImage" class="form-label">Tree Image</label>
                            <input type="file" class="form-control" id="treeImage" name="treeImage" accept="image/*" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Tree</button>
                    </form>
                    <div id="qrCodeContainer" class="mt-3" style="display:none;">
                        <h5>Generated QR Code:</h5>
                        <img id="qrCodeImage" src="" alt="QR Code">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveTreeBtn">
                        <i class="fas fa-save me-2"></i>Save Tree
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- View Tree Modal -->
    <div class="modal fade" id="viewTreeModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tree Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="viewTreeModalBody">
                    <!-- Dynamic content will be inserted here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Tree Modal -->
    <div class="modal fade" id="editTreeModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Tree Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="editTreeModalBody">
                    <!-- Dynamic edit form will be inserted here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Save Tree Button Event Listener
        document.getElementById('saveTreeBtn').addEventListener('click', function() {
            // Create a debug log function
            function debugLog(message, data = null) {
                const logMessage = data 
                    ? `${message}: ${JSON.stringify(data, null, 2)}` 
                    : message;
                
                // Log to console
                console.log(logMessage);
                
                // Optional: Create a visible debug area on the page
                let debugArea = document.getElementById('debugArea');
                if (!debugArea) {
                    debugArea = document.createElement('div');
                    debugArea.id = 'debugArea';
                    debugArea.style.position = 'fixed';
                    debugArea.style.bottom = '0';
                    debugArea.style.left = '0';
                    debugArea.style.width = '100%';
                    debugArea.style.backgroundColor = 'rgba(0,0,0,0.7)';
                    debugArea.style.color = 'white';
                    debugArea.style.padding = '10px';
                    debugArea.style.zIndex = '1000';
                    document.body.appendChild(debugArea);
                }
                debugArea.innerHTML += `<p>${logMessage}</p>`;
            }

            // Collect form data
            const treeName = document.getElementById('treeName').value;
            const scientificName = document.getElementById('scientificName').value;
            const description = document.getElementById('description').value;
            const latitude = document.getElementById('latitude').value;
            const longitude = document.getElementById('longitude').value;
            const treeImage = document.getElementById('treeImage').files[0];

            // Log form data
            debugLog('Form Data', {
                treeName,
                scientificName,
                description,
                latitude,
                longitude,
                treeImageName: treeImage ? treeImage.name : 'No image selected'
            });

            // Validate form
            const validationErrors = [];
            if (!treeName) validationErrors.push('Tree Name is required');
            if (!scientificName) validationErrors.push('Scientific Name is required');
            if (!description) validationErrors.push('Description is required');
            if (!latitude) validationErrors.push('Latitude is required');
            if (!longitude) validationErrors.push('Longitude is required');
            if (!treeImage) validationErrors.push('Tree Image is required');

            if (validationErrors.length > 0) {
                debugLog('Validation Errors', validationErrors);
                alert('Please fill in all fields:\n' + validationErrors.join('\n'));
                return;
            }

            // Create FormData for file upload
            const formData = new FormData();
            formData.append('treeName', treeName);
            formData.append('scientificName', scientificName);
            formData.append('description', description);
            formData.append('latitude', latitude);
            formData.append('longitude', longitude);
            formData.append('treeImage', treeImage);

            // Log FormData entries
            debugLog('FormData Entries');
            for (let [key, value] of formData.entries()) {
                debugLog(`${key}:`, value);
            }

            // Send AJAX request to generate QR code and save tree
            fetch('./qr_generator.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                // Log raw response details
                debugLog('Response Status', {
                    status: response.status,
                    statusText: response.statusText,
                    headers: Array.from(response.headers.entries())
                });

                if (!response.ok) {
                    // Try to get error details from response
                    return response.text().then(text => {
                        debugLog('Error Response Text', text);
                        throw new Error('Network response was not ok: ' + text);
                    });
                }
                return response.json();
            })
            .then(data => {
                // Log server response
                debugLog('Server Response', data);

                if (data.status === 'success') {
                    // Add new row to table
                    const tableBody = document.getElementById('treeTableBody');
                    const newRow = `
                        <tr>
                            <td>
                                <img src="${data.qr_code_path}" alt="QR Code" class="img-fluid" style="max-width: 100px;">
                            </td>
                            <td>${treeName}</td>
                            <td>${scientificName}</td>
                            <td>${description}</td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <button class="btn btn-info btn-sm" onclick="viewTree('${treeName}', '${scientificName}', '${description}')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-warning btn-sm" onclick="editTree('${treeName}', '${scientificName}', '${description}')">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm" onclick="deleteTree(this)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <button class="btn btn-success btn-sm" onclick="printQRCode('${data.qr_code_path}')">
                                        <i class="fas fa-print"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    `;
                    tableBody.innerHTML += newRow;

                    // Reset form
                    document.getElementById('addTreeForm').reset();

                    // Close the modal
                    bootstrap.Modal.getInstance(document.getElementById('addTreeModal')).hide();
                } else {
                    // Show detailed error message
                    const errorMessage = data.message || 'An unknown error occurred';
                    debugLog('Server Error', errorMessage);
                    alert(errorMessage);
                }
            })
            .catch(error => {
                // Log any fetch errors
                debugLog('Fetch Error', {
                    message: error.message,
                    stack: error.stack
                });
                alert('An error occurred while saving the tree. Please check the debug area for details.');
            });
        });

        // View Tree Function
        function viewTree(treeName, scientificName, description) {
            const modalBody = document.getElementById('viewTreeModalBody');
            modalBody.innerHTML = `
                <p><strong>Tree Name:</strong> ${treeName}</p>
                <p><strong>Scientific Name:</strong> ${scientificName}</p>
                <p><strong>Description:</strong> ${description}</p>
            `;
            new bootstrap.Modal(document.getElementById('viewTreeModal')).show();
        }

        // Edit Tree Function
        function editTree(treeName, scientificName, description) {
            const modalBody = document.getElementById('editTreeModalBody');
            modalBody.innerHTML = `
                <form id="editTreeForm">
                    <div class="mb-3">
                        <label for="editTreeName" class="form-label">Tree Name</label>
                        <input type="text" class="form-control" id="editTreeName" value="${treeName}" required>
                    </div>
                    <div class="mb-3">
                        <label for="editScientificName" class="form-label">Scientific Name</label>
                        <input type="text" class="form-control" id="editScientificName" value="${scientificName}" required>
                    </div>
                    <div class="mb-3">
                        <label for="editDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="editDescription" rows="3" required>${description}</textarea>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="saveEditedTree()">Save Changes</button>
                </form>
            `;
            new bootstrap.Modal(document.getElementById('editTreeModal')).show();
        }

        // Save Edited Tree Function
        function saveEditedTree() {
            const newTreeName = document.getElementById('editTreeName').value;
            const newScientificName = document.getElementById('editScientificName').value;
            const newDescription = document.getElementById('editDescription').value;

            // Find the current row and update it
            const rows = document.getElementById('treeTableBody').getElementsByTagName('tr');
            for (let row of rows) {
                const cells = row.getElementsByTagName('td');
                if (cells[1].textContent === treeName && cells[2].textContent === scientificName) {
                    cells[1].textContent = newTreeName;
                    cells[2].textContent = newScientificName;
                    cells[3].textContent = newDescription;
                    break;
                }
            }

            // Close the modal
            bootstrap.Modal.getInstance(document.getElementById('editTreeModal')).hide();
        }

        // Delete Tree Function
        function deleteTree(button) {
            if (confirm('Are you sure you want to delete this tree record?')) {
                button.closest('tr').remove();
            }
        }

        // Print QR Code Function
        function printQRCode(qrCodePath) {
            const printWindow = window.open('', '_blank');
            printWindow.document.write(`
                <html>
                    <head>
                        <title>Print QR Code</title>
                        <style>
                            body { text-align: center; }
                            img { max-width: 300px; }
                        </style>
                    </head>
                    <body>
                        <img src="${qrCodePath}" alt="Tree QR Code">
                        <script>
                            window.onload = function() {
                                window.print();
                                window.close();
                            }
                        <\/script>
                    </body>
                </html>
            `);
        }
    </script>
    <script src="map.js"></script>
</body>
</html>