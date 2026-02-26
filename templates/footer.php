<footer>
    <div class="footer-grid">
        <div class="footer-brand">
            <img src="rock-svgrepo-com.svg" alt="Stoned.io logo" width="40px">
            <span>Stoned.io</span>
            <p>The internet's most premium rock adoption agency. Probably.</p>
        </div>

        <div class="footer-links">
            <h4>Quick Links</h4>
            <ul>
                <li><a href="index.php">Shop</a></li>
                <li><a href="cart.php">Basket</a></li>
                <li><a href="#">About Us</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </div>

        <div class="footer-links">
            <h4>Legal</h4>
            <ul>
                <li><a href="#">Privacy Policy</a></li>
                <li><a href="#">Terms of Service</a></li>
                <li><a href="#">Refund Policy</a></li>
                <li><a href="#">Cookie Settings</a></li>
            </ul>
        </div>

        <div class="footer-contact">
            <h4>Get in Touch</h4>
            <a href="contact.php" aria-label="Email"><i class="bi bi-envelope"></i> rocks@stoned.io</a>
            <a href="contact.php" aria-label="Phone"><i class="bi bi-telephone"></i> +1 (800) ROCK-ON</a>
            <div class="socials">
                <a href="reroute.php" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                <a href="reroute.php" aria-label="Twitter"><i class="bi bi-twitter-x"></i></a>
                <a href="reroute.php" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
            </div>
        </div>
    </div>

    <div class="footer-disclaimer">
        <i class="bi bi-info-circle"></i>
        <span>Disclaimer: All rocks displayed on this site are digital images for illustrative purposes only. You will not receive a physical rock — they are gimmick gifts for friends and family. Stoned.io is not responsible for any emotional attachment formed with stock photography.</span>
    </div>

    <div class="footer-bottom">
        <p>&copy; <?php echo date('Y'); ?> Stoned.io &mdash; All rights reserved.</p>
        <p>Proudly selling rocks since 2026.</p>
    </div>
</footer>

<style>
    footer {
        background: linear-gradient(to top, #0e0c0a 0%, #1a1612 100%);
        border-top: 1px solid #2d2520;
        margin-top: 60px;
        padding: 24px 40px 0;
        font-size: 0.85rem;
        color: #9e9080;
    }

    .footer-grid {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 1fr;
        gap: 24px;
        max-width: 1300px;
        margin: 0 auto 20px;
        align-items: start;
    }

    .footer-brand {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .footer-brand img {
        opacity: 0.8;
        width: 32px;
    }

    .footer-brand span {
        font-size: 1rem;
        font-weight: 700;
        color: #e8dfc8;
        letter-spacing: 1px;
        font-style: italic;
    }

    .footer-brand p {
        line-height: 1.5;
        color: #6b6055;
        font-size: 0.8rem;
    }

    .footer-links h4,
    .footer-contact h4 {
        color: #e8dfc8;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        margin-bottom: 8px;
    }

    .footer-links ul {
        list-style: none;
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .footer-links ul a {
        color: #9e9080;
        transition: color 0.2s ease;
        font-size: 0.83rem;
    }

    .footer-links ul a:hover {
        color: #c9a96e;
    }

    .footer-contact p {
        display: flex;
        align-items: center;
        gap: 7px;
        margin-bottom: 5px;
        font-size: 0.83rem;
    }

    .footer-contact > a {
        display: flex;
        align-items: center;
        gap: 7px;
        margin-bottom: 5px;
        font-size: 0.83rem;
        color: #9e9080;
        transition: color 0.2s ease;
    }

    .footer-contact > a:hover {
        color: #c9a96e;
    }

    .footer-contact i {
        color: #c9a96e;
    }

    .socials {
        display: flex;
        gap: 10px;
        margin-top: 8px;
    }

    .socials a {
        color: #6b6055;
        font-size: 1.1rem;
        transition: color 0.2s ease, transform 0.2s ease;
    }

    .socials a:hover {
        color: #c9a96e;
        transform: translateY(-2px);
    }

    .footer-disclaimer {
        max-width: 1300px;
        margin: 0 auto 16px;
        display: flex;
        align-items: flex-start;
        gap: 8px;
        background-color: #1a1612;
        border: 1px solid #2d2520;
        border-radius: 8px;
        padding: 9px 14px;
        font-size: 0.75rem;
        color: #5a5046;
        line-height: 1.4;
    }

    .footer-disclaimer i {
        color: #4a4035;
        margin-top: 1px;
        flex-shrink: 0;
    }

    .footer-bottom {
        max-width: 1300px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-top: 1px solid #2d2520;
        font-size: 0.78rem;
        color: #4a4035;
    }

    @media (max-width: 900px) {
        .footer-grid {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media (max-width: 520px) {
        .footer-grid {
            grid-template-columns: 1fr;
        }

        .footer-bottom {
            flex-direction: column;
            gap: 6px;
            text-align: center;
        }
    }
</style>
