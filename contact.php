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
                    <form id="contactForm" novalidate>
                        <div class="mb-3">
                            <label for="name" class="form-label">Your Name</label>
                            <input type="text" class="form-control" id="name" name="name" required />
                            <div class="invalid-feedback">Please enter your name.</div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input
                                type="email"
                                class="form-control"
                                id="email"
                                name="email"
                                required />
                            <div class="invalid-feedback">Please enter a valid email address.</div>
                        </div>
                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject</label>
                            <input
                                type="text"
                                class="form-control"
                                id="subject"
                                name="subject"
                                required />
                            <div class="invalid-feedback">Please enter a subject.</div>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea
                                class="form-control"
                                id="message"
                                name="message"
                                rows="5"
                                required></textarea>
                            <div class="invalid-feedback">Please enter your message.</div>
                        </div>
                        <button type="submit" class="btn btn-dark w-100">
                            <span class="spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true"></span>
                            Send Message
                        </button>
                    </form>
                    <!-- Toast for notifications -->
                    <div class="toast-container position-fixed bottom-0 end-0 p-3">
                        <div id="messageToast" class="toast align-items-center text-white border-0" role="alert" aria-live="assertive" aria-atomic="true">
                            <div class="d-flex">
                                <div class="toast-body"></div>
                                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>
                        </div>
                    </div>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('contactForm');
        const submitBtn = form.querySelector('button[type="submit"]');
        const spinner = submitBtn.querySelector('.spinner-border');
        const toast = new bootstrap.Toast(document.getElementById('messageToast'));
        const toastElement = document.getElementById('messageToast');
        const toastBody = toastElement.querySelector('.toast-body');

        function showLoading(show) {
            submitBtn.disabled = show;
            spinner.classList.toggle('d-none', !show);
            submitBtn.textContent = show ? ' Sending...' : 'Send Message';
            if (show) {
                spinner.classList.remove('d-none');
                submitBtn.prepend(spinner);
            }
        }

        function showToast(message, success) {
            toastElement.className = `toast align-items-center text-white border-0 bg-${success ? 'success' : 'danger'}`;
            toastBody.textContent = message;
            toast.show();
        }

        form.addEventListener('submit', async function(e) {
            e.preventDefault();

            // Remove any existing validation classes
            form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));

            // Check if form is valid
            if (!form.checkValidity()) {
                e.stopPropagation();
                form.classList.add('was-validated');
                return;
            }

            showLoading(true);

            try {
                const formData = new FormData(form);
                const response = await fetch('process-contact.php', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    showToast(data.message, true);
                    form.reset();
                    form.classList.remove('was-validated');
                } else {
                    showToast(data.message || 'An error occurred. Please try again.', false);
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('An error occurred. Please try again later.', false);
            } finally {
                showLoading(false);
            }
        });

        // Reset validation on input
        form.querySelectorAll('input, textarea').forEach(input => {
            input.addEventListener('input', () => {
                input.classList.remove('is-invalid');
                if (form.classList.contains('was-validated')) {
                    form.classList.remove('was-validated');
                }
            });
        });
    });
</script>
</body>

</html>