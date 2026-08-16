<?php
$page = "contact";
include 'header.php';
?>

<main id="main-content" class="contact-page">

    <!-- =====================================================
         CONTACT — SECTION 01 / HERO
    ====================================================== -->

    <section class="contact-hero">

        <div class="contact-hero-image"></div>

        <div class="contact-hero-overlay"></div>

        <div class="contact-hero-top">

            <span class="contact-number">
                01
            </span>

            <span class="contact-label">
                GET IN TOUCH
            </span>

        </div>

        <div class="contact-hero-content">

            <span class="contact-eyebrow">
                TORQUE FLOW / CONTACT
            </span>

            <h1>
                LET’S TALK<br>
                <span>ABOUT YOUR CAR.</span>
            </h1>

            <p>
                Whether you need routine maintenance, advanced diagnostics,
                or performance-focused service, we’re ready to help.
            </p>

        </div>

        <div class="contact-scroll">

            <span>SCROLL</span>

            <div class="contact-scroll-line"></div>

        </div>

    </section>


    <!-- =====================================================
         CONTACT — SECTION 02 / CONTACT DETAILS
    ====================================================== -->

    <section class="contact-details">

        <div class="contact-details-number">
            02
        </div>

        <div class="contact-details-content">

            <div class="contact-details-heading">

                <span class="section-label">
                    GET IN TOUCH
                </span>

                <h2>
                    WE’RE HERE<br>
                    <span>TO HELP.</span>
                </h2>

            </div>


            <div class="contact-information">

                <div class="contact-info-item">

                    <span class="contact-info-label">
                        CALL US
                    </span>

                    <a href="tel:+919408663504">
                        +91&nbsp;9408663504 
                    </a>

                </div>


                <div class="contact-info-item">

                    <span class="contact-info-label">
                        EMAIL
                    </span>

                    <a href="mailto:contact@torqueflow.com">
                        contact@torqueflow.com
                    </a>

                </div>


                <div class="contact-info-item">

                    <span class="contact-info-label">
                        FOLLOW
                    </span>

                    <div class="contact-socials">

                        <a href="https://www.instagram.com/" target="_blank" rel="noopener noreferrer" aria-label="Torque Flow Instagram">
                            INSTAGRAM <span aria-hidden="true">↗</span>
                        </a>

                        <a href="https://www.facebook.com/" target="_blank" rel="noopener noreferrer" aria-label="Torque Flow Facebook">
                            FACEBOOK <span aria-hidden="true">↗</span>
                        </a>

                        <a href="https://www.linkedin.com/" target="_blank" rel="noopener noreferrer" aria-label="Torque Flow LinkedIn">
                            LINKEDIN <span aria-hidden="true">↗</span>
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- =====================================================
         CONTACT — SECTION 03 / CONTACT FORM
    ====================================================== -->

    <section class="contact-form-section">

        <div class="contact-form-number">
            03
        </div>

        <div class="contact-form-wrapper">

            <div class="contact-form-heading">

                <span class="section-label">
                    SEND A MESSAGE
                </span>

                <h2>
                    LET’S START<br>
                    <span>A CONVERSATION.</span>
                </h2>

                <p>
                    Tell us a little about your vehicle and what you need.
                    Our team will get back to you as soon as possible.
                </p>

            </div>


            <form class="contact-form" action="#" method="POST">

                <div class="contact-form-row">

                    <div class="contact-field">

                        <label for="contact-name">
                            YOUR NAME
                        </label>

                        <input
                            type="text"
                            id="contact-name"
                            name="name"
                            autocomplete="name"
                            placeholder="e.g., Alex Smith…"
                            required
                        >

                    </div>


                    <div class="contact-field">

                        <label for="contact-email">
                            EMAIL ADDRESS
                        </label>

                        <input
                            type="email"
                            id="contact-email"
                            name="email"
                            autocomplete="email"
                            spellcheck="false"
                            autocapitalize="none"
                            placeholder="e.g., alex@example.com…"
                            required
                        >

                    </div>

                </div>


                <div class="contact-form-row">

                    <div class="contact-field">

                        <label for="contact-phone">
                            PHONE NUMBER
                        </label>

                        <input
                            type="tel"
                            id="contact-phone"
                            name="phone"
                            autocomplete="tel"
                            inputmode="tel"
                            placeholder="e.g., +91 94086 63504…"
                        >

                    </div>


                    <div class="contact-field">

                        <label for="contact-service">
                            SERVICE
                        </label>

                        <select
                            id="contact-service"
                            name="service"
                        >

                            <option value="" selected disabled>
                                Select a service…
                            </option>

                            <option value="performance">
                                Performance & Tuning
                            </option>

                            <option value="maintenance">
                                Routine Service
                            </option>

                            <option value="diagnostics">
                                Advanced Diagnostics
                            </option>

                            <option value="other">
                                Other
                            </option>

                        </select>

                    </div>

                </div>


                <div class="contact-field contact-message-field">

                    <label for="contact-message">
                        YOUR MESSAGE
                    </label>

                    <textarea
                        id="contact-message"
                        name="message"
                        rows="6"
                        placeholder="Tell us about your vehicle…"
                    ></textarea>

                </div>


                <button
                    type="submit"
                    class="contact-submit"
                >
                    <span>SEND MESSAGE</span>
                    <span class="contact-submit-arrow" aria-hidden="true">↗</span>
                </button>

            </form>

        </div>

    </section>


    <!-- =====================================================
         CONTACT — SECTION 04 / LOCATION
    ====================================================== -->

    <section class="contact-location">

        <div class="contact-location-image">

            <div class="contact-location-overlay"></div>

            <div class="contact-location-content">

                <span class="section-label">
                    04 / FIND US
                </span>

                <h2>
                    COME<br>
                    <span>VISIT US.</span>
                </h2>

                <div class="contact-location-info">

                    <p>
                        TORQUE FLOW
                    </p>

                    <p>
                        INDIA
                    </p>

                    <span>
                        PREMIUM VEHICLE SERVICE
                    </span>

                </div>

            </div>

        </div>

    </section>

</main>

<?php include 'footer.php'; ?>