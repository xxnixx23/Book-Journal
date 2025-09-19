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
              header("Location: /final/admin/author/index.php");
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

   
<div class="navbar">
        <div class="navbar-logo">
            <img src="../photos/logo.png" alt="Logo">
            <span>Scriptura</span>
        </div>
        <div class="navbar-dashboard">Dashboard</div>
    </div>

    <div class="side-panel">
        <div class="profile-section">
            <form id="profileForm">
                <input type="file" id="profileImage" accept="image/*" onchange="updateProfileImage(event)"
                    style="display: none;">
                <label for="profileImage" class="profile-img-container">
                    <img id="profileImg" src="../photos/profile.png" alt="Profile" class="profile-img">
                </label>
            </form>
            <div class="profile-info">
                <span class="admin-name">&nbsp;&nbsp;&nbsp;Admin</span><br>
                <span class="admin-position">&nbsp;&nbsp;&nbsp;Administrator</span>
            </div>
        </div>

        <div class="menu-items">
            <ul>
                <li class="menu-item">
                    <a href="../admin/dashboard/index.php" >
                        <img src="../photos/dashboards.png" alt="Dashboard">
                        <span> &nbsp;&nbsp;&nbsp;Dashboard</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="../admin/announcement/index.php">
                        <img src="../photos/announcement.png" alt="Announcement">
                        <span>&nbsp;&nbsp;&nbsp;Announcement</span>
                    </a>
                </li>
                <li class="menu-item">
                <a href="../admin/articles/submitted.php">
                        <img src="../photos/article.png" alt="Articles">
                        <span>&nbsp;&nbsp;&nbsp;Articles</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="../admin/author/index.php" class="active">
                        <img src="../photos/author.png" alt="Author">
                        <span>&nbsp;&nbsp;&nbsp;Author</span>
                    </a>
                </li>
                
                <li class="menu-item">
                    <a href="../admin/dashboard/report_selection.php">
                        <img src="..photos/report.png" alt="Reports">
                        <span>&nbsp;&nbsp;&nbsp;Reports</span>
                    </a>
                </li>
                
                <li class="menu-item">
                    <a href="../../index.php">
                        <img src="../photos/logout.png" alt="Reports">
                        <span>&nbsp;&nbsp;&nbsp;Log out</span>
                    </a>
                </li>
            </ul>
        </div>
    </div> 

<div class="main-content">



    <div class="container">
        
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

            <form action="verifyadm.php" method="POST">
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
    </div>
</body>

</html>
