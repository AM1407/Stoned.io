
<nav>
    <img src="rock-svgrepo-com.svg" alt="logo" width="60px">
    <h1>Stoned.io</h1>
    <a href="cart.php"><i class="bi bi-basket2 basket-logo"></i></a>
</nav>

<style>
nav {
    display: flex;
    align-items: center;
    justify-content: space-around;
    background: linear-gradient(135deg, #1c1917 0%, #2d2520 50%, #1c1917 100%);
    padding: 14px 32px;
    border-bottom: 2px solid #c9a96e;
    box-shadow: 0 4px 18px rgba(0, 0, 0, 0.55);
    position: sticky;
    top: 0;
    z-index: 100;
}

nav img {
    filter: drop-shadow(0 0 6px rgba(201, 169, 110, 0.5));
    transition: transform 0.3s ease, filter 0.3s ease;
}

nav img:hover {
    transform: rotate(-8deg) scale(1.1);
    filter: drop-shadow(0 0 10px rgba(201, 169, 110, 0.85));
}

nav h1 {
    margin: 0;
    font-size: 30px;
    font-style: italic;
    font-weight: 800;
    letter-spacing: 2px;
    color: #e8dfc8;
    text-shadow: 1px 1px 0 #6b5a3e, 0 0 18px rgba(201, 169, 110, 0.3);
    text-transform: uppercase;
}

.basket-logo {
    color: #c9a96e;
    font-size: 30px;
    border: 2px solid #c9a96e;
    border-radius: 20%;
    padding: 6px 8px;
    transition: background-color 0.25s ease, color 0.25s ease,
                box-shadow 0.25s ease, transform 0.2s ease;
}

.basket-logo:hover {
    background-color: #c9a96e;
    color: #1c1917;
    box-shadow: 0 0 14px rgba(201, 169, 110, 0.6);
    transform: scale(1.12);
}
</style>