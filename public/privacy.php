
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stoned.io — Nice Try</title>
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

    <div class="reroute-container">
        <i class="bi bi-eye eye-icon"></i>
        <h1>Privacy Policy</h1>
        <h5>Last Updated: february 26, 2026</h5><br>

        <p>Welcome to the Privacy Policy of <b>Stoned.io</b>. 
            We value your privacy almost as much as we value a perfectly brewed espresso. 
            We operate on a "One and Done" philosophy: we don’t want your data, we don’t keep your data, and we certainly don’t have a database to leak your data from.</p><br>
        <h4>1. The "No-Database" Promise</h4>
        <p>
            We do not use a database. 
            Any information you provide—like the glorious name of your Tier 3 custom stone—exists only in the temporary memory of our server for the split second it takes to generate your Adoption Certificate. 
            Once you close your browser tab, we’ve already forgotten you exist. It’s not personal; it’s just efficient.<br><br>
        </p>
        <h4>2. What We (Temporarily) Process</h4>
        <p>
            To make this wacky shop work, we handle the following fragments of information:<br><br>

            - Customization Data: If you pay for a custom backstory or name, that text is processed via our JSON-based engine to create your product.<br><br>

            - Session Cookies: We use a tiny, temporary cookie to remember which pebble is in your cart. This cookie expires the moment you finish your espresso and close the browser.<br><br>
        </p>
        <h4>3. Payment Processing (The real Pros)</h4>
        <p>
            We are in the business of digital rocks, not financial security. That is why we use Stripe and Ko-fi to handle your money.<br><br>

            - Zero Visibility: We never see, touch, or store your credit card number or bank details.<br><br>

            - External Trust: When you pay, you are subject to the privacy policies of Stripe or Ko-fi. They tell us "Payment Successful," and we give you the pixels. Everyone wins.<br><br>
        </p>
        <h4>4. Third-Party Sharing</h4>
        <p>
            We cannot sell your data to third parties because we don’t have any data to sell. 
            We are terrible at modern capitalism, but we are great at leaving you alone. 
            We do not use tracking pixels, invasive analytics, or "Big Brother" software.<br><br>
        </p>
        <h4>5. Your Rights</h4>
        <p>
            Under the "Common Sense Act," you have the right to:<br><br>

            - Know that we have nothing on you.<br><br> 

            - Request that we delete your data (which is redundant, as we’ve likely deleted it before you finished reading this sentence).<br><br>

            - Go outside and look at a real rock if this digital one stresses you out.<br><br>
        </p>
        <h4>6. Contact Us</h4>
        <p>
            If you have questions about this policy, don't send us an email—we don't have a CRM system to log it in. 
            Just know that your privacy is "rock solid" because our memory is "stone cold."
        </p>
        <img src="">
        <a href="index.php" class="reroute-btn"><i class="bi bi-arrow-left"></i> Back to the Rocks</a>
    </div>

    <?php include '../templates/footer.php'; ?>

    <style>
        .reroute-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            gap: 20px;
            padding: 80px 40px;
            max-width: 820px;
            margin: 0 auto;
            min-height: 50vh;
        }

        .eye-icon {
            font-size: 3rem;
            color: #c9a96e;
            opacity: 0.7;
        }

        .reroute-container p {
            font-size: 1.05rem;
            line-height: 1.7;
            color: #9e9080;
        }

        .reroute-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border: 1.5px solid #c9a96e;
            color: #c9a96e;
            padding: 8px 18px;
            border-radius: 8px;
            font-family: inherit;
            font-size: 0.88rem;
            font-weight: 600;
            transition: background-color 0.2s ease, color 0.2s ease, box-shadow 0.2s ease;
        }

        .reroute-btn:hover {
            background-color: #c9a96e;
            color: #1c1917;
            box-shadow: 0 0 12px rgba(201, 169, 110, 0.4);
        }
    </style>
</body>
</html>