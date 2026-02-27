<?php
session_start();

// Guard — if no completed order in session, bounce back to shop
if (empty($_SESSION['last_order'])) {
    header('Location: index.php');
    exit;
}

$order        = $_SESSION['last_order'];
$orderRef     = $order['ref']            ?? 'ORD-UNKNOWN';
$orderEmail   = $order['email']          ?? '';
$orderTotal   = $order['total']          ?? 0;
$orderItems   = $order['items']          ?? [];
$customNames  = $order['custom_names']   ?? [];
$placedAt     = $order['placed_at']      ?? date('Y-m-d H:i:s');
$recipName    = $order['recipient_name'] ?? '';
$giftMsg      = $order['gift_message']   ?? '';

$hasCertItems   = !empty($orderItems);
$canvasCaptures = $order['canvas_captures'] ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmed — Stoned.io</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body { background: #141210; color: #e8dfc8; font-family: 'DM Sans', sans-serif; }

        .confirm-wrap { max-width: 780px; margin: 48px auto; padding: 0 24px 80px; }

        /* ── Hero ── */
        .confirm-hero { text-align: center; padding: 48px 0 36px; }
        .hero-icon { font-size: 3.6rem; color: #50c878; display: block; margin-bottom: 16px;
                     animation: popIn 0.45s cubic-bezier(0.175, 0.885, 0.32, 1.275) both; }
        @keyframes popIn { from { transform: scale(0); opacity: 0; } to { transform: scale(1); opacity: 1; } }
        .confirm-hero h1 { font-size: 2rem; font-weight: 700; color: #e8dfc8; margin-bottom: 8px; }
        .confirm-hero p  { color: #9e9080; font-size: 0.95rem; }
        .order-ref { display: inline-block; background: rgba(201,169,110,0.12); border: 1px solid rgba(201,169,110,0.3);
                     border-radius: 6px; padding: 6px 16px; font-size: 0.85rem; font-weight: 700;
                     letter-spacing: 1.5px; color: #c9a96e; margin-top: 14px; }

        /* ── Sections ── */
        .section-card { background: linear-gradient(160deg, #1e1b17 0%, #2a2420 100%);
                        border: 1px solid #3a3128; border-radius: 14px; padding: 28px 32px; margin-bottom: 24px; }
        .section-card h2 { font-size: 1.05rem; font-weight: 700; color: #c9a96e;
                           letter-spacing: 0.5px; margin-bottom: 18px;
                           display: flex; align-items: center; gap: 8px; }
        .section-divider { border: none; border-top: 1px solid #2d2520; margin: 18px 0; }

        /* ── Order Items ── */
        .order-item { display: flex; gap: 18px; align-items: flex-start; padding: 14px 0; }
        .order-item + .order-item { border-top: 1px solid #2d2520; }
        .order-item img { width: 72px; height: 72px; object-fit: cover; border-radius: 8px;
                          border: 1px solid #3a3128; background: #0e0c0a; flex-shrink: 0; }
        .order-item-info { flex: 1; }
        .order-item-info .pkg-badge { font-size: 0.7rem; font-weight: 700; letter-spacing: 1.5px;
                                      text-transform: uppercase; color: #c9a96e; margin-bottom: 4px; }
        .order-item-info h3 { font-size: 1rem; font-weight: 700; color: #e8dfc8; margin-bottom: 4px; }
        .order-item-info .rock-tier { font-size: 0.75rem; color: #7a6f60; }
        .order-item-price { font-weight: 700; color: #c9a96e; font-size: 1rem; white-space: nowrap; }

        .total-row { display: flex; justify-content: space-between; align-items: center;
                     padding: 14px 0 0; border-top: 1px solid #3a3128; margin-top: 6px; }
        .total-row span:first-child { font-size: 0.85rem; color: #9e9080; text-transform: uppercase;
                                       letter-spacing: 1px; font-weight: 600; }
        .total-row span:last-child  { font-size: 1.3rem; font-weight: 700; color: #c9a96e; }

        /* ── Payment ── */
        .pay-block { background: rgba(255,94,91,0.07); border: 1px solid rgba(255,94,91,0.22); border-radius: 10px; padding: 24px; }
        .pay-block h3 { font-size: 0.95rem; font-weight: 700; color: #e8dfc8; margin-bottom: 8px;
                        display: flex; align-items: center; gap: 7px; }
        .pay-block p { font-size: 0.82rem; color: #7a6f60; margin-bottom: 16px; line-height: 1.5; }
        .btn-kofi { display: inline-flex; align-items: center; gap: 8px; width: 100%;
                    justify-content: center; background: #FF5E5B; color: #fff;
                    font-family: 'DM Sans', sans-serif; font-size: 0.95rem; font-weight: 700;
                    padding: 13px 18px; border-radius: 8px; border: none; cursor: pointer;
                    text-decoration: none; transition: opacity 0.2s, box-shadow 0.2s; }
        .btn-kofi:hover { opacity: 0.88; box-shadow: 0 4px 18px rgba(255,94,91,0.35); }

        /* ── Certificates ── */
        .cert-item { display: flex; gap: 16px; align-items: center; padding: 14px 0; flex-wrap: wrap; }
        .cert-item + .cert-item { border-top: 1px solid #2d2520; }
        .cert-preview-wrap { position: relative; }
        .cert-preview { width: 120px; height: 120px; border-radius: 10px; background: #0e0c0a;
                        border: 1px solid #3a3128; overflow: hidden; position: relative;
                        flex-shrink: 0; }
        .cert-preview img { width: 100%; height: 100%; object-fit: cover; }
        .cert-info { flex: 1; min-width: 160px; }
        .cert-info .cert-tier { font-size: 0.7rem; color: #c9a96e; font-weight: 700;
                                 letter-spacing: 1.5px; text-transform: uppercase; margin-bottom: 4px; }
        .cert-info h3 { font-size: 1rem; font-weight: 700; color: #e8dfc8; margin-bottom: 6px; }
        .cert-info p  { font-size: 0.78rem; color: #7a6f60; line-height: 1.5; }
        .btn-dl-cert { display: inline-flex; align-items: center; gap: 7px; margin-top: 12px;
                       background: linear-gradient(135deg, #c9a96e 0%, #a88a4e 100%);
                       color: #1c1917; font-family: 'DM Sans', sans-serif; font-size: 0.85rem;
                       font-weight: 700; padding: 9px 18px; border-radius: 8px; border: none;
                       cursor: pointer; transition: opacity 0.2s, box-shadow 0.2s; white-space: nowrap; }
        .btn-dl-cert:hover { opacity: 0.88; box-shadow: 0 4px 14px rgba(201,169,110,0.3); }
        .btn-dl-cert[disabled] { opacity: 0.5; cursor: wait; }

        /* ── Footer actions ── */
        .confirm-actions { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; margin-top: 32px; }
        .btn-ghost { display: inline-flex; align-items: center; gap: 6px; background: transparent;
                     border: 1px solid #3a3128; color: #9e9080; font-family: 'DM Sans', sans-serif;
                     font-size: 0.88rem; font-weight: 600; padding: 10px 20px; border-radius: 8px;
                     text-decoration: none; transition: border-color 0.2s, color 0.2s; }
        .btn-ghost:hover { border-color: #c9a96e; color: #c9a96e; }
        .btn-primary { display: inline-flex; align-items: center; gap: 6px;
                       background: linear-gradient(135deg, #c9a96e 0%, #a88a4e 100%);
                       color: #1c1917; font-family: 'DM Sans', sans-serif; font-size: 0.88rem;
                       font-weight: 700; padding: 10px 22px; border-radius: 8px;
                       text-decoration: none; transition: opacity 0.2s; }
        .btn-primary:hover { opacity: 0.88; }
    </style>
</head>
<body>

<?php include '../templates/navbar.php'; ?>

<div class="confirm-wrap">

    <!-- ── Hero ── -->
    <div class="confirm-hero">
        <i class="bi bi-check-circle-fill hero-icon"></i>
        <h1>Order Confirmed!</h1>
        <p>A (very official) confirmation has been sent to <strong><?= htmlspecialchars($orderEmail) ?></strong>.</p>
        <p class="order-ref"><?= htmlspecialchars($orderRef) ?></p>
        <p style="color:#5a5046; font-size:0.78rem; margin-top:10px;">Placed <?= htmlspecialchars($placedAt) ?></p>
    </div>

    <!-- ── Order Summary ── -->
    <div class="section-card">
        <h2><i class="bi bi-receipt"></i> Order Summary</h2>

        <?php foreach ($orderItems as $ci): ?>
            <?php $rock = $ci['rocks'][0] ?? null; ?>
            <div class="order-item">
                <?php if ($rock): ?>
                    <img src="img/<?= htmlspecialchars($rock['image']) ?>"
                         alt="<?= htmlspecialchars($rock['name'] ?? 'Rock') ?>"
                         onerror="this.src='img/rock-svgrepo-com.svg'">
                <?php endif; ?>
                <div class="order-item-info">
                    <div class="pkg-badge"><?= htmlspecialchars($ci['badge'] ?? 'Tier ' . $ci['tier']) ?></div>
                    <h3><?= htmlspecialchars($ci['label']) ?></h3>
                    <?php if ($rock): ?>
                        <div class="rock-tier">
                            Your rock: <strong style="color:#c9a96e"><?= htmlspecialchars($rock['name']) ?></strong>
                            <?php if (!empty($customNames[$ci['index']])): ?>
                                — displayed as "<em><?= htmlspecialchars($customNames[$ci['index']]) ?></em>"
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <?php if (count($ci['rocks']) > 1): ?>
                        <div class="rock-tier" style="margin-top:4px;">
                            Also includes:
                            <?= implode(', ', array_map(fn($r) => '<strong style="color:#c9a96e">' . htmlspecialchars($r['name']) . '</strong>', array_slice($ci['rocks'], 1))) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="order-item-price"><?= $ci['price'] ?>€</div>
            </div>
        <?php endforeach; ?>

        <?php if ($recipName): ?>
            <hr class="section-divider">
            <div style="font-size:0.82rem; color:#9e9080;">
                <i class="bi bi-gift" style="color:#c9a96e; margin-right:6px;"></i>
                Gift for <strong style="color:#e8dfc8;"><?= htmlspecialchars($recipName) ?></strong>
                <?= $giftMsg ? '— "' . htmlspecialchars($giftMsg) . '"' : '' ?>
            </div>
        <?php endif; ?>

        <div class="total-row">
            <span>Order Total</span>
            <span><?= $orderTotal ?>€</span>
        </div>
    </div>

    <!-- ── Payment ── -->
    <div class="section-card">
        <h2><i class="bi bi-cup-hot-fill" style="color:#FF5E5B;"></i> Complete Payment</h2>
        <div class="pay-block">
            <h3><i class="bi bi-cup-hot-fill" style="color:#FF5E5B;"></i> Pay via Ko-fi</h3>
            <p>Ko-fi handles your payment securely. No account needed &mdash; just a card and a newfound love of rocks.</p>
            <a class="btn-kofi"
               href="https://ko-fi.com/stonedio"
               target="_blank" rel="noopener noreferrer">
                <i class="bi bi-cup-hot-fill"></i> Pay <?= $orderTotal ?>&#x20AC; on Ko-fi
            </a>
        </div>
    </div>

    <!-- ── Your Rock Documents (all tiers) ── -->
    <?php if ($hasCertItems): ?>
    <div class="section-card">
        <h2><i class="bi bi-file-earmark-pdf-fill"></i> Your Rock Documents</h2>
        <p style="font-size:0.82rem; color:#7a6f60; margin-bottom:18px;">
            Download your personalised rock document. T4 owners get one certificate per rock.
        </p>

        <?php foreach ($orderItems as $ci):
            $tier        = (int)($ci['tier'] ?? 1);
            $customName  = $customNames[$ci['index']] ?? '';
            $capture     = $canvasCaptures[$ci['index']] ?? '';
            $rocksForDoc = ($tier === 4) ? $ci['rocks'] : [$ci['rocks'][0] ?? null];
            $tierLabels  = [1=>'Pebble Package',2=>'Boulder Package',3=>'ROCKstar Package',4=>'Pristine Stone Package'];
        ?>
            <?php foreach ($rocksForDoc as $rock):
                if (!$rock) continue;
                $rockName    = $rock['name']      ?? 'Mystery Rock';
                $backstory   = $rock['backstory'] ?? '';
                $rockImg     = $rock['image']     ?? 'rock-svgrepo-com.svg';
                $displayName = ($customName && $tier !== 4) ? $customName : $rockName;
                $dlLabel     = ($tier === 4) ? 'Download Certificate' : 'Download PDF';
            ?>
                <div class="cert-item">
                    <div class="cert-preview">
                        <img src="img/<?= htmlspecialchars($rockImg) ?>"
                             alt="<?= htmlspecialchars($rockName) ?>"
                             onerror="this.src='img/rock-svgrepo-com.svg'">
                    </div>
                    <div class="cert-info">
                        <div class="cert-tier"><?= htmlspecialchars($tierLabels[$tier] ?? 'Tier '.$tier) ?></div>
                        <h3><?= htmlspecialchars($displayName) ?></h3>
                        <?php if ($backstory && $tier >= 2): ?>
                            <p><?= htmlspecialchars(mb_substr($backstory, 0, 120)) ?><?= mb_strlen($backstory) > 120 ? '&hellip;' : '' ?></p>
                        <?php endif; ?>
                        <button class="btn-dl-cert"
                                data-tier="<?= $tier ?>"
                                data-rock-name="<?= htmlspecialchars($rockName) ?>"
                                data-display-name="<?= htmlspecialchars($displayName) ?>"
                                data-backstory="<?= htmlspecialchars($backstory) ?>"
                                data-rock-img="img/<?= htmlspecialchars($rockImg) ?>"
                                data-canvas-capture="<?= htmlspecialchars($capture) ?>">
                            <i class="bi bi-file-earmark-arrow-down"></i>
                            <?= $dlLabel ?>
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endforeach; ?>

        <p style="font-size:0.68rem; color:#5a5046; margin-top:14px;">
            * T4 certificates are legally non-binding in most jurisdictions. Spiritual binding may vary.
        </p>
    </div>
    <?php endif; ?>

    <!-- ── Actions ── -->
    <div class="confirm-actions">
        <a href="index.php" class="btn-primary"><i class="bi bi-gem"></i> Adopt Another Rock</a>
        <a href="cart.php"  class="btn-ghost"><i class="bi bi-basket2"></i> View Basket</a>
    </div>

</div>

<?php include '../templates/footer.php'; ?>

<?php if ($hasCertItems): ?>
<script src="https://cdn.jsdelivr.net/npm/jspdf@2.5.1/dist/jspdf.umd.min.js"></script>
<script>
// ── Load a same-origin image as base64 data URL ────────────────────
function imgToDataUrl(src) {
    return new Promise((resolve) => {
        const img = new Image();
        img.crossOrigin = 'anonymous';
        img.onload = () => {
            const c = document.createElement('canvas');
            c.width  = img.naturalWidth  || 400;
            c.height = img.naturalHeight || 400;
            c.getContext('2d').drawImage(img, 0, 0);
            resolve(c.toDataURL('image/png'));
        };
        img.onerror = () => resolve(null);
        img.src = src;
    });
}

// ── T1: photo + name only ───────────────────────────────────────
async function pdfT1(displayName, rockImg) {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF({ orientation: 'portrait', unit: 'mm', format: 'a4' });
    const pw = 210, ph = 297;
    doc.setFillColor(20, 18, 16);
    doc.rect(0, 0, pw, ph, 'F');
    doc.setDrawColor(58, 49, 40);
    doc.setLineWidth(0.5);
    doc.roundedRect(12, 12, 186, 273, 2, 2);

    const imgData = await imgToDataUrl(rockImg);
    if (imgData) {
        doc.addImage(imgData, 'PNG', (pw - 150) / 2, 50, 150, 150);
    }

    doc.setFont('helvetica', 'bold');
    doc.setFontSize(20);
    doc.setTextColor(232, 223, 200);
    doc.text(displayName, pw / 2, 220, { align: 'center' });

    doc.setFont('helvetica', 'normal');
    doc.setFontSize(7);
    doc.setTextColor(90, 80, 68);
    doc.text('Stoned.io — Pebble Package', pw / 2, 278, { align: 'center' });
    return doc;
}

// ── T2: photo + name + backstory ──────────────────────────────
async function pdfT2(displayName, backstory, rockImg) {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF({ orientation: 'portrait', unit: 'mm', format: 'a4' });
    const pw = 210;
    doc.setFillColor(20, 18, 16);
    doc.rect(0, 0, pw, 297, 'F');
    doc.setDrawColor(58, 49, 40);
    doc.setLineWidth(0.5);
    doc.roundedRect(12, 12, 186, 273, 2, 2);

    const imgData = await imgToDataUrl(rockImg);
    if (imgData) {
        doc.addImage(imgData, 'PNG', (pw - 130) / 2, 28, 130, 130);
    }

    doc.setFont('helvetica', 'bold');
    doc.setFontSize(18);
    doc.setTextColor(232, 223, 200);
    doc.text(displayName, pw / 2, 172, { align: 'center' });

    doc.setDrawColor(58, 49, 40);
    doc.setLineWidth(0.35);
    doc.line(25, 177, 185, 177);

    if (backstory) {
        doc.setFont('helvetica', 'normal');
        doc.setFontSize(8.5);
        doc.setTextColor(158, 144, 128);
        const lines = doc.splitTextToSize(backstory, 162);
        doc.text(lines.slice(0, 18), 24, 185);
    }

    doc.setFont('helvetica', 'normal');
    doc.setFontSize(7);
    doc.setTextColor(90, 80, 68);
    doc.text('Stoned.io — Boulder Package', pw / 2, 278, { align: 'center' });
    return doc;
}

// ── T3: canvas capture + name + backstory ────────────────────────
async function pdfT3(displayName, backstory, rockImg, canvasCapture) {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF({ orientation: 'portrait', unit: 'mm', format: 'a4' });
    const pw = 210;
    doc.setFillColor(20, 18, 16);
    doc.rect(0, 0, pw, 297, 'F');
    doc.setDrawColor(58, 49, 40);
    doc.setLineWidth(0.5);
    doc.roundedRect(12, 12, 186, 273, 2, 2);

    // Use canvas capture if available, else fall back to rock photo
    const imgData = (canvasCapture && canvasCapture.startsWith('data:'))
        ? canvasCapture
        : await imgToDataUrl(rockImg);

    if (imgData) {
        const imgW = 164;
        const imgH = imgW * (2 / 3); // canvas is roughly 3:2 landscape
        doc.addImage(imgData, 'PNG', (pw - imgW) / 2, 22, imgW, imgH);
    }

    const imgBottom = 22 + 164 * (2 / 3);
    doc.setFont('helvetica', 'bold');
    doc.setFontSize(18);
    doc.setTextColor(232, 223, 200);
    doc.text(displayName, pw / 2, imgBottom + 12, { align: 'center' });

    doc.setDrawColor(58, 49, 40);
    doc.setLineWidth(0.35);
    doc.line(25, imgBottom + 16, 185, imgBottom + 16);

    if (backstory) {
        doc.setFont('helvetica', 'normal');
        doc.setFontSize(8.5);
        doc.setTextColor(158, 144, 128);
        const lines = doc.splitTextToSize(backstory, 162);
        doc.text(lines.slice(0, 12), 24, imgBottom + 22);
    }

    doc.setFont('helvetica', 'normal');
    doc.setFontSize(7);
    doc.setTextColor(90, 80, 68);
    doc.text('Stoned.io — ROCKstar Package', pw / 2, 278, { align: 'center' });
    return doc;
}

// ── T4: styled adoption certificate ─────────────────────────────
async function pdfT4(displayName, backstory, rockImg) {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF({ orientation: 'portrait', unit: 'mm', format: 'a4' });
    const pw = 210, ph = 297;

    doc.setFillColor(20, 18, 16);
    doc.rect(0, 0, pw, ph, 'F');

    // Corner marks
    const corner = (x, y, rx, ry) => {
        doc.setDrawColor(201, 169, 110); doc.setLineWidth(0.4);
        doc.line(x, y, x + rx * 6, y); doc.line(x, y, x, y + ry * 6);
    };
    corner(10, 10, 1, 1); corner(200, 10, -1, 1);
    corner(10, 287, 1, -1); corner(200, 287, -1, -1);

    doc.setLineWidth(0.7);
    doc.setDrawColor(201, 169, 110);
    doc.roundedRect(10, 10, 190, 277, 3, 3);
    doc.setLineWidth(0.25);
    doc.roundedRect(13, 13, 184, 271, 2, 2);

    doc.setFillColor(201, 169, 110);
    doc.roundedRect(50, 19, 110, 9, 1.5, 1.5, 'F');
    doc.setTextColor(28, 25, 23);
    doc.setFont('helvetica', 'bold');
    doc.setFontSize(7);
    doc.text('CERTIFICATE OF ROCK ADOPTION', pw / 2, 24.6, { align: 'center' });

    doc.setFontSize(24);
    doc.setTextColor(232, 223, 200);
    doc.text(displayName, pw / 2, 40, { align: 'center' });

    doc.setFontSize(8);
    doc.setFont('helvetica', 'italic');
    doc.setTextColor(122, 111, 96);
    doc.text('Stoned.io Official Adoption Document', pw / 2, 47, { align: 'center' });

    const imgData = await imgToDataUrl(rockImg);
    if (imgData) {
        doc.addImage(imgData, 'PNG', (pw - 120) / 2, 54, 120, 120);
    }

    let y = 58 + 120;
    doc.setDrawColor(58, 49, 40); doc.setLineWidth(0.4);
    doc.line(25, y, 185, y); y += 8;

    if (backstory) {
        doc.setFont('helvetica', 'bold'); doc.setFontSize(6.5);
        doc.setTextColor(201, 169, 110);
        doc.text('BACKSTORY', 25, y); y += 5;
        doc.setFont('helvetica', 'normal'); doc.setFontSize(8.5);
        doc.setTextColor(168, 154, 138);
        const lines = doc.splitTextToSize(backstory, 160);
        const maxLines = Math.floor((255 - y) / 4.2);
        doc.text(lines.slice(0, maxLines), 25, y);
        y += Math.min(lines.length, maxLines) * 4.2 + 6;
    }

    doc.setFont('helvetica', 'italic'); doc.setFontSize(7.5);
    doc.setTextColor(90, 80, 68);
    const seal = `This document certifies that "${displayName}" has been officially adopted and is now your rock. ` +
                 `This bond is spiritual, financial, and probably tax-deductible.`;
    doc.text(doc.splitTextToSize(seal, 160), pw / 2, 268, { align: 'center' });

    doc.setDrawColor(58, 49, 40); doc.setLineWidth(0.3);
    doc.line(25, 274, 185, 274);
    doc.setFont('helvetica', 'normal'); doc.setFontSize(6.5);
    doc.setTextColor(90, 80, 68);
    doc.text('Stoned.io \u2014 The Internet\u2019s Most Premium Rock Adoption Agency. Probably.', pw / 2, 279, { align: 'center' });

    return doc;
}

// ── Button handler ────────────────────────────────────────────────
document.querySelectorAll('.btn-dl-cert').forEach(btn => {
    btn.addEventListener('click', async () => {
        const tier          = parseInt(btn.dataset.tier);
        const rockName      = btn.dataset.rockName;
        const displayName   = btn.dataset.displayName;
        const backstory     = btn.dataset.backstory;
        const rockImg       = btn.dataset.rockImg;
        const canvasCapture = btn.dataset.canvasCapture || '';

        btn.disabled = true;
        btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Generating&hellip;';

        try {
            let doc;
            if      (tier === 1) doc = await pdfT1(displayName, rockImg);
            else if (tier === 2) doc = await pdfT2(displayName, backstory, rockImg);
            else if (tier === 3) doc = await pdfT3(displayName, backstory, rockImg, canvasCapture);
            else                 doc = await pdfT4(displayName, backstory, rockImg);

            const slug = displayName.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
            const prefix = tier === 4 ? 'certificate' : 'rock-doc';
            doc.save(`stoned-io-${prefix}-${slug}.pdf`);
        } catch (err) {
            console.error('PDF error:', err);
            alert('Could not generate the PDF. Please try again.');
        } finally {
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-file-earmark-arrow-down"></i> ' + (tier === 4 ? 'Download Certificate' : 'Download PDF');
        }
    });
});
</script>
<?php endif; ?>

            const { jsPDF } = window.jspdf;
            const doc = new jsPDF({ orientation: 'portrait', unit: 'mm', format: 'a4' });
            const pw = 210, ph = 297;

            // ── Background ──
            doc.setFillColor(20, 18, 16);
            doc.rect(0, 0, pw, ph, 'F');

            // ── Decorative corner marks ──
            const mark = (x, y) => {
                doc.setDrawColor(201, 169, 110); doc.setLineWidth(0.4);
                doc.line(x, y, x + 6, y); doc.line(x, y, x, y + 6);
            };
            mark(10, 10); mark(200, 10); mark(10, 287); mark(200, 287);
            // flip right-side marks
            doc.line(200, 10, 194, 10); doc.line(200, 10, 200, 16);
            doc.line(200, 287, 194, 287); doc.line(200, 287, 200, 281);

            // ── Outer / inner border ──
            doc.setLineWidth(0.7);
            doc.roundedRect(10, 10, 190, 277, 3, 3);
            doc.setLineWidth(0.25);
            doc.roundedRect(13, 13, 184, 271, 2, 2);

            // ── Gold ribbon header ──
            doc.setFillColor(201, 169, 110);
            doc.roundedRect(50, 19, 110, 9, 1.5, 1.5, 'F');
            doc.setTextColor(28, 25, 23);
            doc.setFont('helvetica', 'bold');
            doc.setFontSize(7);
            doc.text('CERTIFICATE OF ROCK ADOPTION', pw / 2, 24.6, { align: 'center' });

            // ── Rock name heading ──
            doc.setFontSize(24);
            doc.setTextColor(232, 223, 200);
            doc.setFont('helvetica', 'bold');
            doc.text(displayName, pw / 2, 40, { align: 'center' });

            // ── Sub-caption ──
            doc.setFontSize(8);
            doc.setFont('helvetica', 'italic');
            doc.setTextColor(122, 111, 96);
            doc.text('Stoned.io Official Adoption Document', pw / 2, 47, { align: 'center' });

            // ── Rock image (centred) ──
            const imgW = 120;
            const imgH = 120;
            doc.addImage(imgData, 'PNG', (pw - imgW) / 2, 54, imgW, imgH);

            // ── Divider ──
            let y = 58 + imgH;
            doc.setDrawColor(58, 49, 40);
            doc.setLineWidth(0.4);
            doc.line(25, y, 185, y);
            y += 8;

            // ── Backstory ──
            if (backstory) {
                doc.setFont('helvetica', 'bold');
                doc.setFontSize(6.5);
                doc.setTextColor(201, 169, 110);
                doc.text('BACKSTORY', 25, y);
                y += 5;
                doc.setFont('helvetica', 'normal');
                doc.setFontSize(8.5);
                doc.setTextColor(168, 154, 138);
                const lines    = doc.splitTextToSize(backstory, 160);
                const maxLines = Math.floor((255 - y) / 4.2);
                doc.text(lines.slice(0, maxLines), 25, y);
                y += Math.min(lines.length, maxLines) * 4.2 + 6;
            }

            // ── Adoption seal text ──
            doc.setFont('helvetica', 'italic');
            doc.setFontSize(7.5);
            doc.setTextColor(90, 80, 68);
            const seal = `This document certifies that "${displayName}" has been officially adopted and is now your rock. ` +
                         `This bond is spiritual, financial, and probably tax-deductible.`;
            doc.text(doc.splitTextToSize(seal, 160), pw / 2, 268, { align: 'center' });

            // ── Footer rule & text ──
            doc.setDrawColor(58, 49, 40);
            doc.setLineWidth(0.3);
            doc.line(25, 274, 185, 274);
            doc.setFont('helvetica', 'normal');
            doc.setFontSize(6.5);
            doc.setTextColor(90, 80, 68);
            doc.text("Stoned.io \u2014 The Internet\u2019s Most Premium Rock Adoption Agency. Probably.", pw / 2, 279, { align: 'center' });

            const slug = displayName.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/, '');
            doc.save(`stoned-io-certificate-${slug}.pdf`);

        } catch (err) {
            console.error('PDF generation error:', err);
            alert('Could not generate the certificate. Please try again.');
        } finally {
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-file-earmark-arrow-down"></i> Download Certificate';
        }
    });
});
</script>
<?php endif; ?>

</body>
</html>
