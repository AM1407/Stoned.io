<div class="cart-items-preview">
    <?php if (empty($_SESSION['cart'])): ?>
        <p>Je mandje is zo leeg als een kiezelsteen.</p>
    <?php else: ?>
        <ul class="dropdown-list">
            <li>1x Sylvester Stallstone - 1€</li>
        </ul>
        <hr>
        <div class="cart-footer">
            <p>Totaal: €1</p>
            <a href="cart.php" class="btn-go-to-cart">Go to cart</a>
        </div>
    <?php endif; ?>
</div>

