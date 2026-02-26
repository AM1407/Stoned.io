<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart — Stoned.io</title>
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

        /* ── Cart Page ── */
        .cart-page {
            max-width: 820px;
            margin: 0 auto;
            padding: 48px 24px 64px;
        }

        .cart-page h2 {
            font-size: 1.8rem;
            font-weight: 800;
            letter-spacing: 1px;
            color: #e8dfc8;
            text-align: center;
            margin-bottom: 8px;
        }

        .cart-page .subtitle {
            text-align: center;
            color: #7a6f60;
            font-size: 0.9rem;
            margin-bottom: 40px;
        }

        /* ── Cart Items ── */
        .cart-items {
            display: flex;
            flex-direction: column;
            gap: 16px;
            margin-bottom: 36px;
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: linear-gradient(160deg, #1e1b17 0%, #2a2420 100%);
            border: 1px solid #3a3128;
            border-radius: 12px;
            padding: 20px 24px;
            transition: border-color 0.25s ease;
        }

        .cart-item:hover {
            border-color: #c9a96e;
        }

        .cart-item-info {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .cart-item-name {
            font-weight: 700;
            font-size: 1.05rem;
            color: #e8dfc8;
        }

        .cart-item-tier {
            font-size: 0.78rem;
            color: #c9a96e;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .cart-item-price {
            font-size: 1.2rem;
            font-weight: 700;
            color: #c9a96e;
        }

        .cart-item-remove {
            background: none;
            border: none;
            color: #5a4f42;
            font-size: 1.1rem;
            cursor: pointer;
            margin-left: 18px;
            transition: color 0.2s ease;
        }

        .cart-item-remove:hover {
            color: #e05050;
        }

        .cart-item-right {
            display: flex;
            align-items: center;
        }

        /* ── Section Dividers ── */
        .section-divider {
            border: none;
            border-top: 1px solid #2d2520;
            margin: 36px 0;
        }

        /* ── Form Sections ── */
        .form-section {
            margin-bottom: 32px;
        }

        .form-section h3 {
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #c9a96e;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-section h3 i {
            font-size: 1rem;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: #b5a98a;
            margin-bottom: 6px;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px 16px;
            background: #1a1612;
            border: 1px solid #3a3128;
            border-radius: 8px;
            color: #e8dfc8;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.92rem;
            transition: border-color 0.25s ease, box-shadow 0.25s ease;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #c9a96e;
            box-shadow: 0 0 0 3px rgba(201, 169, 110, 0.15);
        }

        .form-group input::placeholder,
        .form-group textarea::placeholder {
            color: #5a5046;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }

        .form-group select option {
            background: #1a1612;
            color: #e8dfc8;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        /* ── Customisation Toggles ── */
        .option-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .option-card {
            display: flex;
            align-items: center;
            gap: 12px;
            background: #1a1612;
            border: 1px solid #3a3128;
            border-radius: 8px;
            padding: 14px 16px;
            cursor: pointer;
            transition: border-color 0.25s ease, background 0.25s ease;
        }

        .option-card:hover {
            border-color: #c9a96e;
        }

        .option-card input[type="checkbox"],
        .option-card input[type="radio"] {
            accent-color: #c9a96e;
            width: 16px;
            height: 16px;
            flex-shrink: 0;
        }

        .option-card.selected {
            border-color: #c9a96e;
            background: rgba(201, 169, 110, 0.06);
        }

        .option-label {
            display: flex;
            flex-direction: column;
        }

        .option-label span {
            font-size: 0.9rem;
            font-weight: 600;
            color: #e8dfc8;
        }

        .option-label small {
            font-size: 0.75rem;
            color: #7a6f60;
        }

        /* ── Price Summary ── */
        .price-summary {
            background: linear-gradient(160deg, #1e1b17 0%, #2a2420 100%);
            border: 1px solid #3a3128;
            border-radius: 12px;
            padding: 24px 28px;
            margin-top: 36px;
        }

        .price-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            font-size: 0.9rem;
            color: #9e9080;
        }

        .price-row.total {
            border-top: 1px solid #3a3128;
            margin-top: 10px;
            padding-top: 14px;
            font-size: 1.2rem;
            font-weight: 800;
            color: #e8dfc8;
        }

        .price-row.total span:last-child {
            color: #c9a96e;
            font-size: 1.4rem;
        }

        /* ── Place Order Button ── */
        .btn-place-order {
            display: block;
            width: 100%;
            margin-top: 20px;
            padding: 16px;
            background: linear-gradient(135deg, #c9a96e 0%, #a88a4e 100%);
            color: #1c1917;
            font-family: 'DM Sans', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
        }

        .btn-place-order:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(201, 169, 110, 0.35);
            background: linear-gradient(135deg, #d4b87a 0%, #b49558 100%);
        }

        .btn-place-order:active {
            transform: translateY(0);
        }

        /* ── Empty Cart ── */
        .empty-cart {
            text-align: center;
            padding: 80px 24px;
        }

        .empty-cart i {
            font-size: 3rem;
            color: #3a3128;
            margin-bottom: 16px;
        }

        .empty-cart p {
            color: #7a6f60;
            font-size: 1rem;
            margin-bottom: 24px;
        }

        .btn-shop {
            display: inline-block;
            padding: 12px 28px;
            background: transparent;
            border: 2px solid #c9a96e;
            color: #c9a96e;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.9rem;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            border-radius: 8px;
            text-decoration: none;
            transition: background 0.25s ease, color 0.25s ease;
        }

        .btn-shop:hover {
            background: #c9a96e;
            color: #1c1917;
        }

        /* ── Responsive ── */
        @media (max-width: 600px) {
            .form-row,
            .option-grid {
                grid-template-columns: 1fr;
            }

            .cart-page {
                padding: 32px 16px 48px;
            }

            .price-summary {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <?php include '../templates/navbar.php'; ?>

    <div class="cart-page">
        <h2><i class="bi bi-basket2"></i> Your Basket</h2>
        <p class="subtitle">Review your rocks, customise your order, and check out.</p>

        <!-- Cart Items -->
        <div class="cart-items">
            <div class="cart-item">
                <div class="cart-item-info">
                    <span class="cart-item-tier">Tier 1 — Pebble Package</span>
                    <span class="cart-item-name">Sylvester Stallstone</span>
                </div>
                <div class="cart-item-right">
                    <span class="cart-item-price">1€</span>
                    <button class="cart-item-remove" title="Remove item"><i class="bi bi-x-lg"></i></button>
                </div>
            </div>
        </div>

        <hr class="section-divider">

        <form action="#" method="POST" id="orderForm">

            <!-- Email Section -->
            <div class="form-section">
                <h3><i class="bi bi-envelope"></i> Contact Information</h3>
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="rockfan@example.com" required>
                </div>
            </div>

            <hr class="section-divider">

            <!-- Customisation Section -->
            <div class="form-section">
                <h3><i class="bi bi-palette"></i> Customise Your Rock</h3>

                <div class="form-row">
                    <div class="form-group">
                        <label for="rockName">Rock Name</label>
                        <input type="text" id="rockName" name="rock_name" placeholder="e.g. Dwayne 'The Rock' Johnson" maxlength="40">
                    </div>
                    <div class="form-group">
                        <label for="rockPersonality">Personality Type</label>
                        <select id="rockPersonality" name="rock_personality">
                            <option value="stoic">Stoic & Silent</option>
                            <option value="adventurous">Adventurous Explorer</option>
                            <option value="dramatic">Drama Queen</option>
                            <option value="philosopher">Deep Thinker</option>
                            <option value="party">Party Animal</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>Rock Size</label>
                    <div class="option-grid">
                        <label class="option-card">
                            <input type="radio" name="rock_size" value="pebble" checked>
                            <div class="option-label">
                                <span>Pebble</span>
                                <small>Pocket-sized companion</small>
                            </div>
                        </label>
                        <label class="option-card selected">
                            <input type="radio" name="rock_size" value="stone">
                            <div class="option-label">
                                <span>Stone</span>
                                <small>Desktop decoration</small>
                            </div>
                        </label>
                        <label class="option-card">
                            <input type="radio" name="rock_size" value="boulder">
                            <div class="option-label">
                                <span>Boulder</span>
                                <small>Statement piece</small>
                            </div>
                        </label>
                        <label class="option-card">
                            <input type="radio" name="rock_size" value="monolith">
                            <div class="option-label">
                                <span>Monolith</span>
                                <small>Absolute unit</small>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label>Extras</label>
                    <div class="option-grid">
                        <label class="option-card">
                            <input type="checkbox" name="extras[]" value="googly_eyes">
                            <div class="option-label">
                                <span>Googly Eyes</span>
                                <small>+0€ — because we're generous</small>
                            </div>
                        </label>
                        <label class="option-card">
                            <input type="checkbox" name="extras[]" value="tiny_hat">
                            <div class="option-label">
                                <span>Tiny Hat</span>
                                <small>+0€ — distinguished look</small>
                            </div>
                        </label>
                        <label class="option-card">
                            <input type="checkbox" name="extras[]" value="cape">
                            <div class="option-label">
                                <span>Mini Cape</span>
                                <small>+0€ — superhero vibes</small>
                            </div>
                        </label>
                        <label class="option-card">
                            <input type="checkbox" name="extras[]" value="certificate">
                            <div class="option-label">
                                <span>Adoption Certificate</span>
                                <small>+0€ — make it official</small>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="backstory">Custom Backstory</label>
                    <textarea id="backstory" name="backstory" placeholder="Once upon a time, in a quarry far far away..."></textarea>
                </div>
            </div>

            <hr class="section-divider">

            <!-- Recipient Section -->
            <div class="form-section">
                <h3><i class="bi bi-gift"></i> Gift Recipient (Optional)</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label for="recipientName">Recipient Name</label>
                        <input type="text" id="recipientName" name="recipient_name" placeholder="Lucky friend's name">
                    </div>
                    <div class="form-group">
                        <label for="recipientEmail">Recipient Email</label>
                        <input type="email" id="recipientEmail" name="recipient_email" placeholder="friend@example.com">
                    </div>
                </div>
                <div class="form-group">
                    <label for="giftMessage">Gift Message</label>
                    <textarea id="giftMessage" name="gift_message" placeholder="You rock! (pun intended)"></textarea>
                </div>
            </div>

            <!-- Price Summary & Place Order -->
            <div class="price-summary">
                <div class="price-row">
                    <span>Pebble Package × 1</span>
                    <span>1€</span>
                </div>
                <div class="price-row">
                    <span>Extras</span>
                    <span>0€</span>
                </div>
                <div class="price-row total">
                    <span>Total</span>
                    <span>1€</span>
                </div>
            </div>

            <button type="submit" class="btn-place-order">
                <i class="bi bi-lock-fill"></i> Place Order
            </button>

        </form>
    </div>

    <?php include '../templates/footer.php'; ?>

    <script>
        // Toggle selected state on option cards
        document.querySelectorAll('.option-card').forEach(card => {
            const input = card.querySelector('input');
            card.addEventListener('click', () => {
                if (input.type === 'radio') {
                    card.closest('.option-grid').querySelectorAll('.option-card').forEach(c => c.classList.remove('selected'));
                    card.classList.add('selected');
                } else {
                    card.classList.toggle('selected', input.checked);
                }
            });

            // Initialize selected state
            if (input.checked) card.classList.add('selected');
        });
    </script>
</body>
</html>