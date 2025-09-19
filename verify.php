<?php
// Include the database connection
require __DIR__ . '/db_connect.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $email = $_POST['email'];
  $verificationCode = $_POST['verification_code'];

  try {
      $sql = "SELECT * FROM authors WHERE email = :email AND verification_code = :verificationCode 
              UNION SELECT * FROM readers WHERE email = :email AND verification_code = :verificationCode";
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue(':email', $email);
      $stmt->bindValue(':verificationCode', $verificationCode);
      $stmt->execute();

      $user = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($user) {
          $tableName = $user['affiliation'] . "s";
          $updateSql = "UPDATE $tableName SET verified = 1, verification_code = NULL WHERE email = :email";
          $updateStmt = $pdo->prepare($updateSql);
          $updateStmt->bindValue(':email', $email);

          if ($updateStmt->execute()) {
              $message = "Account verified successfully! You can now sign in.";
              header("Location: /final/register/signin.php");
              exit;
          } else {
              $message = "Error: Unable to verify account.";
          }
      } else {
          $message = "Invalid verification code. Please try again.";
      }
  } catch (PDOException $e) {
      $message = "Database error: " . $e->getMessage();
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <link rel="stylesheet" href="css/nav/signup.css">
 
</head>

<body>

<div class="navbar-links">
            <a href="../index.php">Home</a>
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

        <div class="auth-section">
            <div class="search-bar">
                <a href="../nav/search.php">
                    <img src="../photos/search.png" alt="Search">
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
        <div class="form-section"> <br>
            <h1>Email Verification</h1>
            <p style="text-align: center;">A verification code has been sent to your email. Please enter it below:</p>
            <br>
            <!-- Display message if provided -->
            <?php if ($message): ?>
            <p style="color: red; text-align: center;">
                <?= htmlspecialchars($message); ?>
            </p>
            <?php endif; ?>

            <form action="verify.php" method="POST">
                <!-- Hidden email input -->
                <input type="hidden" name="email" value="<?= htmlspecialchars($_GET['email'] ?? '') ?>">

                <!-- Input field for verification code -->
                <div class="input-group">
                    <label for="verification-code"></label>
                    <input type="text" id="verification-code" name="verification_code" required>
                </div>

                <!-- Submit button -->
                <br>
                <button type="submit" class="register-btn">Verify</button>
            </form>
        </div>
    </div>
</body>

</html>
