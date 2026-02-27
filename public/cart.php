<?php require_once __DIR__ . '/../src/cart-page-logic.php'; ?>
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
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        /* ── Cart Page ── */
        .cart-page { max-width: 880px; margin: 0 auto; padding: 48px 24px 64px; }
        .cart-page h2 { font-size: 1.8rem; font-weight: 800; letter-spacing: 1px; color: #e8dfc8; text-align: center; margin-bottom: 8px; }
        .cart-page .subtitle { text-align: center; color: #7a6f60; font-size: 0.9rem; margin-bottom: 40px; }

        /* ── Alerts ── */
        .alert { padding: 14px 20px; border-radius: 10px; margin-bottom: 24px; font-size: 0.9rem; }
        .alert-error { background: rgba(224, 80, 80, 0.12); border: 1px solid #e05050; color: #e05050; }
        .alert-success { background: rgba(80, 200, 120, 0.12); border: 1px solid #50c878; color: #50c878; }

        /* ── Package Banner ── */
        .package-banner { background: linear-gradient(135deg, #251f16 0%, #332a1a 100%); border: 1px solid #c9a96e; border-radius: 12px; padding: 20px 28px; margin-bottom: 32px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; }
        .package-banner .pkg-label { font-size: 0.72rem; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: #c9a96e; }
        .package-banner .pkg-name { font-size: 1.3rem; font-weight: 800; color: #e8dfc8; margin-top: 2px; }
        .package-banner .pkg-includes { font-size: 0.82rem; color: #9e9080; margin-top: 4px; }
        .package-banner .pkg-price { font-size: 1.6rem; font-weight: 800; color: #c9a96e; }

        /* ── Cart Items ── */
        .cart-items { display: flex; flex-direction: column; gap: 16px; margin-bottom: 36px; }
        .cart-item { display: flex; justify-content: space-between; align-items: center; background: linear-gradient(160deg, #1e1b17 0%, #2a2420 100%); border: 1px solid #3a3128; border-radius: 12px; padding: 20px 24px; transition: border-color 0.25s ease; }
        .cart-item:hover { border-color: #c9a96e; }
        .cart-item-info { display: flex; flex-direction: column; gap: 4px; }
        .cart-item-name { font-weight: 700; font-size: 1.05rem; color: #e8dfc8; }
        .cart-item-tier { font-size: 0.78rem; color: #c9a96e; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; }
        .cart-item-price { font-size: 1.2rem; font-weight: 700; color: #c9a96e; }
        .cart-item-remove { background: none; border: none; color: #5a4f42; font-size: 1.1rem; cursor: pointer; margin-left: 18px; transition: color 0.2s ease; }
        .cart-item-remove:hover { color: #e05050; }
        .cart-item-right { display: flex; align-items: center; }

        /* ── Rock Preview Cards ── */
        .rock-cards { display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 20px; margin-bottom: 32px; }
        .rock-card { background: linear-gradient(160deg, #1e1b17 0%, #2a2420 100%); border: 1px solid #3a3128; border-radius: 12px; overflow: hidden; transition: border-color 0.25s ease, transform 0.25s ease; }
        .rock-card:hover { border-color: #c9a96e; transform: translateY(-4px); }
        .rock-card img { width: 100%; height: 200px; object-fit: cover; border-bottom: 1px solid #3a3128; background: #0e0c0a; }
        .rock-card-body { padding: 16px 18px; }
        .rock-card-name { font-weight: 700; font-size: 1rem; color: #e8dfc8; margin-bottom: 4px; }
        .rock-card-tier { font-size: 0.72rem; font-weight: 600; letter-spacing: 1.5px; text-transform: uppercase; color: #c9a96e; margin-bottom: 10px; }
        .rock-card-backstory { font-size: 0.82rem; color: #9e9080; line-height: 1.55; max-height: 120px; overflow-y: auto; }
        .rock-card-backstory::-webkit-scrollbar { width: 4px; }
        .rock-card-backstory::-webkit-scrollbar-thumb { background: #3a3128; border-radius: 4px; }

        /* ── PDF Badge (T4) ── */
        .pdf-badge { display: inline-flex; align-items: center; gap: 6px; margin-top: 10px; padding: 6px 12px; background: rgba(201, 169, 110, 0.1); border: 1px solid #c9a96e; border-radius: 6px; font-size: 0.78rem; font-weight: 600; color: #c9a96e; }
        .pdf-badge i { font-size: 1rem; }

        /* ── Customisation Panel (T3+) ── */
        .customise-panel { background: linear-gradient(160deg, #1e1b17 0%, #2a2420 100%); border: 1px solid #3a3128; border-radius: 12px; padding: 28px; margin-bottom: 32px; }
        .customise-panel h3 { font-size: 0.8rem; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: #c9a96e; margin-bottom: 18px; display: flex; align-items: center; gap: 8px; }
        .customise-panel h3 i { font-size: 1rem; }

        /* ── interact.js drag zone ── */
        .interact-zone { position: relative; width: 100%; min-height: 320px; background: #0e0c0a; border: 2px dashed #3a3128; border-radius: 12px; margin-bottom: 18px; overflow: hidden; }
        .interact-zone .drag-hint { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: #3a3128; font-size: 0.85rem; pointer-events: none; text-align: center; }
        .interact-zone .draggable { position: absolute; touch-action: none; user-select: none; cursor: grab; }
        .interact-zone .draggable img { width: 80px; height: 80px; border-radius: 8px; pointer-events: none; }
        .interact-zone .draggable.text-sticker { background: rgba(201,169,110,0.15); border: 1px solid #c9a96e; border-radius: 6px; padding: 6px 12px; color: #e8dfc8; font-size: 0.8rem; font-weight: 600; white-space: nowrap; }
        .sticker-tray { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 12px; }
        .sticker-tray button { background: #1a1612; border: 1px solid #3a3128; border-radius: 8px; padding: 8px 14px; color: #e8dfc8; font-family: 'DM Sans', sans-serif; font-size: 0.82rem; cursor: pointer; transition: border-color 0.2s ease; }
        .sticker-tray button:hover { border-color: #c9a96e; }

        /* ── Section Dividers ── */
        .section-divider { border: none; border-top: 1px solid #2d2520; margin: 36px 0; }

        /* ── Form Sections ── */
        .form-section { margin-bottom: 32px; }
        .form-section h3 { font-size: 0.8rem; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: #c9a96e; margin-bottom: 18px; display: flex; align-items: center; gap: 8px; }
        .form-section h3 i { font-size: 1rem; }
        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; font-size: 0.85rem; font-weight: 600; color: #b5a98a; margin-bottom: 6px; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 12px 16px; background: #1a1612; border: 1px solid #3a3128; border-radius: 8px; color: #e8dfc8; font-family: 'DM Sans', sans-serif; font-size: 0.92rem; transition: border-color 0.25s ease, box-shadow 0.25s ease; }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus { outline: none; border-color: #c9a96e; box-shadow: 0 0 0 3px rgba(201, 169, 110, 0.15); }
        .form-group input::placeholder, .form-group textarea::placeholder { color: #5a5046; }
        .form-group textarea { resize: vertical; min-height: 80px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }

        /* Honeypot — must stay invisible */
        .ohnohoney { opacity: 0; position: absolute; top: 0; left: 0; height: 0; width: 0; z-index: -1; overflow: hidden; }

        /* ── Option Cards ── */
        .option-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .option-card { display: flex; align-items: center; gap: 12px; background: #1a1612; border: 1px solid #3a3128; border-radius: 8px; padding: 14px 16px; cursor: pointer; transition: border-color 0.25s ease, background 0.25s ease; }
        .option-card:hover { border-color: #c9a96e; }
        .option-card input[type="checkbox"], .option-card input[type="radio"] { accent-color: #c9a96e; width: 16px; height: 16px; flex-shrink: 0; }
        .option-card.selected { border-color: #c9a96e; background: rgba(201, 169, 110, 0.06); }
        .option-label { display: flex; flex-direction: column; }
        .option-label span { font-size: 0.9rem; font-weight: 600; color: #e8dfc8; }
        .option-label small { font-size: 0.75rem; color: #7a6f60; }

        /* ── Price Summary ── */
        .price-summary { background: linear-gradient(160deg, #1e1b17 0%, #2a2420 100%); border: 1px solid #3a3128; border-radius: 12px; padding: 24px 28px; margin-top: 36px; }
        .price-row { display: flex; justify-content: space-between; align-items: center; padding: 8px 0; font-size: 0.9rem; color: #9e9080; }
        .price-row.total { border-top: 1px solid #3a3128; margin-top: 10px; padding-top: 14px; font-size: 1.2rem; font-weight: 800; color: #e8dfc8; }
        .price-row.total span:last-child { color: #c9a96e; font-size: 1.4rem; }

        /* ── Buttons ── */
        .btn-place-order { display: block; width: 100%; margin-top: 20px; padding: 16px; background: linear-gradient(135deg, #c9a96e 0%, #a88a4e 100%); color: #1c1917; font-family: 'DM Sans', sans-serif; font-size: 1rem; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; border: none; border-radius: 10px; cursor: pointer; transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease; }
        .btn-place-order:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(201, 169, 110, 0.35); background: linear-gradient(135deg, #d4b87a 0%, #b49558 100%); }
        .btn-place-order:active { transform: translateY(0); }

        /* ── Empty Cart ── */
        .empty-cart { text-align: center; padding: 80px 24px; }
        .empty-cart i { font-size: 3rem; color: #3a3128; margin-bottom: 16px; }
        .empty-cart p { color: #7a6f60; font-size: 1rem; margin-bottom: 24px; }
        .btn-shop { display: inline-block; padding: 12px 28px; background: transparent; border: 2px solid #c9a96e; color: #c9a96e; font-family: 'DM Sans', sans-serif; font-size: 0.9rem; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; border-radius: 8px; text-decoration: none; transition: background 0.25s ease, color 0.25s ease; }
        .btn-shop:hover { background: #c9a96e; color: #1c1917; }

        /* ── Responsive ── */
        @media (max-width: 600px) {
            .form-row, .option-grid, .rock-cards { grid-template-columns: 1fr; }
            .cart-page { padding: 32px 16px 48px; }
            .price-summary { padding: 20px; }
            .package-banner { flex-direction: column; text-align: center; }
        }
    </style>
</head>
<body>
    <?php include __DIR__ . '/../templates/navbar.php'; ?>

    <div class="cart-page">
        <h2><i class="bi bi-basket2"></i> Your Basket</h2>
        <p class="subtitle">Review your rocks, customise your order, and check out.</p>

        <!-- ── Alerts ── -->
        <?php if (!empty($formErrors)): ?>
            <div class="alert alert-error">
                <?php foreach ($formErrors as $err): ?>
                    <p><?= htmlspecialchars($err) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ($formSuccess): ?>
            <div class="alert alert-success">
                <p><i class="bi bi-check-circle"></i> Order placed! A confirmation has been sent (just kidding, this is a rock shop).</p>
            </div>
        <?php endif; ?>

        <?php if ($cartEmpty): ?>
            <!-- ── Empty state ── -->
            <div class="empty-cart">
                <i class="bi bi-basket2"></i>
                <p>Your basket is emptier than a quarry after Dave's been through it.</p>
                <a href="index.php" class="btn-shop">Go Shopping</a>
            </div>

        <?php else: ?>

            <?php foreach ($cartDisplay as $ci): ?>
                <!-- ── Package Banner ── -->
                <div class="package-banner">
                    <div>
                        <div class="pkg-label"><?= htmlspecialchars($ci['badge']) ?></div>
                        <div class="pkg-name"><?= htmlspecialchars($ci['label']) ?></div>
                        <div class="pkg-includes"><i class="bi bi-box-seam"></i> <?= htmlspecialchars($ci['includes']) ?></div>
                    </div>
                    <div class="pkg-price"><?= $ci['price'] ?>€</div>
                </div>

                <!-- ── Rock Cards (tier-adaptive) ── -->
                <div class="rock-cards">
                    <?php foreach ($ci['rocks'] as $rock): ?>
                        <div class="rock-card">
                            <!-- Photo — all tiers -->
                            <img src="img/<?= htmlspecialchars($rock['image']) ?>"
                                 alt="<?= htmlspecialchars($rock['name'] ?? 'Mystery Rock') ?>"
                                 onerror="this.src='img/placeholder.png'">
                            <div class="rock-card-body">
                                <!-- Name — all tiers -->
                                <div class="rock-card-name">
                                    <?= htmlspecialchars($rock['name'] ?? 'Mystery Rock') ?>
                                </div>
                                <div class="rock-card-tier"><?= htmlspecialchars($rock['tier']) ?></div>

                                <?php if ($ci['tier'] >= 2 && !empty($rock['backstory'])): ?>
                                    <!-- Backstory — T2+ -->
                                    <div class="rock-card-backstory">
                                        <?= htmlspecialchars($rock['backstory']) ?>
                                    </div>
                                <?php endif; ?>

                                <?php if ($ci['tier'] >= 4): ?>
                                    <!-- PDF badge — T4 -->
                                    <div class="pdf-badge">
                                        <i class="bi bi-file-earmark-pdf"></i>
                                        Adoption Certificate (PDF)
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <?php if ($ci['tier'] >= 3): ?>
                    <!-- ── Customisation Panel (T3 & T4) — interact.js zone ── -->
                    <div class="customise-panel" data-tier="<?= $ci['tier'] ?>">
                        <h3><i class="bi bi-palette"></i> Customise Your Rock</h3>
                        <p style="color:#9e9080; font-size:0.85rem; margin-bottom:14px;">
                            Drag stickers and text onto your rock canvas. Go wild — it's your rock.
                        </p>

                        <div class="sticker-tray">
                            <button type="button" class="add-sticker" data-type="text" data-value="🤘 Rock On">🤘 Rock On</button>
                            <button type="button" class="add-sticker" data-type="text" data-value="⭐ VIP">⭐ VIP</button>
                            <button type="button" class="add-sticker" data-type="text" data-value="🎩 Fancy">🎩 Fancy</button>
                            <button type="button" class="add-sticker" data-type="text" data-value="💎 Premium">💎 Premium</button>
                            <button type="button" class="add-sticker" data-type="text" data-value="🔥 Hot Rock">🔥 Hot Rock</button>
                            <button type="button" class="add-sticker" data-type="text" data-value="👀 Googly">👀 Googly</button>
                        </div>

                        <div class="interact-zone" id="interactZone-<?= $ci['index'] ?>">
                            <div class="drag-hint">
                                <i class="bi bi-arrows-move" style="font-size:1.6rem;display:block;margin-bottom:6px;"></i>
                                Drag items here to customise
                            </div>
                            <?php foreach ($ci['rocks'] as $ri => $rock): ?>
                                <div class="draggable"
                                     data-x="<?= 30 + ($ri * 110) ?>" data-y="100"
                                     style="transform: translate(<?= 30 + ($ri * 110) ?>px, 100px);">
                                    <img src="img/<?= htmlspecialchars($rock['image']) ?>"
                                         alt="<?= htmlspecialchars($rock['name'] ?? 'Rock') ?>"
                                         onerror="this.src='img/placeholder.png'">
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="customName-<?= $ci['index'] ?>">Custom Display Name</label>
                                <input type="text" id="customName-<?= $ci['index'] ?>"
                                       name="custom_name[<?= $ci['index'] ?>]"
                                       placeholder="Give your rock a new identity"
                                       maxlength="40">
                            </div>
                            <div class="form-group">
                                <label for="customColour-<?= $ci['index'] ?>">Background Colour</label>
                                <select id="customColour-<?= $ci['index'] ?>" name="custom_colour[<?= $ci['index'] ?>]">
                                    <option value="dark">Obsidian Black</option>
                                    <option value="sand">Sandy Beige</option>
                                    <option value="ocean">Ocean Blue</option>
                                    <option value="forest">Forest Green</option>
                                    <option value="lava">Lava Red</option>
                                </select>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <hr class="section-divider">
            <?php endforeach; ?>

            <!-- ── Order Form ── -->
            <form action="cart.php" method="POST" id="orderForm" autocomplete="off">

                <!-- Email Section -->
                <div class="form-section">
                    <h3><i class="bi bi-envelope"></i> Contact Information</h3>

                    <!-- Honeypot — hidden from humans, bots fill it -->
                    <div class="ohnohoney">
                        <label for="website">Website</label>
                        <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email"
                               placeholder="rockfan@example.com"
                               value="<?= htmlspecialchars($sanitisedEmail) ?>"
                               required>
                    </div>
                </div>

                <hr class="section-divider">

                <!-- ── Recipient Section ── -->
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

                <!-- ── Price Summary ── -->
                <div class="price-summary">
                    <?php foreach ($cartDisplay as $ci): ?>
                        <div class="price-row">
                            <span><?= htmlspecialchars($ci['label']) ?> × 1</span>
                            <span><?= $ci['price'] ?>€</span>
                        </div>
                    <?php endforeach; ?>
                    <div class="price-row total">
                        <span>Total</span>
                        <span><?= $cartTotal ?>€</span>
                    </div>
                </div>

                <button type="submit" name="place_order" value="1" class="btn-place-order">
                    <i class="bi bi-lock-fill"></i> Place Order
                </button>
            </form>

        <?php endif; ?>
    </div>

    <?php include __DIR__ . '/../templates/footer.php'; ?>

    <!-- interact.js — only loaded when T3+ is in cart -->
    <?php
    $needsInteract = false;
    foreach ($cartDisplay as $ci) { if ($ci['tier'] >= 3) { $needsInteract = true; break; } }
    ?>
    <?php if ($needsInteract): ?>
    <script src="https://cdn.jsdelivr.net/npm/interactjs/dist/interact.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', () => {

        /* ── Make existing .draggable items draggable ── */
        interact('.draggable').draggable({
            inertia: true,
            modifiers: [
                interact.modifiers.restrictRect({ restriction: 'parent', endOnly: true })
            ],
            listeners: {
                move(event) {
                    const target = event.target;
                    const x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx;
                    const y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;
                    target.style.transform = `translate(${x}px, ${y}px)`;
                    target.setAttribute('data-x', x);
                    target.setAttribute('data-y', y);
                }
            }
        });

        /* ── Sticker tray — add draggable text elements ── */
        document.querySelectorAll('.add-sticker').forEach(btn => {
            btn.addEventListener('click', () => {
                const panel = btn.closest('.customise-panel');
                const zone  = panel.querySelector('.interact-zone');
                const hint  = zone.querySelector('.drag-hint');
                if (hint) hint.style.display = 'none';

                const el = document.createElement('div');
                el.classList.add('draggable', 'text-sticker');
                el.textContent = btn.getAttribute('data-value');
                el.setAttribute('data-x', 20);
                el.setAttribute('data-y', 20);
                el.style.transform = 'translate(20px, 20px)';
                zone.appendChild(el);
            });
        });

        /* ── Toggle option cards ── */
        document.querySelectorAll('.option-card').forEach(card => {
            const input = card.querySelector('input');
            if (!input) return;
            card.addEventListener('click', () => {
                if (input.type === 'radio') {
                    card.closest('.option-grid').querySelectorAll('.option-card').forEach(c => c.classList.remove('selected'));
                    card.classList.add('selected');
                } else {
                    card.classList.toggle('selected', input.checked);
                }
            });
            if (input.checked) card.classList.add('selected');
        });
    });
    </script>
    <?php else: ?>
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.option-card').forEach(card => {
            const input = card.querySelector('input');
            if (!input) return;
            card.addEventListener('click', () => {
                if (input.type === 'radio') {
                    card.closest('.option-grid').querySelectorAll('.option-card').forEach(c => c.classList.remove('selected'));
                    card.classList.add('selected');
                } else {
                    card.classList.toggle('selected', input.checked);
                }
            });
            if (input.checked) card.classList.add('selected');
        });
    });
    </script>
    <?php endif; ?>
</body>
</html>