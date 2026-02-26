
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
        <i class="bi bi-asterisk star-icon"></i>
        <h1>Terms of Service</h1>
        <h5>Last Updated: Right now. Because we felt like it.</h5><br>

        <p>By using this website and clicking "Buy," you are legally acknowledging that your decision-making skills are questionable at best. 
            If you do not agree to these terms, please close your browser and go throw a real rock into a pond. 
            It's free.</p><br>
        <h4>1. The "Product"</h4>
        <p>
            - Definition: A "Stone" on this website is a collection of pixels arranged to look like a mineral. 
            It is not an investment, it is not an NFT, and it certainly isn't a pet that will love you back.<br><br>

            - Expectations: Your digital stone will not eat, sleep, or reproduce. If your stone starts talking to you, please seek professional medical help immediately. 
            This is outside our scope of support.<br><br>
        </p>
        <h4>2. Ownership & Intellectual Property</h4>
        <p>
            - You own the right to look at the PNG. You do not own the rights to the concept of "rocks."<br><br>

            - If you try to "resell" a picture of Sylvester Stallstone for a profit, we will laugh at you. Hard.<br><br>
        </p>
        <h4>3. User Responsibilities</h4>
        <p>
            - No Feeding: Do not attempt to upload digital "food" to our servers. The stones are on a strict diet of neglect.<br><br>

            - No Bullying: Please do not insult your digital stone. They are very dense and take things literally.<br><br>
        </p>
        <h4>4. Limitation of Liability</h4>
        <p>
            - Stoned.io is not responsible for any disappointment, existential crises, or realization that you could have bought a nice sandwich for €5 instead of a 4K picture of a pebble.<br><br>

            - We are not liable for any damage to your hardware if you try to "touch" the stone by reaching into your monitor.<br><br>
        </p>
        <h4>5. The "Rocks for Brains" Clause</h4>
        <p>
            By completing a purchase, you waive the right to act surprised when you receive exactly what you paid for: 
                absolutely nothing of physical value. You are buying a joke. If you don't get the joke, the joke is on you.
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

        .star-icon {
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