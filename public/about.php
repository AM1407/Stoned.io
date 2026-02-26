<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stoned.io — About</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>
    <?php include '../templates/navbar.php'; ?>

    <section class="about-hero">
        <div class="about-hero-text">
            <h2>This is me <i class="bi bi-arrow-right"></i></h2>
        </div>
        <div class="about-hero-image">
            <img src="61qBWrYGD8S.jpg" alt="Picture of the founder">
        </div>
    </section>

    <section class="about-content">
        <div class="about-block">
            <span class="about-label">The Origin Story</span>
            <h3>It all started with a really bad birthday gift.</h3>
            <p>
                In 2024, our founder received a JPEG of a rock for their birthday. Not even a high-res one.
                It was 144p, slightly blurry, and had a watermark on it. It was the worst gift they'd ever
                received — and somehow, the best business idea they'd ever had. "What if," they whispered
                into the void, "I charged people money for pictures of rocks?"
            </p>
        </div>

        <div class="about-block">
            <span class="about-label">The "Business Plan"</span>
            <h3>Step 1: Google "rock". Step 2: Screenshot. Step 3: Profit.</h3>
            <p>
                The original pitch deck was a napkin that just said "NFTs are dead but what if we sold
                pictures of rocks without the blockchain part." Investors hung up. Our mum sent €20 via
                PayPal anyway. That's venture capital, baby. We used it to pay for the domain name and
                a stock photo subscription. The stock photos are where the magic happens.
            </p>
        </div>

        <div class="about-block">
            <span class="about-label">The Product</span>
            <h3>We sell pictures. Of rocks. For real money.</h3>
            <p>
                Let's be clear: you are not getting a rock. You are getting a digital image of a rock.
                Our expert geologist-slash-graphic-designer (a guy named Dave who has Photoshop and
                zero qualifications) hand-curates every image based on vibes, pixel quality, and whether
                the rock looks like it has a face. If it has a face, it costs more. That's just economics.
            </p>
        </div>

        <div class="about-block">
            <span class="about-label">Our Mission</span>
            <h3>To give everyone a pet that literally cannot die.</h3>
            <p>
                In a world full of high-maintenance pets that need "food" and "love" and "veterinary care,"
                we offer something revolutionary: a JPEG. It doesn't bark. It doesn't shed. It doesn't
                need feeding. You can't even accidentally sit on it. It exists purely on a screen, silently
                judging you for spending actual money on a picture of a rock. You're welcome.
            </p>
        </div>

        <div class="about-block">
            <span class="about-label">Fun Facts</span>
            <h3>Things nobody asked but we're telling you anyway.</h3>
            <ul class="fun-facts">
                <li><i class="bi bi-check-circle-fill"></i> Over 0 images have been returned (you can't return a JPEG)</li>
                <li><i class="bi bi-check-circle-fill"></i> Our rocks are 100% gluten-free, vegan, and non-physical*</li>
                <li><i class="bi bi-check-circle-fill"></i> Our CEO once lost a staring contest with a PNG of a boulder</li>
                <li><i class="bi bi-check-circle-fill"></i> We are legally required to tell you these are just images</li>
                <li><i class="bi bi-check-circle-fill"></i> Dave the "geologist" learned everything from Google Images</li>
                <li><i class="bi bi-check-circle-fill"></i> Someone once asked for a refund. We emailed them another rock picture.</li>
            </ul>
            <p class="footnote">*They are pictures of rocks. All of these things are technically true.</p>
        </div>

        <div class="about-block">
            <span class="about-label">The Team</span>
            <h3>A carefully assembled squad of underqualified individuals.</h3>
            <p>
                Our team consists of one person doing everything, a JPEG of a rock named Gerald who serves
                as emotional support, and an unreliable Wi-Fi connection. We operate out of a bedroom that
                we call "headquarters" on the invoices. Our entire product inventory fits in a 2MB folder
                on the desktop. Silicon Valley wishes they had our overhead costs.
            </p>
        </div>
    </section>

    <?php include '../templates/footer.php'; ?>

    <style>
        .about-hero {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 48px;
            padding: 64px 40px;
            max-width: 900px;
            margin: 0 auto;
        }

        .about-hero-text h2 {
            font-size: 2rem;
            font-weight: 800;
            color: #e8dfc8;
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .about-hero-text h2 i {
            color: #c9a96e;
            font-size: 1.8rem;
            animation: nudge 1.5s ease-in-out infinite;
        }

        @keyframes nudge {
            0%, 100% { transform: translateX(0); }
            50% { transform: translateX(10px); }
        }

        .about-hero-image {
            flex-shrink: 0;
        }

        .image-placeholder {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            border: 2px dashed #3a3128;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 8px;
            color: #5a5046;
            font-size: 0.8rem;
            transition: border-color 0.3s ease;
        }

        .image-placeholder i {
            font-size: 2.5rem;
            color: #3a3128;
        }

        .image-placeholder:hover {
            border-color: #c9a96e;
        }

        .about-hero-image img {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #c9a96e;
            box-shadow: 0 0 20px rgba(201, 169, 110, 0.2);
        }

        .about-content {
            max-width: 800px;
            margin: 0 auto;
            padding: 0 40px 60px;
            display: flex;
            flex-direction: column;
            gap: 48px;
        }

        .about-block {
            border-left: 3px solid #2d2520;
            padding-left: 24px;
            transition: border-color 0.3s ease;
        }

        .about-block:hover {
            border-left-color: #c9a96e;
        }

        .about-label {
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #c9a96e;
            margin-bottom: 6px;
            display: block;
        }

        .about-block h3 {
            font-size: 1.2rem;
            font-weight: 700;
            color: #e8dfc8;
            margin: 6px 0 12px;
            line-height: 1.4;
        }

        .about-block p {
            font-size: 0.95rem;
            color: #9e9080;
            line-height: 1.75;
        }

        .fun-facts {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin: 4px 0 14px;
        }

        .fun-facts li {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-size: 0.92rem;
            color: #9e9080;
            line-height: 1.5;
        }

        .fun-facts li i {
            color: #c9a96e;
            margin-top: 3px;
            flex-shrink: 0;
        }

        .footnote {
            font-size: 0.78rem;
            color: #5a5046;
            font-style: italic;
        }

        @media (max-width: 600px) {
            .about-hero {
                flex-direction: column;
                gap: 24px;
                padding: 40px 24px;
            }

            .about-hero-text h2 i {
                display: none;
            }

            .about-content {
                padding: 0 24px 40px;
            }
        }
    </style>
</body>
</html>
