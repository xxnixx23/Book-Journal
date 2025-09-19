<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer autoload file
require 'vendor/autoload.php';

// Include database connection
include('db_connect.php');
session_start();  // Start session to store verification code and email

// Initialize variables
$email = $affiliation = "";
$email_err = $affiliation_err = "";

// Step 1: Handle form submission for email verification
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['verify_email'])) {
    $email = $_POST['email'];
    $affiliation = $_POST['affiliation'];

    // Determine the table to check email based on affiliation
    $table = '';
    switch ($affiliation) {
        case 'author':
            $table = 'authors';
            break;
        case 'reviewer':
            $table = 'reviewers';
            break;
        case 'editor':
            $table = 'editors';
            break;
        case 'reader':
            $table = 'readers';
            break;
        default:
            $affiliation_err = "Invalid affiliation selected.";
            break;
    }

    if ($table) {
        // Use PDO to query the database
        $query = "SELECT * FROM $table WHERE email = :email";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            // Email found, send verification code
            $verification_code = rand(100000, 999999);  // Random 6-digit code
            $_SESSION['verification_code'] = $verification_code;
            $_SESSION['email'] = $email;
            $_SESSION['affiliation'] = $affiliation;

            // PHPMailer setup
            $mail = new PHPMailer(true);

            try {
                // Email settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'itsyourgirlnikkiella@gmail.com';  // Your Gmail address
                $mail->Password = 'vzgc zglm wapi pvud';  // App-specific password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Email content
                $mail->setFrom('itsyourgirlnikkiella@gmail.com', 'Scriptura');
                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->Subject = 'Password Reset Verification';
                $mail->Body = "Your verification code is: <b>$verification_code</b>";

                if ($mail->send()) {
                    header("Location: forgotpass.php?step=2");  // Redirect to step 2
                    exit();
                } else {
                    echo 'Error: ' . $mail->ErrorInfo;
                }
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            $email_err = "No user found with this email in the selected affiliation.";
        }
    }
}

// Step 2: Handle verification code input
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['verify_code'])) {
    $entered_code = $_POST['verification_code'];
    $stored_code = $_SESSION['verification_code'] ?? '';
    $email = $_SESSION['email'] ?? '';

    if ($entered_code == $stored_code) {
        header("Location: forgotpass.php?step=3");  // Redirect to step 3
        exit();
    } else {
        $email_err = "Invalid verification code.";
    }
}

// Step 3: Handle password reset
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reset_password'])) {
    $new_password = $_POST['new-password'];
    $confirm_password = $_POST['new-confirm-password'];
    $email = $_SESSION['email'] ?? '';

    if ($new_password === $confirm_password) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Determine the table based on stored affiliation
        $affiliation = $_SESSION['affiliation'] ?? '';
        $table = '';
        switch ($affiliation) {
            case 'author':
                $table = 'authors';
                break;
            case 'reviewer':
                $table = 'reviewers';
                break;
            case 'editor':
                $table = 'editors';
                break;
            case 'reader':
                $table = 'readers';
                break;
        }

        if ($table) {
            $query = "UPDATE $table SET password = :password WHERE email = :email";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);

            if ($stmt->execute()) {
                // Set success message in session
                $_SESSION['password_reset_success'] = "Your password has been reset successfully!";
                unset($_SESSION['verification_code'], $_SESSION['email'], $_SESSION['affiliation']);  // Clear session data
                header("Location: forgotpass.php?step=success");  // Redirect to success message page
                exit();
            } else {
                echo "Error updating password.";
            }
        }
    } else {
        $email_err = "Passwords do not match.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="css/nav/signup.css">

    <style>
        .weak-password {
    border: 2px solid red;
}

.medium-password {
    border: 2px solid orange;
}

.strong-password {
    border: 2px solid green;
}

.password-container {
    position: relative;
    width: 100%;
}

.password-container input {
    width: 100%;
    padding-right: 30px; /* Space for the toggle button */
}

.toggle-password,
.toggle-confirm-password {
    position: absolute;
    right: 10px;  /* Adjust position as needed */
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
}


    </style>
</head>
<body>
    <div class="navbar">
        <!-- Logo and Name -->
        <div class="navbar-logo">
            <img src="photos/logo.png" alt="Logo">
            <span>Scriptura</span>
        </div>

        <div class="navbar-links">
            <a href="index.php">Home</a>
            <a href="../nav/archives.php">Archives</a>
            
            <a href="../nav/submission.php">Submissions</a>

            <div class="dropdown">
                <a href="../nav/aboutus.php">About</a>
                <div class="dropdown-content">
                    <a href="../nav/announcement.php">Announcements</a>
                    <a href="../nav/editorial.php">Editorial Team</a>
                    <a href="../nav/aboutus.php">About Us</a>
                    <a href="../nav/contactus.php">Contact Us</a>
                </div>
            </div>
        </div>

        <!-- Search Icon and Auth Links -->
        <div class="auth-section">
            <div class="search-bar">
                <a href="../nav/search.php">
                    <img src="photos/search.png" alt="Search">
                    <span>Search</span>
                </a>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Left-Side Image Section -->
        <div class="image-section">
            <img src="photos/read.png" alt="Collection 2018">
            <div class="overlay-text">#SCRIPTURA</div>
        </div>

        <!-- Right-Side Form Section -->
        <div class="form-section">
            <h1>Forgot Password</h1> <br>

            <?php if (isset($_GET['step']) && $_GET['step'] == 'success'): ?>
                <!-- Success Message Section -->
                <div id="success-message" style="text-align: center; padding: 20px; background-color: #4CAF50; color: white;">
                    <h2><?php echo $_SESSION['password_reset_success']; ?></h2>
                    <p>Redirecting to the login page...</p>
                </div>

                <script>
                    // Automatically redirect after 3 seconds
                    setTimeout(function() {
                        window.location.href = "/final/register/signin.php";
                    }, 3000);  // 3000ms = 3 seconds
                </script>
            <?php elseif (!isset($_GET['step']) || $_GET['step'] == 1): ?>
                <!-- Step 1: Email Verification -->
                <form method="POST">
                    <div class="input-group">
                        <label for="affiliation">Are you:</label>
                        <select id="affiliation" name="affiliation" required>
                            <option value="" disabled selected></option>
                            <option value="author">Author</option>
                            <option value="reader">Reader</option>
                        </select>
                        <span class="error"><?= $affiliation_err; ?></span>
                    </div>
<br>
                    <div class="input-group">
                        <label for="email">Email Address:</label>
                        <input type="email" id="email" name="email" required>
                        <span class="error"><?= $email_err; ?></span>
                    </div>
<br>
                    <button type="submit" name="verify_email" class="register-btn">Send Verification Code</button>
                </form>
            <?php elseif ($_GET['step'] == 2): ?>
                <!-- Step 2: Code Verification -->
                <form method="POST">
                    <div class="input-group">
                        <label for="verification-code">Verification Code:</label>
                        <input type="text" id="verification-code" name="verification_code" required>
                        <span class="error"><?= $email_err; ?></span>
                    </div> <br>
                    <button type="submit" name="verify_code" class="register-btn">Verify Code</button>
                </form>
            <?php elseif ($_GET['step'] == 3): ?>
                <!-- Step 3: Password Reset -->
                <form method="POST">
                <div class="input-group">
    <label for="new-password">New Password:</label>
    <div class="password-container">
        <input type="password" id="new-password" name="new-password" required>
        <img id="toggle-password" src="photos/eye-closed.png" alt="Toggle password visibility" class="toggle-password">
    </div>
</div>

<div class="input-group">
    <label for="new-confirm-password">Confirm Password:</label>
    <div class="password-container">
        <input type="password" id="new-confirm-password" name="new-confirm-password" required>
        <img id="toggle-confirm-password" src="photos/eye-closed.png" alt="Toggle password visibility" class="toggle-password">
    </div>
</div> <br>
    <button type="submit" name="reset_password" class="register-btn">Reset Password</button>
</form>

            <?php endif; ?>
        </div>
    </div>

    <script>
        const passwordInput = document.getElementById("new-password");
const confirmPasswordInput = document.getElementById("new-confirm-password");
const togglePassword = document.getElementById("toggle-password");
const toggleConfirmPassword = document.getElementById("toggle-confirm-password");

// Function to evaluate password strength
function evaluatePasswordStrength(password) {
    const hasNumber = /\d/; // Contains at least one number
    const hasSymbol = /[!@#$%^&*(),.?":{}|<>]/; // Contains at least one special symbol
    const hasLetter = /[a-zA-Z]/; // Contains at least one letter

    // Password should be longer than 8 characters and contain letters and symbols
    if (password.length < 8) {
        return "weak"; // Less than 8 characters
    } else if (hasLetter.test(password) && hasSymbol.test(password)) {
        return "strong"; // Strong: Letters and symbols
    } else {
        return "weak"; // If only letters or symbols, it is weak
    }
}

// Add event listener to the password input field
passwordInput.addEventListener("input", function () {
    const strength = evaluatePasswordStrength(passwordInput.value);

    // Remove any existing strength classes
    passwordInput.classList.remove("weak-password", "medium-password", "strong-password");

    // Add the appropriate class based on strength
    if (strength === "weak") {
        passwordInput.classList.add("weak-password");
    } else if (strength === "medium") {
        passwordInput.classList.add("medium-password");
    } else if (strength === "strong") {
        passwordInput.classList.add("strong-password");
    }
});

// Add event listener to the confirm password input field
confirmPasswordInput.addEventListener("input", function () {
    if (passwordInput.value !== confirmPasswordInput.value) {
        confirmPasswordInput.setCustomValidity("Passwords do not match.");
    } else {
        confirmPasswordInput.setCustomValidity(""); // Reset validation message
    }
});

// Toggle password visibility for the "Password" field
togglePassword.addEventListener("click", function () {
    const type = passwordInput.type === "password" ? "text" : "password";
    passwordInput.type = type;
    togglePassword.src = type === "password" ? "photos/eye-closed.png" : "photos/eye-open.png";
});

// Toggle confirm password visibility for the "Confirm Password" field
toggleConfirmPassword.addEventListener("click", function () {
    const type = confirmPasswordInput.type === "password" ? "text" : "password";
    confirmPasswordInput.type = type;
    toggleConfirmPassword.src = type === "password" ? "photos/eye-closed.png" : "photos/eye-open.png";
});

    </script>
</body>
</html>
