<?php

include "connectiondb.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>User Profile Editor & Viewer</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        rel="stylesheet" />
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
        rel="stylesheet" />
    <style>
        body {
            background: url("https://th.bing.com/th/id/OIP.XZ1ptKXFloznpyPBDykNNAHaFj?w=1600&h=1200&rs=1&pid=ImgDetMain") no-repeat center center fixed;
            background-size: cover;
            color: #333;
            /* Dark text for better contrast */
        }

        .card {
            background: rgba(255,
                    255,
                    255,
                    0.8);
            /* Semi-transparent white background */
            border: none;
            border-radius: 10px;
            backdrop-filter: blur(10px);
            /* Add blur effect for glassmorphism */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .form-control {
            background: rgba(255,
                    255,
                    255,
                    0.8);
            /* Semi-transparent white background */
            border: 1px solid rgba(0, 0, 0, 0.1);
            /* Light border */
            color: #333;
            /* Dark text */
        }

        .form-control::placeholder {
            color: rgba(0, 0, 0, 0.5);
            /* Light placeholder text */
        }

        .form-control:focus {
            background: rgba(255,
                    255,
                    255,
                    0.9);
            /* Slightly darker on focus */
            border-color: rgba(0, 0, 0, 0.3);
            /* Brighter border on focus */
            box-shadow: none;
            /* Remove default Bootstrap shadow */
        }

        textarea {
            resize: none;
            /* Disable resizing for the bio textarea */
        }

        .header-footer {
            background: rgba(255, 218, 185, 0.9);
            /* Peach background */
            color: #333;
            /* Dark text */
            padding: 10px 0;
            /* Thinner header */
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }

        .footer {
            background: rgba(255, 218, 185, 0.9);
            /* Peach background */
            color: #333;
            /* Dark text */
            padding: 20px 0;
        }

        .progress {
            height: 20px;
            /* Make progress bars taller */
            background: rgba(0, 0, 0, 0.1);
            /* Light grey background */
            border-radius: 10px;
        }

        .progress-bar {
            background: #808080;
            /* Grey progress bar */
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
            /* Peach button background */
            border: none;
            transition: background 0.3s ease;
        }

        .image-upload-btn:hover {
            background: #ff4500;
            /* Darker peach on hover */
        }

        .btn-primary {
            background: #ff6347;
            /* Peach button background */
            border: none;
            transition: background 0.3s ease;
        }

        .btn-primary:hover {
            background: #ff4500;
            /* Darker peach on hover */
        }

        .btn-success {
            background: #808080;
            /* Grey button background */
            border: none;
            transition: background 0.3s ease;
        }

        .btn-success:hover {
            background: #696969;
            /* Darker grey on hover */
        }

        .btn-info {
            background: #ff6347;
            /* Peach button background */
            border: none;
            transition: background 0.3s ease;
        }

        .btn-info:hover {
            background: #ff4500;
            /* Darker peach on hover */
        }

        #profileDisplay {
            padding: 20px;
        }

        #profileDisplay h2 {
            color: #ff6347;
            /* Peach color for name */
        }

        #profileDisplay p {
            color: #333;
            /* Dark text */
        }

        #profileDisplay .progress {
            margin-bottom: 10px;
        }

        #profileDisplay .progress-bar {
            background: #808080;
            /* Grey progress bar */
        }

        .section-title {
            color: #ff6347;
            /* Peach color for section titles */
            margin-bottom: 15px;
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

    <!-- Profile Editing Page -->
    <div
        id="edit-profile"
        class="container main-body"
        style="margin-top: 80px">
        <div class="row gutters-sm">
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div
                            class="d-flex flex-column align-items-center text-center profile-image-container">
                            <img
                                id="profileImage"
                                src="https://bootdey.com/img/Content/avatar/avatar7.png"
                                alt="User"
                                class="rounded-circle"
                                width="150" />
                            <button
                                class="btn btn-primary image-upload-btn"
                                id="uploadImageBtn">
                                <i class="fas fa-camera"></i>
                            </button>
                            <input
                                type="file"
                                class="form-control-file"
                                id="imageUpload"
                                accept="image/*"
                                style="display: none" />
                            <div class="mt-3">
                                <h4 id="userName">ISA Student</h4>
                                <textarea
                                    id="bio"
                                    class="form-control mt-2"
                                    rows="3"
                                    placeholder="Add a short bio about yourself..."
                                    readonly></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Full Name</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input
                                    type="text"
                                    id="fullName"
                                    placeholder="Enter your full name"
                                    class="form-control"
                                    readonly />
                            </div>
                        </div>
                        <hr />
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Email</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input
                                    type="email"
                                    id="email"
                                    placeholder="Enter your email"
                                    class="form-control"
                                    readonly />
                            </div>
                        </div>
                        <hr />
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Phone</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input
                                    type="text"
                                    id="phone"
                                    placeholder="Enter your phone number"
                                    class="form-control"
                                    readonly />
                            </div>
                        </div>
                        <hr />
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Address</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input
                                    type="text"
                                    id="address"
                                    placeholder="Enter your address"
                                    class="form-control"
                                    readonly />
                            </div>
                        </div>
                        <hr />
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Upload CV</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input
                                    type="file"
                                    id="cvUpload"
                                    class="form-control-file"
                                    accept=".pdf,.doc,.docx" />
                            </div>
                        </div>
                        <hr />
                        <div class="row">
                            <div class="col-sm-12">
                                <button class="btn btn-info" id="editBtn">
                                    Edit
                                </button>
                                <button
                                    class="btn btn-success"
                                    id="saveBtn"
                                    style="display: none">
                                    Save
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-body">
                        <h6 class="d-flex align-items-center mb-3">
                            Project Status
                        </h6>
                        <div id="projectStatus">
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <small>Web Design</small>
                                    <input
                                        type="range"
                                        class="form-control-range"
                                        min="0"
                                        max="100"
                                        id="webDesignStatus"
                                        readonly />
                                </div>
                                <div class="col-sm-6">
                                    <div class="progress">
                                        <div
                                            class="progress-bar"
                                            role="progressbar"
                                            style="width: 0%"
                                            aria-valuenow="0"
                                            aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <small>Website Markup</small>
                                    <input
                                        type="range"
                                        class="form-control-range"
                                        min="0"
                                        max="100"
                                        id="websiteMarkupStatus"
                                        readonly />
                                </div>
                                <div class="col-sm-6">
                                    <div class="progress">
                                        <div
                                            class="progress-bar"
                                            role="progressbar"
                                            style="width: 0%"
                                            aria-valuenow="0"
                                            aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <small>One Page</small>
                                    <input
                                        type="range"
                                        class="form-control-range"
                                        min="0"
                                        max="100"
                                        id="onePageStatus"
                                        readonly />
                                </div>
                                <div class="col-sm-6">
                                    <div class="progress">
                                        <div
                                            class="progress-bar"
                                            role="progressbar"
                                            style="width: 0%"
                                            aria-valuenow="0"
                                            aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <small>Mobile Template</small>
                                    <input
                                        type="range"
                                        class="form-control-range"
                                        min="0"
                                        max="100"
                                        id="mobileTemplateStatus"
                                        readonly />
                                </div>
                                <div class="col-sm-6">
                                    <div class="progress">
                                        <div
                                            class="progress-bar"
                                            role="progressbar"
                                            style="width: 0%"
                                            aria-valuenow="0"
                                            aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <small>Backend API</small>
                                    <input
                                        type="range"
                                        class="form-control-range"
                                        min="0"
                                        max="100"
                                        id="backendApiStatus"
                                        readonly />
                                </div>
                                <div class="col-sm-6">
                                    <div class="progress">
                                        <div
                                            class="progress-bar"
                                            role="progressbar"
                                            style="width: 0%"
                                            aria-valuenow="0"
                                            aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-info" id="editProjectBtn">
                            Edit Project Status
                        </button>
                        <button
                            class="btn btn-success"
                            id="saveProjectBtn"
                            style="display: none">
                            Save Project Status
                        </button>
                    </div>
                </div>

                <!-- Save Button for Profile -->
                <div class="row">
                    <div class="col-sm-12">
                        <button class="btn btn-success" id="finalSaveBtn">
                            Save Profile
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile View Page -->
    <div
        id="view-profile"
        class="container main-body"
        style="display: none; margin-top: 80px">
        <div class="card">
            <div class="card-body" id="profileDisplay">
                <div class="text-center">
                    <img
                        id="profileImageDisplay"
                        src="https://bootdey.com/img/Content/avatar/avatar7.png"
                        alt="User"
                        class="rounded-circle"
                        width="150" />
                    <h2 id="userNameDisplay">ISA Student</h2>
                    <p id="bioDisplay" class="text-muted">
                        Add a short bio about yourself...
                    </p>
                </div>

                <!-- Profile Details Section -->
                <div class="mt-4">
                    <h4 class="section-title">Profile Details</h4>
                    <div class="card">
                        <div class="card-body">
                            <p>
                                <strong>Full Name:</strong>
                                <span id="fullNameDisplay"></span>
                            </p>
                            <p>
                                <strong>Email:</strong>
                                <span id="emailDisplay"></span>
                            </p>
                            <p>
                                <strong>Phone:</strong>
                                <span id="phoneDisplay"></span>
                            </p>
                            <p>
                                <strong>Address:</strong>
                                <span id="addressDisplay"></span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- CV Section -->
                <div class="mt-4">
                    <h4 class="section-title">CV</h4>
                    <div class="card">
                        <div class="card-body">
                            <a
                                id="cvDownloadLink"
                                href="#"
                                style="display: none">Download CV</a>
                        </div>
                    </div>
                </div>

                <!-- Project Status Section -->
                <div class="mt-4">
                    <h4 class="section-title">Project Status</h4>
                    <div class="card">
                        <div class="card-body">
                            <p>
                                <strong>Web Design:</strong>
                                <span id="webDesignStatusDisplay"></span>%
                            </p>
                            <p>
                                <strong>Website Markup:</strong>
                                <span id="websiteMarkupStatusDisplay"></span>%
                            </p>
                            <p>
                                <strong>One Page:</strong>
                                <span id="onePageStatusDisplay"></span>%
                            </p>
                            <p>
                                <strong>Mobile Template:</strong>
                                <span
                                    id="mobileTemplateStatusDisplay"></span>%
                            </p>
                            <p>
                                <strong>Backend API:</strong>
                                <span id="backendApiStatusDisplay"></span>%
                            </p>
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
        $(document).ready(function() {
            // Edit profile
            $("#editBtn").click(function() {
                $('input[type="text"], input[type="email"], textarea').attr(
                    "readonly",
                    false
                );
                $(this).hide();
                $("#saveBtn").show();
            });

            // Save profile
            $("#saveBtn").click(function() {
                const profileData = {
                    fullName: $("#fullName").val(),
                    email: $("#email").val(),
                    phone: $("#phone").val(),
                    address: $("#address").val(),
                    userName: $("#userName").text(),
                    bio: $("#bio").val(),
                    profileImage: $("#profileImage").attr("src"),
                    projectStatus: {
                        webDesign: $("#webDesignStatus").val(),
                        websiteMarkup: $("#websiteMarkupStatus").val(),
                        onePage: $("#onePageStatus").val(),
                        mobileTemplate: $("#mobileTemplateStatus").val(),
                        backendApi: $("#backendApiStatus").val(),
                    },
                    cvFileName: localStorage.getItem("userCVFileName"),
                };

                localStorage.setItem(
                    "userProfile",
                    JSON.stringify(profileData)
                );
                alert("Profile saved!");
                $('input[type="text"], input[type="email"], textarea').attr(
                    "readonly",
                    true
                );
                $(this).hide();
                $("#editBtn").show();

                // Show the profile view page
                $("#edit-profile").hide();
                $("#view-profile").show();
                displayProfile();
            });

            // Edit project status
            $("#editProjectBtn").click(function() {
                $('input[type="range"]').attr("readonly", false);
                $(this).hide();
                $("#saveProjectBtn").show();
            });

            // Save project status
            $("#saveProjectBtn").click(function() {
                $('input[type="range"]').attr("readonly", true);
                $(this).hide();
                $("#editProjectBtn").show();
                alert("Project status saved!");
            });

            // Final save
            $("#finalSaveBtn").click(function() {
                $("#messageBox").fadeIn().delay(5000).fadeOut();
            });

            // Display profile
            function displayProfile() {
                const profileData = JSON.parse(
                    localStorage.getItem("userProfile")
                );
                if (profileData) {
                    $("#profileImageDisplay").attr(
                        "src",
                        profileData.profileImage
                    );
                    $("#userNameDisplay").text(profileData.userName);
                    $("#bioDisplay").text(profileData.bio);
                    $("#fullNameDisplay").text(profileData.fullName);
                    $("#emailDisplay").text(profileData.email);
                    $("#phoneDisplay").text(profileData.phone);
                    $("#addressDisplay").text(profileData.address);
                    $("#webDesignStatusDisplay").text(
                        profileData.projectStatus.webDesign
                    );
                    $("#websiteMarkupStatusDisplay").text(
                        profileData.projectStatus.websiteMarkup
                    );
                    $("#onePageStatusDisplay").text(
                        profileData.projectStatus.onePage
                    );
                    $("#mobileTemplateStatusDisplay").text(
                        profileData.projectStatus.mobileTemplate
                    );
                    $("#backendApiStatusDisplay").text(
                        profileData.projectStatus.backendApi
                    );

                    // Display CV download link if CV exists
                    const cvFileName = profileData.cvFileName;
                    if (cvFileName) {
                        const cvData = localStorage.getItem("userCV");
                        if (cvData) {
                            $("#cvDownloadLink")
                                .attr("href", cvData)
                                .attr("download", cvFileName)
                                .text("Download CV")
                                .show();
                        }
                    }
                } else {
                    $("#profileDisplay").html(
                        "<p>No profile data found.</p>"
                    );
                }
            }

            // Image upload functionality
            $("#uploadImageBtn").click(function() {
                $("#imageUpload").click(); // Trigger the file input
            });

            $("#imageUpload").change(function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $("#profileImage").attr("src", e.target.result);
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Handle CV upload
            $("#cvUpload").change(function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const cvData = e.target.result;
                        localStorage.setItem("userCV", cvData);
                        localStorage.setItem("userCVFileName", file.name);
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
</body>

</html>
