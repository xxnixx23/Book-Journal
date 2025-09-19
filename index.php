<?php
// Include the database connection file
require __DIR__ . '/db_connect.php';

// Fetch published articles from the admin_articles table, limiting to 3
$queryAdmin = "SELECT * FROM admin_articles WHERE is_published = 1 ORDER BY published_at DESC LIMIT 3";
$resultAdmin = $pdo->query($queryAdmin);
$adminArticles = $resultAdmin->fetchAll(PDO::FETCH_ASSOC);

// Fetch published articles from the author_articles table, limiting to 3
$queryAuthor = "SELECT * FROM author_articles WHERE is_published = 1 ORDER BY published_at DESC LIMIT 3";
$resultAuthor = $pdo->query($queryAuthor);
$authorArticles = $resultAuthor->fetchAll(PDO::FETCH_ASSOC);

// Combine the results
$articles = array_merge($adminArticles, $authorArticles);

// Sort the combined articles by published_at in descending order
usort($articles, function($a, $b) {
    return strtotime($b['published_at']) - strtotime($a['published_at']);
});

// Limit to the first 3 articles
$articles = array_slice($articles, 0, 3);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <!-- Google Fonts Link for Playfair Display and Open Sans -->
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400&family=Playfair+Display:wght@700&display=swap"
        rel="stylesheet">
        <link rel="stylesheet" href="css/index.css">
<style>
/* Wrapper for all articles */
.articles-wrapper {
    display: flex; /* Use flexbox for layout */
    flex-wrap: wrap; /* Allow wrapping to the next line if necessary */
    justify-content: flex-start; /* Align items to the start */
    margin-left:70px;
    
  
}

/* Container for each article */
.article-container {
    display: flex; /* Use flexbox for layout */
    flex-direction: column; /* Stack items vertically */
    align-items: center; /* Center items horizontally */
    border-radius: 5px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    margin: 20px; /* Add margin around each article */
    overflow: hidden;
    background-color: transparent; /* Make background transparent */
    width: 350px; /* Set a fixed width for the article container */
    height: 250px;
}

/* Flex container for image and details */
.article-content {
    display: flex; /* Use flexbox for layout */
    width: 100%; /* Full width */
}

/* Image styling */
.article-image {
    width: 150px; /* Set a fixed width for the image */
    height: 200px; /* Set height to resemble a book cover */
    overflow: hidden; /* Prevent overflow */
    margin-right: 15px; /* Space between image and details */
    margin-left: 20px;
    margin-top: 20px;
   

}

.article-image img {
    width: 100%;
    height: 100%;
    object-fit: cover; /* Ensure the image fits nicely */
}

/* Details section */
.article-details {
    padding: 15px;
    display: flex;
    flex-direction: column;
    justify-content: flex-start; /* Align items at the start */
    background-color: transparent; /* Ensure the details background is also transparent */
    text-align: left; /* Align text to the left */
    flex-grow: 1; /* Allow details to take remaining space */
}

/* Header styling */
.article-header {
    font-family: "Open Sans", sans-serif;
    font-size: 20px; /* Slightly smaller font size */
    font-weight: bold;
    color: #333;
    margin-bottom: 5px; /* Space below the header */
}

/* Meta information styling */
.article-meta,
.article-author,
.keywords {
    font-size: 14px; /* Smaller font size for meta information */
}


/* Button container */
.button-container {
    margin-top: auto; /* Push the button to the bottom */
    text-decoration: none;
}

/* Read More Button */
.read-more {
    display: inline-block; /* Make the link behave like a button */
    text-decoration: none; /* Remove underline from the link */
    color: #fff; /* Text color */
    background-color:  #552c1c; /* Background color */
    padding: 7px 11px; /* Padding for top/bottom and left/right */
    border-radius: 5px; /* Rounded corners */
    font-size: 12px; /* Font size */
    font-weight: bold; /* Bold text */
    transition: background-color 0.3s ease, transform 0.2s ease; /* Smooth transition for hover effects */
    text-decoration: none;
}

/* Hover state */
.read-more:hover {
    background-color: #b28e6c;  /* Darker background on hover */
    transform: translateY(-2px); /* Slight lift effect on hover */
}

/* Active state */
.read-more:active {
    background-color: #3e241a; /* Even darker background when clicked */
    transform: translateY(0); /* Reset lift effect */
    text-decoration: none;
}

h3{
    font-family: "Open Sans", sans-serif; "
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
            <a href="/final/nav/archives.php">Archives</a>
       
            <a href="/final/nav/submission.php">Submissions</a>

            <div class="dropdown">
                <a href="/final/nav/announcement.php">About</a>        
                <div class="dropdown-content">
                    <a href="/final/nav/announcement.php">Announcements</a>
                    <a href="/final/nav/editorial.php">Editorial Team</a>
                    <a href="/final/nav/aboutus.php">About Us</a>
                    <a href="/final/nav/contactus.php">Contact Us</a>
                </div>
            </div>
        </div>

        <!-- Search Icon and Auth Links -->
        <div class="auth-section">
            <div class="search-bar">
                <a href="/final/nav/search.php">
                    <img src="photos/search.png" alt="Search">
                    <span>Search</span>
                </a>
            </div>
            <div class="auth-links">
                <a href="register/signin.php">Sign In</a>
                <a href="register/signup.php">Sign Up</a>
            </div>
        </div>
    </div>
    <br><br>
    <!-- Main Section -->
    <div class="main-section">
        <div class="main-text">
            <h1>'Let Your Thoughts Join Those on the Pages'</h1>
            <p>
                Scriptura invites you to share your ideas and insights. Our platform offers a space for scholars
                to
                contribute their research and engage with a global academic community. Start your journey today by
                exploring
                various academic works and publications.
            </p>

            <img class="side" src="photos/side.png" alt="Side Image">

            <br>
            <a href="#next-section" class="get-started-btn">Get Started</a>
        </div>
    </div>

    <!-- Next Section -->
    <div id="next-section" class="next-section">
        <h2>About Scriptura</h2>
        <p>
            The Scriptura journal is an online hub that features academic publications from multiple higher
            education institutions and professional organizations. With its advanced database, users can efficiently
            find abstracts, full articles, and links to additional research materials. The journal's mission is to offer
            a wide-ranging collection of scholarly content, fostering the sharing of knowledge and research across
            various
            disciplines.
        </p>
    </div>
   <!-- Newly Published Articles Section -->
<div id="published-articles" class="published-articles-section">
    <h3 style="justify-content:center; align-item: center; text-align:center;">Newly Published Articles</h3>
    <p style="justify-content:center; align-item: center; text-align:center;">Explore the latest research and publications from our contributing scholars.</p>
    <div class="articles-wrapper"> <!-- New wrapper for articles -->
        <?php if (!empty($articles)): ?>
            <?php foreach ($articles as $article): ?>
                <div class="article-container">
                    <div class="article-content">
                        <div class="article-image">
                            <?php
                            $coverPath = str_replace($_SERVER['DOCUMENT_ROOT'], '', $article['cover_upload']);
                            ?>
                            <img src="<?php echo htmlspecialchars($coverPath); ?>" alt="Article Cover">
                        </div>
                        <div class="article-details">
                            <div class="article-header"><?php echo htmlspecialchars($article['title']); ?></div>
                            <div class="article-meta">
                                <span><span class="category-label" style="font-weight: bold;">Category:</span> <?php echo htmlspecialchars($article['category']); ?></span>
                            </div>
                            <div class="article-author">
                                <strong>Author:</strong> <?php echo htmlspecialchars($article['author_name']); ?>
                            </div>
                            <div class="article-meta">
                                <strong>Published on:</strong> <?php echo htmlspecialchars($article['published_at']); ?>
                            </div>
                            <div class="keywords">
                                <strong>Keywords:</strong> <?php echo htmlspecialchars($article['keywords']); ?>
                            </div> <br><br>
                            <div class="button-container">
                                <a href="/final/nav/pub-index.php?id=<?php echo $article['id']; ?>" class="read-more" style="text-decoration: none;">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="new">No newly published articles available at this time.</p>
        <?php endif; ?>
    </div>
</div>

            <script>
                function toggleDetails() {
                    const details = document.getElementById('book-details');
                    details.style.display = details.style.display === 'none' ? 'block' : 'none';
                }
            </script>

<div class="community-container">
        <div class="text-section">
            <h3>Engage with the <br><span class="highlight">Scriptura community</span></h3>
            <p>Share your insights, connect with fellow researchers, and access the resources you need to advance in
                your field.
            </p>
        </div>
        <div class="topic-section">
            <h3>Visit Topic Pages</h3>
            <div class="topics">
                <a href="/final/nav/submission.php"><button>Engineering</button></a>
                <a href="/final/nav/submission.php"><button>Mathematics</button></a>
                <a href="/final/nav/submission.php"><button>Biology</button></a>
                <a href="/final/nav/submission.php"><button>Computer Science</button></a>
                <a href="/final/nav/submission.php"><button>Climate Change</button></a>
                <a href="/final/nav/submission.php"><button>Medicine</button></a>
                <a href="/final/nav/submission.php"><button>Physics</button></a>
                <a href="/final/nav/submission.php"><button>Social Science</button></a>
                <a href="/final/nav/submission.php"><button>Astrophysics</button></a>
                <a href="/final/nav/submission.php"><button>Chemistry</button></a>
            </div>
        </div>
    </div>
    <br><br>

    <div class="influence-section">
        <div class="influence-image">
            <img src="photos/indexleft.png" alt="Scholarly Influence Image">
        </div>
        <div class="influence-text">
            <h3>Discover Your Scholarly Influence</h3>
            <p>View detailed insights into your readership and keep tabs on how often your work is cited across the
                academic world.</p>
        </div>
    </div>
    <br><br>
    <div class="join-community">
        <div class="text-content">
            <h1>Enhance your academic work<br>and join a global community of 25 million scholars</h1>
        </div>
        <button class="join-button" onclick="window.location.href='/final/register/signin.php'">Join for free</button>
    </div> <br><br>

 <!-- Section for Editor and Reviewer Contact -->
<div style=" padding: 20px; text-align: center; margin-top: 20px;">
    <h3>Interested in Becoming an Editor or Reviewer?</h3>
    <p>If you are interested in becoming an Editor or Reviewer, please contact us by filling out the form below.</p>
    <button onclick="window.location.href='contact_form.php'" style="padding: 10px 20px; background-color: #2f1f1b; color: #fff; border: none; cursor: pointer; font-size: 16px;">
        Contact Form
    </button>
</div>
  

    <!-- Footer Section -->
<footer style="background-color: #2f1f1b; color: #d8d4c9; padding: 20px;">
    <div class="footer-container" style="display: flex; justify-content: space-around; flex-wrap: wrap;">

        <!-- Column 1: About -->
        <div class="footer-column" style="flex: 1; margin: 10px;">
            <h3>About Scriptura</h3>
            <p>Scriptura is an online journal dedicated to academic publications from various institutions.
                Explore a wide array of research articles, abstracts, and resources across disciplines.</p>
        </div>

        <!-- Column 2: Quick Links -->
        <div class="footer-column" style="flex: 1; margin: 10px;">
            <h3>Quick Links</h3>
            <ul style="list-style-type: none; padding: 0;">
                <li><a href="index.php" style="color: #d8d4c9; text-decoration: none;">Home</a></li>
                <li><a href="archives.php" style="color: #d8d4c9; text-decoration: none;">Archives</a></li>
                <li><a href="current-issue.php" style="color: #d8d4c9; text-decoration: none;">Current Issue</a></li>
                <li><a href="submission.php" style="color: #d8d4c9; text-decoration: none;">Submissions</a></li>
            </ul>
        </div>

        <!-- Column 3: Contact Information -->
        <div class="footer-column" style="flex: 1; margin: 10px;">
            <h3>Contact Us</h3>
            <p>Email: info@scriptura.com</p>
            <p>Phone: +123-456-7890</p>
            <p>Address: 123 Academic Ave, Manila, Philippines</p>
        </div>

        <!-- Column 4: Follow Us -->
        <div class="footer-column" style="flex: 1; margin: 10px;">
            <h3>Follow Us</h3>
            <div style="display: flex; gap: 10px;">
                <a href="https://www.facebook.com" target="_blank" style="color: #d8d4c9;">
                    <img src="photos/fb.png" alt="Facebook" style="width: 24px; vertical-align: middle;">
                </a>
                <a href="https://www.instagram.com" target="_blank" style="color: #d8d4c9;">
                    <img src="photos/instagram.png" alt="Instagram" style="width: 24px; vertical-align: middle;">
                </a>
            </div>
        </div>

    </div>
    <div style="text-align: center; padding-top: 10px; font-size: 0.9em;">
        &copy; 2024 Scriptura. All rights reserved.
    </div>
</footer>

    <!-- Other Sections (Community, Influence, Footer, etc.) -->
    <!-- Keep these sections as they are unless you need to add dynamic content -->

</body>

</html>
