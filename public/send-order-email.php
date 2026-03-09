<?php
/**
 * send-order-email.php — Stoned.io
 *
 * POSTed to via fetch() from order-confirmation.php once payment is
 * confirmed.  Reads the order from the session and sends an HTML
 * confirmation email via PHPMailer / SMTP.
 *
 * Expected JSON body:
 *   { "orderRef": "ORD-XXXXXXXX" }
 */

ob_start(); // buffer any stray output so JSON response stays clean

// Catch fatal errors (e.g. missing vendor class) and return JSON instead of blank 500
register_shutdown_function(function () {
    $err = error_get_last();
    if ($err && in_array($err['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR], true)) {
        ob_clean();
        header('Content-Type: application/json');
        echo json_encode(['ok' => false, 'message' => 'Server error: ' . $err['message']]);
    }
});

session_start();
require __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as MailException;

header('Content-Type: application/json');

// ── Helpers ────────────────────────────────────────────────────────
function jsonOut(bool $ok, string $message): void
{
    ob_clean(); // discard any warnings/notices emitted above
    echo json_encode(['ok' => $ok, 'message' => $message]);
    exit;
}

// ── Method guard ───────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonOut(false, 'Method not allowed');
}

// ── Session guard ──────────────────────────────────────────────────
if (empty($_SESSION['last_order'])) {
    jsonOut(false, 'No active order in session');
}

// ── Idempotency — don't send twice ────────────────────────────────
if (!empty($_SESSION['last_order']['email_sent'])) {
    jsonOut(true, 'already_sent');
}

// ── Parse body (just the order ref is needed — no PDF data) ─────────
$raw  = file_get_contents('php://input');
$body = json_decode($raw, true);
if (!is_array($body)) {
    jsonOut(false, 'Invalid JSON body');
}

// ── Pull order from session ────────────────────────────────────────
$order      = $_SESSION['last_order'];
$orderEmail = $order['email']          ?? '';
$orderItems = $order['items']          ?? [];
$orderTotal = $order['total']          ?? 0;
$orderRef   = $order['ref']            ?? 'ORD-UNKNOWN';
$recipName  = $order['recipient_name'] ?? '';
$recipEmail = $order['recipient_email'] ?? '';
$giftMsg    = $order['gift_message']   ?? '';

if (empty($orderEmail) || !filter_var($orderEmail, FILTER_VALIDATE_EMAIL)) {
    jsonOut(false, 'No valid recipient email');
}

// ── Find saved PDFs for this order ────────────────────────────────
$safeRefDir  = preg_replace('/[^a-zA-Z0-9\-_]/', '', $orderRef);
$storageDir  = __DIR__ . '/../storage/pdfs/' . $safeRefDir;
$savedPdfs   = is_dir($storageDir) ? glob($storageDir . '/*.pdf') : [];
if ($savedPdfs === false) { $savedPdfs = []; }

// ── Load environment variables ─────────────────────────────────────
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
try {
    $dotenv->load();
    $dotenv->required(['MAIL_HOST', 'MAIL_USERNAME', 'MAIL_PASSWORD']);
} catch (\Throwable $e) {
    jsonOut(false, 'Mail not configured — add MAIL_* vars to .env');
}

$mailHost     = $_ENV['MAIL_HOST'];
$mailPort     = (int)($_ENV['MAIL_PORT']      ?? 587);
$mailUser     = $_ENV['MAIL_USERNAME'];
$mailPass     = $_ENV['MAIL_PASSWORD'];
$mailFrom     = $_ENV['MAIL_FROM']      ?? $mailUser;
$mailFromName = $_ENV['MAIL_FROM_NAME'] ?? 'Stoned.io';

// ── Build HTML email ───────────────────────────────────────────────
$rowsHtml = '';
foreach ($orderItems as $ci) {
    $label    = htmlspecialchars($ci['label']           ?? '');
    $price    = htmlspecialchars((string)($ci['price']  ?? 0));
    $firstRock = $ci['rocks'][0] ?? null;
    $rname    = $firstRock ? htmlspecialchars($firstRock['name'] ?? '') : '';
    $rockNote = $rname
        ? " <span style='color:#c9a96e;font-size:0.85em;'>({$rname})</span>"
        : '';
    $rowsHtml .= "
                <tr>
                    <td style='padding:10px 14px;border-bottom:1px solid #2d2520;color:#e8dfc8;'>{$label}{$rockNote}</td>
                    <td style='padding:10px 14px;border-bottom:1px solid #2d2520;color:#c9a96e;text-align:right;'>{$price}&euro;</td>
                </tr>";
}

$giftSection = '';
if ($recipName) {
    $rn = htmlspecialchars($recipName);
    $gm = $giftMsg ? ' &mdash; &ldquo;' . htmlspecialchars($giftMsg) . '&rdquo;' : '';
    $giftSection = "
        <p style='margin:14px 0 0;font-size:0.85rem;color:#9e9080;'>
            &#127873; Gift for <strong style='color:#e8dfc8;'>{$rn}</strong>{$gm}
        </p>";
}

$pdfNote = !empty($savedPdfs)
    ? "<p style='margin-top:16px;font-size:0.85rem;color:#9e9080;'>Your personalised rock document(s) are attached to this email.</p>"
    : "<p style='margin-top:16px;font-size:0.85rem;color:#9e9080;'>Your personalised rock documents are ready to download from the order confirmation page.</p>";

$safeEmail = htmlspecialchars($orderEmail);
$safeRef   = htmlspecialchars($orderRef);

$html = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"></head>
<body style="margin:0;padding:20px 0;background:#141210;font-family:'Helvetica Neue',Arial,sans-serif;">
  <div style="max-width:580px;margin:0 auto;background:linear-gradient(160deg,#1e1b17,#2a2420);border:1px solid #3a3128;border-radius:14px;overflow:hidden;">

    <!-- Header -->
    <div style="background:linear-gradient(135deg,#251f16,#332a1a);border-bottom:1px solid #c9a96e;padding:28px 32px;text-align:center;">
      <div style="font-size:2.4rem;">&#129704;</div>
      <h1 style="margin:8px 0 4px;font-size:1.5rem;font-weight:700;color:#e8dfc8;letter-spacing:0.5px;">Order Confirmed!</h1>
      <p style="margin:0;font-size:0.85rem;color:#9e9080;">Thank you for adopting a rock. It is now legally yours (spiritually).</p>
      <div style="display:inline-block;margin-top:12px;background:rgba(201,169,110,0.15);border:1px solid rgba(201,169,110,0.35);border-radius:6px;padding:5px 14px;font-size:0.82rem;font-weight:700;letter-spacing:1.5px;color:#c9a96e;">{$safeRef}</div>
    </div>

    <!-- Body -->
    <div style="padding:28px 32px;">
      <p style="margin:0 0 20px;font-size:0.9rem;color:#9e9080;line-height:1.6;">
        Your order is confirmed and payment is complete. Here&rsquo;s your summary:
      </p>

      <!-- Order table -->
      <table width="100%" cellpadding="0" cellspacing="0"
             style="border-collapse:collapse;background:#17140f;border:1px solid #2d2520;border-radius:8px;overflow:hidden;">
        <thead>
          <tr style="background:#1a1612;">
            <th style="padding:10px 14px;text-align:left;font-size:0.75rem;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:#c9a96e;">Item</th>
            <th style="padding:10px 14px;text-align:right;font-size:0.75rem;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:#c9a96e;">Price</th>
          </tr>
        </thead>
        <tbody>
          {$rowsHtml}
          <tr>
            <td style="padding:12px 14px;font-size:0.85rem;font-weight:700;color:#9e9080;text-transform:uppercase;letter-spacing:1px;">Total</td>
            <td style="padding:12px 14px;text-align:right;font-size:1.1rem;font-weight:700;color:#c9a96e;">{$orderTotal}&euro;</td>
          </tr>
        </tbody>
      </table>

      {$giftSection}
      {$pdfNote}
    </div>

    <!-- Footer -->
    <div style="padding:18px 32px;border-top:1px solid #2d2520;text-align:center;font-size:0.75rem;color:#5a5046;line-height:1.6;">
      Stoned.io &mdash; The Internet&rsquo;s Most Premium Rock Adoption Agency. Probably.<br>
      <span style="color:#3a3128;">This email was sent to {$safeEmail}</span>
    </div>

  </div>
</body>
</html>
HTML;

// ── Send via PHPMailer ─────────────────────────────────────────────
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host       = $mailHost;
    $mail->SMTPAuth   = true;
    $mail->Username   = $mailUser;
    $mail->Password   = $mailPass;
    $mail->SMTPSecure = ($mailPort === 465)
        ? PHPMailer::ENCRYPTION_SMTPS
        : PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = $mailPort;
    $mail->CharSet    = 'UTF-8';

    $mail->setFrom($mailFrom, $mailFromName);
    $mail->addAddress($orderEmail);

    // CC the gift recipient if supplied
    if ($recipName && $recipEmail && filter_var($recipEmail, FILTER_VALIDATE_EMAIL)) {
        $mail->addCC($recipEmail, $recipName);
    }

    $mail->isHTML(true);
    $mail->Subject = "Your Stoned.io Order \xe2\x80\x94 {$orderRef}";
    $mail->Body    = $html;
    $mail->AltBody = "Order confirmed! Ref: {$orderRef} | Total: {$orderTotal}\xe2\x82\xac\n"
                   . (empty($savedPdfs) ? 'Download your documents from the order-confirmation page.' : 'Your rock documents are attached to this email.');

    // ── Attach saved PDFs ─────────────────────────────────────────
    foreach ($savedPdfs as $pdfPath) {
        $mail->addAttachment($pdfPath);
    }

    $mail->send();

    // ── Clean up PDFs from disk — no reason to keep them after sending ──
    foreach ($savedPdfs as $pdfPath) {
        @unlink($pdfPath);
    }
    if (is_dir($storageDir) && count(glob($storageDir . '/*')) === 0) {
        @rmdir($storageDir);
    }

    // Mark as sent in session so we don't resend on refresh
    $_SESSION['last_order']['email_sent'] = true;

    jsonOut(true, 'sent');

} catch (MailException $e) {
    jsonOut(false, 'Mailer error: ' . $mail->ErrorInfo);
}
