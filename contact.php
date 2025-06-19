<?php
$pageTitle = "Contact Us";
$additionalCss = ["assets/css/contact.css"];
include 'components/header.php';
?>

<style>
    body {
        padding-top: 76px;
    }

    .contact-info-card {
        padding: 30px;
        text-align: center;
        background: #f8f9fa;
        border-radius: 10px;
        margin-bottom: 30px;
        transition: transform 0.3s ease;
    }

    .contact-info-card:hover {
        transform: translateY(-5px);
    }

    .contact-icon {
        font-size: 2.5rem;
        color: #ff4f81;
        margin-bottom: 20px;
    }

    .contact-form {
        background: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }

    .map-container {
        height: 400px;
        width: 100%;
        border-radius: 10px;
        overflow: hidden;
    }
</style>

<?php include 'components/nav.php'; ?>

<!-- Contact Information -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-5" data-aos="fade-up">Get in Touch</h2>
        <div class="row">
            <div class="col-md-4" data-aos="fade-up">
                <div class="contact-info-card">
                    <i class="fas fa-map-marker-alt contact-icon"></i>
                    <h4>Visit Us</h4>
                    <p>123 Beauty Street<br />New York, NY 10001</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="contact-info-card">
                    <i class="fas fa-phone contact-icon"></i>
                    <h4>Call Us</h4>
                    <p>+1 234 567 890<br />+1 234 567 891</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="contact-info-card">
                    <i class="fas fa-envelope contact-icon"></i>
                    <h4>Email Us</h4>
                    <p>info@beautystore.com<br />support@beautystore.com</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Form Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mb-4" data-aos="fade-right">
                <div class="contact-form">
                    <h3 class="mb-4">Send us a Message</h3>
                    <form>
                        <div class="mb-3">
                            <label for="name" class="form-label">Your Name</label>
                            <input type="text" class="form-control" id="name" required />
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input
                                type="email"
                                class="form-control"
                                id="email"
                                required />
                        </div>
                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject</label>
                            <input
                                type="text"
                                class="form-control"
                                id="subject"
                                required />
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea
                                class="form-control"
                                id="message"
                                rows="5"
                                required></textarea>
                        </div>
                        <button type="submit" class="btn btn-dark">Send Message</button>
                    </form>
                </div>
            </div>
            <div class="col-md-6" data-aos="fade-left">
                <div class="map-container">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d193595.15830869428!2d-74.119763973046!3d40.69766374874431!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew%20York%2C%20NY%2C%20USA!5e0!3m2!1sen!2s!4v1657612365445!5m2!1sen!2s"
                        width="100%"
                        height="100%"
                        style="border: 0"
                        allowfullscreen=""
                        loading="lazy">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-5" data-aos="fade-up">
            Frequently Asked Questions
        </h2>
        <div class="row justify-content-center">
            <div class="col-md-8" data-aos="fade-up">
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button
                                class="accordion-button"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#faq1">
                                What are your shipping rates?
                            </button>
                        </h2>
                        <div
                            id="faq1"
                            class="accordion-collapse collapse show"
                            data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                We offer free shipping on orders over LKR 50. For orders
                                under LKR 50, shipping rates start at LKR 5.99.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button
                                class="accordion-button collapsed"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#faq2">
                                What is your return policy?
                            </button>
                        </h2>
                        <div
                            id="faq2"
                            class="accordion-collapse collapse"
                            data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                We accept returns within 30 days of purchase. Items must be
                                unused and in original packaging.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button
                                class="accordion-button collapsed"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#faq3">
                                Do you offer international shipping?
                            </button>
                        </h2>
                        <div
                            id="faq3"
                            class="accordion-collapse collapse"
                            data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Yes, we ship to most countries worldwide. International
                                shipping rates vary by location.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'components/footer.php'; ?>
</body>

</html>