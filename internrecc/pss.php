<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Profile Editor & Viewer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Existing CSS */
        body {
            background: url('https://th.bing.com/th/id/OIP.XZ1ptKXFloznpyPBDykNNAHaFj?w=1600&h=1200&rs=1&pid=ImgDetMain') no-repeat center center fixed;
            background-size: cover;
            color: #333;
        }
        .card {
            background: rgba(255, 255, 255, 0.8);
            border: none;
            border-radius: 10px;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
        .form-control {
            background: rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(0, 0, 0, 0.1);
            color: #333;
        }
        .form-control::placeholder {
            color: rgba(0, 0, 0, 0.5);
        }
        .form-control:focus {
            background: rgba(255, 255, 255, 0.9);
            border-color: rgba(0, 0, 0, 0.3);
            box-shadow: none;
        }
        textarea {
            resize: none;
        }
        .header-footer {
            background: rgba(255, 218, 185, 0.9);
            color: #333;
            padding: 10px 0;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }
        .footer {
            background: rgba(255, 218, 185, 0.9);
            color: #333;
            padding: 20px 0;
        }
        .progress {
            height: 20px;
            background: rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        .progress-bar {
            background: #808080;
            border-radius: 10px;
        }
        .profile-image-container {
            position: relative;
        }
        .image-upload-btn {
            position: absolute;
            top: 0;
            right: 0;
            transform: translate(50%, -50%);
            background: #ff6347;
            border: none;
            transition: background 0.3s ease;
        }
        .image-upload-btn:hover {
            background: #ff4500;
        }
        .btn-primary {
            background: #ff6347;
            border: none;
            transition: background 0.3s ease;
        }
        .btn-primary:hover {
            background: #ff4500;
        }
        .btn-success {
            background: #808080;
            border: none;
            transition: background 0.3s ease;
        }
        .btn-success:hover {
            background: #696969;
        }
        .btn-info {
            background: #ff6347;
            border: none;
            transition: background 0.3s ease;
        }
        .btn-info:hover {
            background: #ff4500;
        }
        #profileDisplay {
            padding: 20px;
        }
        #profileDisplay h2 {
            color: #ff6347;
        }
        #profileDisplay p {
            color: #333;
        }
        #profileDisplay .progress {
            margin-bottom: 10px;
        }
        #profileDisplay .progress-bar {
            background: #808080;
        }
        .section-title {
            color: #ff6347;
            margin-bottom: 15px;
        }

        /* New CSS for Passkey Form */
        #passkey-form {
            margin-top: 80px;
        }
        #passkey-form .card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        #passkey-form .form-control {
            background: rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(0, 0, 0, 0.1);
            color: #333;
        }
        #passkey-form .btn-primary {
            background: #ff6347;
            border: none;
        }
        #passkey-form .btn-primary:hover {
            background: #ff4500;
        }
        #passkey-form .btn-success {
            background: #808080;
            border: none;
        }
        #passkey-form .btn-success:hover {
            background: #696969;
        }
    </style>
</head>
<body>
    <!-- Thin Header -->
    <header class="header-footer py-2">
        <div class="container">
            <h3 class="text-center">INTERNREC</h3>
        </div>
    </header>

    <!-- Passkey Form -->
    <div id="passkey-form" class="container">
        <div class="card">
            <div class="card-body">
                <h3 class="text-center">Company Login</h3>
                <form id="emailForm">
                    <div class="form-group">
                        <label for="companyEmail">Enter your company email:</label>
                        <input type="email" class="form-control" id="companyEmail" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Send Passkey</button>
                </form>
                <div id="passkeySection" style="display: none;">
                    <div class="form-group">
                        <label for="passkey">Enter the passkey sent to your email:</label>
                        <input type="text" class="form-control" id="passkey" required>
                    </div>
                    <button type="button" class="btn btn-success" id="validatePasskeyBtn">Validate Passkey</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile View Page -->
    <div id="view-profile" class="container main-body" style="display: none; margin-top: 80px;">
        <div class="card">
            <div class="card-body" id="profileDisplay">
                <div class="text-center">
                    <img id="profileImageDisplay" src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="User" class="rounded-circle" width="150">
                    <h2 id="userNameDisplay">ISA Student</h2>
                    <p id="bioDisplay" class="text-muted">Add a short bio about yourself...</p>
                </div>

                <!-- Profile Details Section -->
                <div class="mt-4">
                    <h4 class="section-title">Profile Details</h4>
                    <div class="card">
                        <div class="card-body">
                            <p><strong>Full Name:</strong> <span id="fullNameDisplay"></span></p>
                            <p><strong>Email:</strong> <span id="emailDisplay"></span></p>
                            <p><strong>Phone:</strong> <span id="phoneDisplay"></span></p>
                            <p><strong>Address:</strong> <span id="addressDisplay"></span></p>
                        </div>
                    </div>
                </div>

                <!-- CV Section -->
                <div class="mt-4">
                    <h4 class="section-title">CV</h4>
                    <div class="card">
                        <div class="card-body">
                            <a id="cvDownloadLink" href="#" style="display: none;">Download CV</a>
                        </div>
                    </div>
                </div>

                <!-- Project Status Section -->
                <div class="mt-4">
                    <h4 class="section-title">Project Status</h4>
                    <div class="card">
                        <div class="card-body">
                            <p><strong>Web Design:</strong> <span id="webDesignStatusDisplay"></span>%</p>
                            <p><strong>Website Markup:</strong> <span id="websiteMarkupStatusDisplay"></span>%</p>
                            <p><strong>One Page:</strong> <span id="onePageStatusDisplay"></span>%</p>
                            <p><strong>Mobile Template:</strong> <span id="mobileTemplateStatusDisplay"></span>%</p>
                            <p><strong>Backend API:</strong> <span id="backendApiStatusDisplay"></span>%</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="text-muted">© 2023 INTERNREC. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script>
        $(document).ready(function () {
            // Handle email form submission
            $('#emailForm').submit(function (e) {
                e.preventDefault();
                const email = $('#companyEmail').val();

                $.ajax({
                    url: 'send_passkey.php',
                    type: 'POST',
                    data: { email: email },
                    success: function (response) {
                        const res = JSON.parse(response);
                        if (res.status === 'success') {
                            $('#passkeySection').show();
                            alert('Passkey sent to your email. Check your inbox.');
                        } else {
                            alert('Failed to send passkey. Please try again.');
                        }
                    }
                });
            });

            // Handle passkey validation
            $('#validatePasskeyBtn').click(function () {
                const enteredPasskey = $('#passkey').val();

                $.ajax({
                    url: 'validate_passkey.php',
                    type: 'POST',
                    data: { passkey: enteredPasskey },
                    success: function (response) {
                        const res = JSON.parse(response);
                        if (res.status === 'success') {
                            alert('Passkey validated successfully!');
                            $('#passkey-form').hide();
                            $('#view-profile').show(); // Show the profile view section
                            displayProfile(); // Display the student profile
                        } else {
                            alert('Invalid or expired passkey. Please try again.');
                        }
                    }
                });
            });

            // Function to display the student profile
            function displayProfile() {
                const profileData = {
                    fullName: "John Doe",
                    email: "john.doe@example.com",
                    phone: "123-456-7890",
                    address: "123 Main St, City, Country",
                    userName: "John Doe",
                    bio: "A passionate student with a love for coding.",
                    profileImage: "https://bootdey.com/img/Content/avatar/avatar7.png",
                    projectStatus: {
                        webDesign: 80,
                        websiteMarkup: 70,
                        onePage: 90,
                        mobileTemplate: 60,
                        backendApi: 50
                    },
                    cvFileName: "John_Doe_CV.pdf"
                };

                $('#profileImageDisplay').attr('src', profileData.profileImage);
                $('#userNameDisplay').text(profileData.userName);
                $('#bioDisplay').text(profileData.bio);
                $('#fullNameDisplay').text(profileData.fullName);
                $('#emailDisplay').text(profileData.email);
                $('#phoneDisplay').text(profileData.phone);
                $('#addressDisplay').text(profileData.address);
                $('#webDesignStatusDisplay').text(profileData.projectStatus.webDesign);
                $('#websiteMarkupStatusDisplay').text(profileData.projectStatus.websiteMarkup);
                $('#onePageStatusDisplay').text(profileData.projectStatus.onePage);
                $('#mobileTemplateStatusDisplay').text(profileData.projectStatus.mobileTemplate);
                $('#backendApiStatusDisplay').text(profileData.projectStatus.backendApi);

                // Display CV download link
                if (profileData.cvFileName) {
                    $('#cvDownloadLink').attr('href', 'path/to/cv/' + profileData.cvFileName).attr('download', profileData.cvFileName).text('Download CV').show();
                }
            }
        });
    </script>
</body>
</html>