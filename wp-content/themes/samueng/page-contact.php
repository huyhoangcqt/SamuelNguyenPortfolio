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
            
            <p></p>
            
            <div class="contact-left-inner">
            

                <!-- Cột 1: Avatar -->
                <div class="avatar-column">
                    <div class="avatar">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/avatar.png" alt="Avatar">
                    </div>
                </div>

                <!-- Cột 2: Social Links -->
                <div class="social-column">
                    <p class="social-spacing"></p>

                    <div class="social-links">
                        <ul>
                            <li>
                                <a href="https://www.youtube.com/@YellowCat.GameDev" target="_blank">
                                    <i class="fab fa-youtube"></i>
                                    <div class="social-item-value">@YellowCat.GameDev</div>
                                </a>
                            </li>
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
                <div>
                    <p><strong>I'm a Senior Game Developer with 4 years of hands-on experience</strong>, having contributed to various game projects across genres—from tactical RPGs to puzzle and multiplayer casual games. I've worked on gameplay mechanics, UI/UX, system architecture, and team coordination, gradually honing both my technical and collaborative skills.</p>

                    <p>But beyond code, I aspire to build games that resonate deeply with players.</p>

                    <p>I want my games to <strong>bring knowledge, emotions, and meaning into their lives</strong>—to make them feel truly alive.</p>
                </div>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>