
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
        <i class="bi bi-geo-alt-fill reroute-icon"></i>
        <p>Yeah, we weren't going to build socials pages for rocks. That would be absurd. Instead enjoy this image of a cool rock.</p>
        <img src="coolrocklol.png">
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
            max-width: 600px;
            margin: 0 auto;
            min-height: 50vh;
        }

        .reroute-icon {
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