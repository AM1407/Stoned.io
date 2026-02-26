
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
        <i class="bi bi-dot dot-icon"></i>
        <h1>Refund Policy</h1><br>
        <h4>Wait, you're serious?</h4>
        <p>You actually clicked the "Refund" link? For a digital picture of a rock? Rocks for brains, for fucks sake. 
            We at Stoned.io have a very strict policy regarding your sudden "buyer’s remorse." 
            Please read the following carefully, although we suspect reading might not be your strong suit.</p>
        <h4>The "Return" Protocol</h4>
        <p>
            Since this is a digital asset, we can't exactly "take it back." So, what do you want me to do?<br>

            - Do you want to send me a video of you ripping up your laptop screen to prove the file is destroyed?<br><br>

            - Should I fly to your house and hit your "Delete" key personally while we both weep over your lost Euro?<br><br>
        </p>
        <h4>Non-Refundable Scenarios</h4>
        <p>
            We do NOT offer refunds if:<br>

            - Your rock didn't "grow": It’s a PNG, Dave. It’s not going to sprout moss or turn into a mountain.<br><br>

            - The rock looked "too gray": It’s a stone. What did you expect? Neon pink?<br><br>

            - You realized you just paid €50 for a picture of Dwayne Johnson: That sounds like a "you" problem. That man is a national treasure.<br><br>
        </p>
        <h4>How to apply for a refund (Good luck)</h4>
        <p>
            If you still feel entitled to your money back, please print out the Adoption Certificate, take it to the nearest quarry, and explain your feelings to a real boulder. 
            If the boulder agrees to refund you, have it send us a carrier pigeon with its signature.<br><br>

            Until then: No refunds. Ever. ---
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

        .dot-icon {
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