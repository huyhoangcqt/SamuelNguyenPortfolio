<?php
// filepath: c:\xampp\htdocs\samuelPortfolioProj\wp-content\themes\kubio-custom-theme\page-contact.php
get_header();
?>

<main class="contact-page layout-body-center">
    <!-- <header class="page-header">
        <h1 class="page-title">My Contact</h1>
    </header> -->

    <div class="contact-content">
        <!-- Cột 1: Avatar và mạng xã hội -->
        <div class="contact-column contact-left">
            <div class="contact-left-inner">
                <!-- Cột 1: Avatar -->
                <div class="avatar-column">
                    <div class="avatar">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/avatar.png" alt="Avatar">
                    </div>
                </div>

                <!-- Cột 2: Social Links -->
                <div class="social-column">
                    <div class="social-links">
                        <ul>
                            <li>
                                <a href="mailto:huyhoangcqt@gmail.com" target="_blank">
                                    <i class="fas fa-envelope"></i>
                                    <div class="social-item-value">huyhoangcqt@gmail.com</div>
                                </a>
                            </li>
                            <!-- <li>
                                <a href="https://github.com/your-github" target="_blank">
                                    <i class="fab fa-github"></i> GitHub
                                </a>
                            </li> -->
                            <!-- <li>
                                <a href="https://twitter.com/your-twitter" target="_blank">
                                    <i class="fab fa-twitter"></i>
                                    <div class="social-item-value">...</div>
                                </a>
                            </li> -->
                            <li>
                                <a href="https://www.youtube.com/@YellowCat.GameDev" target="_blank">
                                    <i class="fab fa-youtube"></i>
                                    <div class="social-item-value">@YellowCat.GameDev</div>
                                </a>
                            </li>
                            <!-- <li>
                                <a href="https://linkedin.com/in/your-linkedin" target="_blank">
                                    <i class="fab fa-linkedin"></i>
                                    <div class="social-item-value">...</div>
                                </a>
                            </li> -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cột 2: Thông tin giới thiệu -->
        <div class="contact-column contact-right">
            <div class="self-introduction">
                <h2>About Me</h2>
                <p>
                    Hi, I'm Samuel Nguyen, a passionate software developer with expertise in building scalable web applications and modern user interfaces. I specialize in technologies like PHP, JavaScript, React, and Node.js.
                </p>
                <p>
                    I enjoy solving complex problems and collaborating with teams to deliver high-quality software solutions. My goal is to continuously learn and contribute to impactful projects that make a difference.
                </p>
                <p>
                    Feel free to reach out to me through the links on the left. I'm always open to discussing new opportunities, collaborations, or just chatting about tech!
                </p>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>