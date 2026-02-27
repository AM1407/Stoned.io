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

        /* ── Customise Canvas ── */
        .canvas-wrapper { position: relative; background: #0e0c0a; border: 2px dashed #3a3128; border-radius: 12px; overflow: hidden; margin-bottom: 12px; }
        .interact-canvas { position: relative; width: 100%; height: 400px; }
        .canvas-item { position: absolute; touch-action: none; user-select: none; cursor: grab; box-sizing: border-box; }
        .canvas-item:active { cursor: grabbing; }
        .canvas-item img { width: 100%; height: 100%; display: block; pointer-events: none; }
        .canvas-item.rock-item { z-index: 1; }
        .canvas-item.accessory-item { z-index: 10; }
        .canvas-item.selected { outline: 2px solid #c9a96e; outline-offset: 1px; z-index: 999 !important; }
        .canvas-item.selected .resize-handle { display: block; }
        .resize-handle { display: none; position: absolute; width: 11px; height: 11px; background: #c9a96e; border: 2px solid #1c1917; border-radius: 2px; z-index: 1000; }
        .resize-handle.nw { top: -6px; left: -6px; cursor: nw-resize; }
        .resize-handle.ne { top: -6px; right: -6px; cursor: ne-resize; }
        .resize-handle.sw { bottom: -6px; left: -6px; cursor: sw-resize; }
        .resize-handle.se { bottom: -6px; right: -6px; cursor: se-resize; }
        /* ── Canvas Toolbar ── */
        .canvas-toolbar { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; margin-bottom: 10px; padding: 8px 0; }
        .canvas-toolbar > label { font-size: 0.78rem; color: #9e9080; white-space: nowrap; }
        .bg-swatches { display: flex; gap: 6px; }
        .swatch { width: 22px; height: 22px; border-radius: 50%; border: 2px solid transparent; cursor: pointer; padding: 0; flex-shrink: 0; transition: border-color 0.2s; }
        .swatch.active, .swatch:hover { border-color: #c9a96e; }
        .btn-del-selected { display: inline-flex; align-items: center; gap: 5px; background: transparent; border: 1px solid #5a3030; color: #a05050; font-family: 'DM Sans', sans-serif; font-size: 0.78rem; font-weight: 600; padding: 5px 10px; border-radius: 6px; cursor: pointer; margin-left: auto; transition: all 0.2s; }
        .btn-del-selected:not([disabled]):hover { background: rgba(224,80,80,0.12); border-color: #e05050; color: #e05050; }
        .btn-del-selected[disabled] { opacity: 0.3; cursor: not-allowed; }
        /* ── Accessory Tray ── */
        .accessory-panel { background: #0e0c0a; border: 1px solid #2d2520; border-radius: 10px; overflow: hidden; margin-bottom: 16px; }
        .accessory-tabs { display: flex; border-bottom: 1px solid #2d2520; }
        .acc-tab { flex: 1; background: transparent; border: none; border-bottom: 2px solid transparent; padding: 10px 6px; font-family: 'DM Sans', sans-serif; font-size: 0.82rem; font-weight: 600; color: #5a5046; cursor: pointer; transition: color 0.2s, background 0.2s; }
        .acc-tab:hover { color: #e8dfc8; background: rgba(255,255,255,0.03); }
        .acc-tab.active { color: #c9a96e; border-bottom-color: #c9a96e; }
        .accessory-tray { display: none; padding: 12px 12px 8px; overflow-x: auto; white-space: nowrap; }
        .accessory-tray.active { display: block; }
        .accessory-tray::-webkit-scrollbar { height: 4px; }
        .accessory-tray::-webkit-scrollbar-thumb { background: #3a3128; border-radius: 4px; }
        .acc-item { display: inline-flex; flex-direction: column; align-items: center; gap: 4px; width: 72px; vertical-align: top; margin-right: 8px; cursor: pointer; }
        .acc-thumb { width: 56px; height: 56px; background: #1a1612; border: 1px solid #3a3128; border-radius: 8px; display: flex; align-items: center; justify-content: center; padding: 8px; transition: border-color 0.2s, transform 0.2s; }
        .acc-thumb img { width: 100%; height: 100%; object-fit: contain; }
        .acc-item:hover .acc-thumb { border-color: #c9a96e; transform: translateY(-2px); }
        .acc-item > span { font-size: 0.66rem; color: #7a6f60; text-align: center; white-space: normal; line-height: 1.2; }

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

        /* ── Remove button in banner ── */
        .pkg-remove-form { margin: 0; }
        .btn-remove-item { display: inline-flex; align-items: center; gap: 6px; background: transparent; border: 1px solid #5a3030; color: #a05050; font-family: 'DM Sans', sans-serif; font-size: 0.78rem; font-weight: 600; letter-spacing: 0.5px; padding: 6px 12px; border-radius: 6px; cursor: pointer; transition: background 0.2s ease, border-color 0.2s ease, color 0.2s ease; }
        .btn-remove-item:hover { background: rgba(224,80,80,0.12); border-color: #e05050; color: #e05050; }

        /* ── Price Summary ── */
        .price-summary { background: linear-gradient(160deg, #1e1b17 0%, #2a2420 100%); border: 1px solid #3a3128; border-radius: 12px; padding: 24px 28px; margin-top: 36px; }
        .price-row { display: flex; justify-content: space-between; align-items: center; padding: 8px 0; font-size: 0.9rem; color: #9e9080; }
        .price-row.total { border-top: 1px solid #3a3128; margin-top: 10px; padding-top: 14px; font-size: 1.2rem; font-weight: 800; color: #e8dfc8; }
        .price-row.total span:last-child { color: #c9a96e; font-size: 1.4rem; }

        /* ── Buttons ── */
        .btn-place-order { display: block; width: 100%; margin-top: 20px; padding: 16px; background: linear-gradient(135deg, #c9a96e 0%, #a88a4e 100%); color: #1c1917; font-family: 'DM Sans', sans-serif; font-size: 1rem; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; border: none; border-radius: 10px; cursor: pointer; transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease; }
        .btn-place-order:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(201, 169, 110, 0.35); background: linear-gradient(135deg, #d4b87a 0%, #b49558 100%); }
        .btn-place-order:active { transform: translateY(0); }
        /* ── Ko-fi in checkout ── */
        .kofi-checkout { background: rgba(255,94,91,0.07); border: 1px solid rgba(255,94,91,0.25); border-radius: 10px; padding: 18px 20px; margin-top: 20px; display: flex; flex-direction: column; gap: 12px; }
        .kofi-note { display: flex; gap: 10px; align-items: flex-start; font-size: 0.82rem; color: #9e9080; }
        .kofi-note i { color: #FF5E5B; font-size: 1rem; flex-shrink: 0; margin-top: 2px; }
        .kofi-note strong { color: #e8dfc8; }
        .kofi-item-row { display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; padding: 8px 0; border-top: 1px solid rgba(255,94,91,0.12); }
        .kofi-item-label { font-size: 0.85rem; color: #e8dfc8; }
        .kofi-item-label em { color: #c9a96e; font-style: normal; }
        .btn-kofi-cart { display: inline-flex; align-items: center; justify-content: center; gap: 8px; background: #FF5E5B; color: #fff; font-family: 'DM Sans', sans-serif; font-size: 0.88rem; font-weight: 700; padding: 10px 18px; border-radius: 8px; border: none; cursor: pointer; text-decoration: none; transition: opacity 0.2s; white-space: nowrap; }
        .btn-kofi-cart:hover { opacity: 0.88; }

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
                    <div style="display:flex;flex-direction:column;align-items:flex-end;gap:10px;">
                        <div class="pkg-price"><?= $ci['price'] ?>€</div>
                        <form class="pkg-remove-form" action="remove-from-cart.php" method="POST">
                            <input type="hidden" name="cart_index" value="<?= $ci['index'] ?>">
                            <button type="submit" class="btn-remove-item">
                                <i class="bi bi-trash3"></i> Remove
                            </button>
                        </form>
                    </div>
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
                    <!-- ── Customisation Panel (T3+) ── -->
                    <div class="customise-panel" data-tier="<?= $ci['tier'] ?>" data-cart-index="<?= $ci['index'] ?>">
                        <h3><i class="bi bi-palette"></i> Customise Your Rock</h3>
                        <p style="color:#9e9080;font-size:0.82rem;margin-bottom:12px;">Drag &amp; resize rocks and accessories. Click to select, Delete key or button to remove.</p>

                        <!-- Toolbar -->
                        <div class="canvas-toolbar">
                            <label>Canvas BG:</label>
                            <div class="bg-swatches">
                                <button type="button" class="swatch active" data-bg="#0e0c0a" style="background:#0e0c0a" title="Obsidian"></button>
                                <button type="button" class="swatch" data-bg="#1a2e1a" style="background:#1a2e1a" title="Forest"></button>
                                <button type="button" class="swatch" data-bg="#1a1a2e" style="background:#1a1a2e" title="Midnight"></button>
                                <button type="button" class="swatch" data-bg="#2e1a1a" style="background:#2e1a1a" title="Ember"></button>
                                <button type="button" class="swatch" data-bg="#2a2410" style="background:#2a2410" title="Sand"></button>
                                <button type="button" class="swatch" data-bg="#f5f0e8" style="background:#f5f0e8" title="Parchment"></button>
                            </div>
                            <button type="button" class="btn-del-selected" disabled><i class="bi bi-trash3"></i> Delete</button>
                        </div>

                        <!-- Canvas -->
                        <div class="canvas-wrapper">
                            <div class="interact-canvas" id="canvas-<?= $ci['index'] ?>"
                                 data-rocks='<?= json_encode(array_values($ci['rocks']), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>'
                                 data-rock-name="<?= htmlspecialchars($ci['rocks'][0]['name'] ?? 'Mystery Rock') ?>"
                                 data-rock-backstory="<?= htmlspecialchars($ci['rocks'][0]['backstory'] ?? '') ?>">
                            </div>
                        </div>

                        <!-- Accessory Tray -->
                        <div class="accessory-panel">
                            <div class="accessory-tabs">
                                <?php $first = true; foreach ($customOptions as $catKey => $catItems): ?>
                                    <button type="button" class="acc-tab<?= $first ? ' active' : '' ?>"
                                            data-cat="acc-<?= $ci['index'] ?>-<?= htmlspecialchars($catKey) ?>">
                                        <?= htmlspecialchars(ucfirst($catKey)) ?>
                                    </button>
                                <?php $first = false; endforeach; ?>
                            </div>
                            <?php $first = true; foreach ($customOptions as $catKey => $catItems): ?>
                                <div class="accessory-tray<?= $first ? ' active' : '' ?>"
                                     id="acc-<?= $ci['index'] ?>-<?= htmlspecialchars($catKey) ?>">
                                    <?php foreach ($catItems as $acc): ?>
                                        <div class="acc-item"
                                             data-svg="img/<?= htmlspecialchars($acc['image']) ?>"
                                             data-acc-name="<?= htmlspecialchars($acc['name']) ?>">
                                            <div class="acc-thumb">
                                                <img src="img/<?= htmlspecialchars($acc['image']) ?>"
                                                     alt="<?= htmlspecialchars($acc['name']) ?>"
                                                     onerror="this.style.display='none';this.parentElement.innerHTML+='<i class=\'bi bi-question-circle\' style=\'color:#5a5046;font-size:1.4rem\'></i>'">
                                            </div>
                                            <span><?= htmlspecialchars($acc['name']) ?></span>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php $first = false; endforeach; ?>
                        </div>

                        <div class="form-group" style="margin-top:4px;">
                            <label for="customName-<?= $ci['index'] ?>">Custom Display Name (shown on PDF)</label>
                            <input type="text" id="customName-<?= $ci['index'] ?>"
                                   name="custom_name[<?= $ci['index'] ?>]"
                                   placeholder="Give your rock a new identity" maxlength="40">
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

                <!-- ── Ko-fi Payment — one row per item ── -->
                <div class="kofi-checkout">
                    <div class="kofi-note">
                        <i class="bi bi-cup-hot-fill"></i>
                        <span>We use <strong>Ko-fi</strong> for payment. Each package has its own product page — clicking <em>Place Order</em> opens them for you.</span>
                    </div>
                    <?php foreach ($cartDisplay as $ci): ?>
                        <div class="kofi-item-row">
                            <span class="kofi-item-label">
                                <strong><?= htmlspecialchars($ci['label']) ?></strong>
                                <em>&mdash; <?= $ci['price'] ?>&#x20AC;</em>
                            </span>
                            <a class="btn-kofi-cart kofi-item-link"
                               href="<?= htmlspecialchars($kofiLinks[$ci['tier']]) ?>"
                               target="_blank" rel="noopener noreferrer">
                                <i class="bi bi-cup-hot-fill"></i> Pay <?= $ci['price'] ?>&#x20AC;
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Hidden canvas captures filled by JS on submit (T3 items) -->
                <?php foreach ($cartDisplay as $ci): ?>
                    <?php if ($ci['tier'] >= 3): ?>
                        <input type="hidden"
                               name="canvas_capture[<?= $ci['index'] ?>]"
                               id="captureInput-<?= $ci['index'] ?>">
                    <?php endif; ?>
                <?php endforeach; ?>

                <button type="submit" name="place_order" value="1" class="btn-place-order">
                    <i class="bi bi-lock-fill"></i> Place Order &amp; Continue to Ko-fi
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
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', () => {

        let zTop = 20;

        // ── Create a canvas item (rock or accessory) ─────────────────
        function makeItem(canvas, { x = 20, y = 20, w = 120, h = 120, src, isRock = false, name = '' }) {
            const wrap = document.createElement('div');
            wrap.classList.add('canvas-item', isRock ? 'rock-item' : 'accessory-item');
            wrap.style.cssText = `transform:translate(${x}px,${y}px);width:${w}px;height:${h}px;z-index:${isRock ? 1 : ++zTop};`;
            wrap.dataset.x = x;
            wrap.dataset.y = y;

            const img = document.createElement('img');
            img.src = src;
            img.alt = name;
            wrap.appendChild(img);

            ['nw','ne','sw','se'].forEach(pos => {
                const h = document.createElement('div');
                h.className = 'resize-handle ' + pos;
                wrap.appendChild(h);
            });

            wrap.addEventListener('pointerdown', (e) => {
                if (!e.target.classList.contains('resize-handle')) select(wrap);
            });

            canvas.appendChild(wrap);
            return wrap;
        }

        function select(el) {
            document.querySelectorAll('.canvas-item.selected').forEach(i => i.classList.remove('selected'));
            el.classList.add('selected');
            el.style.zIndex = ++zTop;
            const panel = el.closest('.customise-panel');
            if (panel) panel.querySelector('.btn-del-selected').removeAttribute('disabled');
        }

        function deselectAll() {
            document.querySelectorAll('.canvas-item.selected').forEach(i => i.classList.remove('selected'));
            document.querySelectorAll('.btn-del-selected').forEach(b => b.setAttribute('disabled', ''));
        }

        // ── Initialise each canvas with its rocks ────────────────────
        document.querySelectorAll('.interact-canvas').forEach(canvas => {
            const rocks = JSON.parse(canvas.dataset.rocks || '[]');
            const cw    = canvas.offsetWidth  || 600;
            const ch    = canvas.offsetHeight || 400;
            const step  = Math.floor(cw / (rocks.length + 1));
            rocks.forEach((rock, i) => {
                makeItem(canvas, {
                    x: step * (i + 1) - 75,
                    y: Math.floor((ch - 150) / 2),
                    w: 150, h: 150,
                    src: 'img/' + rock.image,
                    isRock: true,
                    name: rock.name ?? 'Rock'
                });
            });
        });

        // ── interact.js: drag ────────────────────────────────────────
        interact('.canvas-item').draggable({
            inertia: false,
            modifiers: [ interact.modifiers.restrictRect({ restriction: 'parent', endOnly: false }) ],
            listeners: {
                start: e => select(e.target),
                move(e) {
                    const t = e.target;
                    const x = (parseFloat(t.dataset.x) || 0) + e.dx;
                    const y = (parseFloat(t.dataset.y) || 0) + e.dy;
                    t.style.transform = `translate(${x}px,${y}px)`;
                    t.dataset.x = x; t.dataset.y = y;
                }
            }
        });

        // ── interact.js: resize ──────────────────────────────────────
        interact('.canvas-item').resizable({
            edges: { top: '.nw,.ne', left: '.nw,.sw', bottom: '.sw,.se', right: '.ne,.se' },
            modifiers: [ interact.modifiers.restrictSize({ min: { width: 30, height: 30 } }) ],
            listeners: {
                start: e => select(e.target),
                move(e) {
                    const t = e.target;
                    const x = (parseFloat(t.dataset.x) || 0) + e.deltaRect.left;
                    const y = (parseFloat(t.dataset.y) || 0) + e.deltaRect.top;
                    t.style.transform = `translate(${x}px,${y}px)`;
                    t.style.width  = e.rect.width  + 'px';
                    t.style.height = e.rect.height + 'px';
                    t.dataset.x = x; t.dataset.y = y;
                }
            }
        });

        // ── Click canvas background → deselect ───────────────────────
        document.querySelectorAll('.interact-canvas').forEach(c => {
            c.addEventListener('pointerdown', e => { if (e.target === c) deselectAll(); });
        });

        // ── Delete button ────────────────────────────────────────────
        document.querySelectorAll('.btn-del-selected').forEach(btn => {
            btn.addEventListener('click', () => {
                const sel = btn.closest('.customise-panel').querySelector('.canvas-item.selected');
                if (sel) { sel.remove(); btn.setAttribute('disabled', ''); }
            });
        });
        document.addEventListener('keydown', e => {
            if ((e.key === 'Delete' || e.key === 'Backspace') &&
                 e.target.tagName !== 'INPUT' && e.target.tagName !== 'TEXTAREA') {
                document.querySelectorAll('.canvas-item.selected').forEach(el => {
                    el.closest('.customise-panel')?.querySelector('.btn-del-selected')?.setAttribute('disabled', '');
                    el.remove();
                });
            }
        });

        // ── Accessory tray tabs ───────────────────────────────────────
        document.querySelectorAll('.acc-tab').forEach(tab => {
            tab.addEventListener('click', () => {
                const ap = tab.closest('.accessory-panel');
                ap.querySelectorAll('.acc-tab').forEach(t => t.classList.remove('active'));
                ap.querySelectorAll('.accessory-tray').forEach(t => t.classList.remove('active'));
                tab.classList.add('active');
                document.getElementById(tab.dataset.cat)?.classList.add('active');
            });
        });

        // ── Add accessory from tray ───────────────────────────────────
        document.querySelectorAll('.acc-item').forEach(item => {
            item.addEventListener('click', () => {
                const canvas = item.closest('.customise-panel').querySelector('.interact-canvas');
                const el = makeItem(canvas, {
                    x: 30 + Math.random() * 100,
                    y: 30 + Math.random() * 100,
                    w: 80, h: 80,
                    src: item.dataset.svg,
                    isRock: false,
                    name: item.dataset.accName
                });
                select(el);
            });
        });

        // ── Background colour swatches ────────────────────────────────
        document.querySelectorAll('.swatch').forEach(sw => {
            sw.addEventListener('click', () => {
                const panel = sw.closest('.customise-panel');
                panel.querySelectorAll('.swatch').forEach(s => s.classList.remove('active'));
                sw.classList.add('active');
                panel.querySelector('.canvas-wrapper').style.background = sw.dataset.bg;
            });
        });

        // ── Form submit: open Ko-fi tabs + capture T3 canvases before posting ────────────────
        const orderForm = document.getElementById('orderForm');
        if (orderForm) {
            orderForm.addEventListener('submit', async (e) => {
                const kofiLinks = orderForm.querySelectorAll('.kofi-item-link');
                const captures  = orderForm.querySelectorAll('input[name^="canvas_capture"]');

                if (!kofiLinks.length && !captures.length) return; // nothing to do

                e.preventDefault();

                // Open one Ko-fi tab per item
                kofiLinks.forEach(link => window.open(link.href, '_blank'));

                // Capture T3 canvases if any
                if (captures.length) {
                    try {
                        for (const input of captures) {
                            const canvasId = input.id.replace('captureInput-', 'canvas-');
                            const canvasEl = document.getElementById(canvasId);
                            const wrapEl   = canvasEl?.closest('.canvas-wrapper');
                            if (!wrapEl) continue;
                            deselectAll();
                            const snap = await html2canvas(wrapEl, {
                                backgroundColor: null, scale: 2,
                                useCORS: true, allowTaint: true, logging: false
                            });
                            input.value = snap.toDataURL('image/png');
                        }
                    } catch (err) {
                        console.warn('Canvas capture failed, continuing anyway:', err);
                    }
                }

                orderForm.submit();
            });
        }

    });
    </script>
    <?php else: ?>
    <script>document.addEventListener('DOMContentLoaded', () => {});</script>
    <?php endif; ?>
</body>
</html>
