<?php
require 'db_connect.php'; // Including the database connection file

// Handle form submission
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lastName = htmlspecialchars($_POST['Lname']);
    $firstName = htmlspecialchars($_POST['Fname']);
    $username = htmlspecialchars($_POST['username']);
    $affiliation = htmlspecialchars($_POST['affiliation']);
    $email = htmlspecialchars($_POST['email']);
    $resume = $_FILES['resume'];

    // Validate resume file type
    if ($resume['type'] !== 'application/pdf') {
        $message = "Only PDF files are allowed for the resume.";
    } else {
        // Save resume file
        $resumeDir = 'uploads/resumes/';
        $resumePath = $resumeDir . uniqid() . '-' . basename($resume['name']);
        if (move_uploaded_file($resume['tmp_name'], $resumePath)) {
            // Insert data into the database with default status 'pending'
            $stmt = $pdo->prepare("INSERT INTO editor_reviewer_applications (last_name, first_name, username, affiliation, email, resume_path, status) 
                                   VALUES (:last_name, :first_name, :username, :affiliation, :email, :resume_path, 'pending')");
            $stmt->bindParam(':last_name', $lastName);
            $stmt->bindParam(':first_name', $firstName);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':affiliation', $affiliation);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':resume_path', $resumePath);

            if ($stmt->execute()) {
                $message = "Your application has been submitted. Please wait for the admin to accept your application.";
            } else {
                $message = "Error submitting your application.";
            }
        } else {
            $message = "Error uploading your resume.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editor or Reviewer Application</title>
    <link rel="stylesheet" href="css/nav/signup.css">
    <style>
        .password-container {
            position: relative;
        }

        .toggle-icon {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            width: 20px;
            height: 20px;
        }
    </style>
</head>

<body>
    <div class="navbar">
        <div class="navbar-logo">
            <img src="photos/logo.png" alt="Logo">
            <span>Scriptura</span>
        </div>

        <div class="navbar-links">
            <a href="index.php">Home</a>
            <a href="archives.html">Archives</a>
          
            <a href="/nav/submission.html">Submissions</a>
            <div class="dropdown">
                <a href="/nav/aboutus.html">About</a>
                <div class="dropdown-content">
                    <a href="/nav/announcement.php">Announcements</a>
                    <a href="/nav/editorial.php">Editorial Team</a>
                    <a href="/nav/aboutus.html">About Us</a>
                    <a href="/nav/contactus.html">Contact Us</a>
                </div>
            </div>
        </div>

        <div class="auth-section">
            <div class="search-bar">
                <a href="search.html">
                    <img src="photos/search.png" alt="Search">
                    <span>Search</span>
                </a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="image-section">
            <img src="photos/read.png" alt="Collection 2018">
            <div class="overlay-text">#SCRIPTURA</div>
        </div>
        <div class="form-section">
            <h1>Apply as an Editor or Reviewer</h1>
            <br><br>
            <?php if ($message): ?>
            <p style="color: red;">
                <?= htmlspecialchars($message); ?>
            </p>
            <?php endif; ?>
            <form action="contact_form.php" method="POST" enctype="multipart/form-data">
                <div class="name-fields">
                    <div class="input-group">
                        <label for="last-name">Last Name</label>
                        <input type="text" id="last-name" name="Lname" required>
                    </div>
                    <div class="input-group">
                        <label for="first-name">First Name</label>
                        <input type="text" id="first-name" name="Fname" required>
                    </div>
                </div>

                <div class="input-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>

                <div class="input-group">
                    <label for="affiliation">Apply as:</label>
                    <select id="affiliation" name="affiliation" required>
                        <option value="" disabled selected></option>
                        <option value="editor">Editor</option>
                        <option value="reviewer">Reviewer</option>
                    </select>
                </div>

                <div class="input-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="input-group">
                    <label for="resume">Upload Resume (PDF only)</label>
                    <input type="file" id="resume" name="resume" accept="application/pdf" required>
                </div>

                <br>
                <button type="submit" class="register-btn">Submit Application</button>
            </form>

            <p class="signin-link">Already have an account? <a href="register/signin.php">Sign In</a></p>
        </div>
    </div>

    <script>
        // Optional JavaScript for future use
    </script>

</body>

</html>
