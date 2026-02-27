<?php session_start(); ?>
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
        <i class="bi bi-cookie cookie-icon"></i>
        <h1>Cookie Policy</h1>
        <h5>Last Updated: february 26, 2026</h5><br>

        <p>
            Most websites use cookies to spy on you, follow you around the internet, and try to sell you shoes you already bought. 
            Stoned.io is not most websites. 
            We have better things to do, like baking actual cookies to go with our espresso</p><br><br>
        <h4>1. What are cookies?</h4>
        <p>
            Cookies are small text files stored on your device. They are like digital sticky notes.<br><br>
        </p>
        <h4>2. How we use them (The "Bare Essentials")</h4>
        <p>
            We only use Strictly Necessary Cookies. These are functional cookies that make the shop work. Without them, the website would have the memory of... well, a rock.<br><br>

            - PHP Session Cookie: This is a temporary ID that lets our server know that the "Sylvester Stallstone" in the cart belongs to you and not someone else.<br><br>

            - Duration: These cookies are "Session Cookies." They expire and delete themselves the moment you close your browser. They don't linger, and they don't gossip.<br><br>
        </p>
        <h4>3. What we <b>DON'T</b> use</h4>
        <p>
            - No Tracking Cookies: We don't care what other sites you visit.<br><br>

            - No Marketing Cookies: We won't haunt your Instagram feed with pictures of pebbles.<br><br>

            - No Third-Party Analytics: We don't send your data to giant tech corporations.<br><br>
        </p>
        <h4>4. Your Choices</h4>
        <p>
            Since we only use essential cookies, there is nothing to "opt-out" of if you want to use the shop. 
            If you disable cookies in your browser, you can still look at the rocks, but you won't be able to adopt one. 
            The choice is yours: a cookie-free life, or a life with a digital stone friend.
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

        .cookie-icon {
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