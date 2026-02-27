<div class="cart-items-preview">
    <?php if (empty($_SESSION['cart'])): ?>
        <p>Your basket is as empty as an empty basket.</p>
    <?php else: ?>
        <ul class="dropdown-list">
            <?php 
            $total = 0;
            foreach ($_SESSION['cart'] as $item): 
                $price = 0;
                $name = "";
                switch($item['tier']) {
                    case 1: $price = 1; $name = "Pebble Package"; break;
                    case 2: $price = 10; $name = "Boulder Package"; break;
                    case 3: $price = 20; $name = "ROCKstar Package"; break;
                    case 4: $price = 50; $name = "Pristine Package"; break;
                }
                $total += $price;
            ?>
                <li>1x <?php echo $name; ?> - €<?php echo $price; ?></li>
            <?php endforeach; ?>
        </ul>
        <hr>
        <div class="cart-footer">
            <p>Total: €<?php echo $total; ?></p>
            <a href="cart.php" class="btn-go-to-cart">Go to cart</a>
        </div>
    <?php endif; ?>
</div>