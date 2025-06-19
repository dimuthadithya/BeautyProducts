<?php
$pageTitle = "About Us";
$additionalCss = ["assets/css/about.css"];
include 'components/header.php';
?>

<?php include 'components/nav.php'; ?>

<!-- About Hero Section -->
<section class="about-hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6" data-aos="fade-right">
                <h1>About BeautyStore</h1>
                <p class="lead">
                    Your trusted destination for premium beauty products and expert
                    advice.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Our Story -->
<section class="our-story py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6" data-aos="fade-right">
                <h2>Our Story</h2>
                <p>
                    BeautyStore began with a simple mission: to make high-quality beauty
                    products accessible to everyone. Founded in 2020, we've grown from a
                    small online store to a trusted beauty destination.
                </p>
                <p>
                    We believe that everyone deserves to feel beautiful and confident.
                    That's why we carefully curate our product selection, partnering
                    with brands that share our values of quality, sustainability, and
                    inclusivity.
                </p>
            </div>
            <div class="col-md-6" data-aos="fade-left">
                <img
                    src="https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9"
                    alt="Our Story"
                    class="img-fluid rounded" />
            </div>
        </div>
    </div>
</section>

<!-- Our Values -->
<section class="our-values py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-5" data-aos="fade-up">Our Values</h2>
        <div class="row">
            <div class="col-md-4 mb-4" data-aos="fade-up">
                <div class="value-card text-center">
                    <i class="fas fa-heart"></i>
                    <h3>Quality</h3>
                    <p>
                        We source only the finest beauty products, ensuring every item
                        meets our high standards.
                    </p>
                </div>
            </div>
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="value-card text-center">
                    <i class="fas fa-leaf"></i>
                    <h3>Sustainability</h3>
                    <p>
                        We prioritize eco-friendly products and sustainable packaging to
                        protect our planet.
                    </p>
                </div>
            </div>
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="value-card text-center">
                    <i class="fas fa-users"></i>
                    <h3>Inclusivity</h3>
                    <p>
                        We celebrate diversity and offer products for every skin type and
                        tone.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our Team -->
<section class="our-team py-5">
    <div class="container">
        <h2 class="text-center mb-5" data-aos="fade-up">Meet Our Team</h2>
        <div class="row">
            <div class="col-md-4 mb-4" data-aos="fade-up">
                <div class="team-member text-center">
                    <img
                        src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80"
                        alt="Team Member"
                        class="rounded-circle mb-3" />
                    <h3>Sarah Johnson</h3>
                    <p class="text-muted">Founder & CEO</p>
                </div>
            </div>
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="team-member text-center">
                    <img
                        src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e"
                        alt="Team Member"
                        class="rounded-circle mb-3" />
                    <h3>Michael Brown</h3>
                    <p class="text-muted">Beauty Expert</p>
                </div>
            </div>
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="team-member text-center">
                    <img
                        src="https://images.unsplash.com/photo-1494790108377-be9c29b29330"
                        alt="Team Member"
                        class="rounded-circle mb-3" />
                    <h3>Emily Davis</h3>
                    <p class="text-muted">Product Specialist</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'components/footer.php'; ?>
</body>

</html>