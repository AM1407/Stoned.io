<hero>
    <h2>Rocks are already a bad gift but do you want something slightly worse? <br> Then you are in the right place!</h2>
</hero>

<main>
    <div class="tiers">
        <div class="tier">
            <div class="tier-header">
                <span class="tier-badge">Tier 1</span>
                <h3>Pebble Package</h3>
            </div>
            <p>A pet rock with a name.</p>
            <div class="tier-footer">
                <span class="price">1€</span>
                <button class="add-to-basket"><i class="bi bi-basket2"></i> Add to Basket</button>
            </div>
        </div>
        <div class="tier">
            <div class="tier-header">
                <span class="tier-badge">Tier 2</span>
                <h3>Boulder Package</h3>
            </div>
            <p>A pet rock with a name and a backstory.</p>
            <div class="tier-footer">
                <span class="price">10€</span>
                <button class="add-to-basket"><i class="bi bi-basket2"></i> Add to Basket</button>
            </div>
        </div>
        <div class="tier featured">
            <span class="popular-tag"><i class="bi bi-star-fill"></i> Most Popular</span>
            <div class="tier-header" style="margin-top: 8px;">
                <span class="tier-badge">Tier 3</span>
                <h3>ROCKstar Package</h3>
            </div>
            <p>Everything from tier 1 and tier 2 but customisable.</p>
            <div class="tier-footer">
                <span class="price">20€</span>
                <button class="add-to-basket"><i class="bi bi-basket2"></i> Add to Basket</button>
            </div>
        </div>
        <div class="tier">
            <div class="tier-header">
                <span class="tier-badge">Tier 4</span>
                <h3>Pristine Stone Package</h3>
            </div>
            <p>5 high quality rocks with customization options and official adoption certificates.</p>
            <div class="tier-footer">
                <span class="price">50€</span>
                <button class="add-to-basket"><i class="bi bi-basket2"></i> Add to Basket</button>
            </div>
        </div>
    </div>
</main>

<style>
    hero {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 60px 32px;
        text-align: center;
        font-size: 1.1rem;
        line-height: 1.6;
        color: #b5a98a;
        border-bottom: 1px solid #2d2520;
    }

    .tiers {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 24px;
        padding: 48px 40px;
        max-width: 1300px;
        margin: 0 auto;
    }

    .tier {
        background: linear-gradient(160deg, #1e1b17 0%, #2a2420 100%);
        border: 1px solid #3a3128;
        border-radius: 12px;
        padding: 28px 24px;
        display: flex;
        flex-direction: column;
        gap: 14px;
        transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
    }

    .tier:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.5);
        border-color: #c9a96e;
    }

    .tier.featured {
        border-color: #c9a96e;
        background: linear-gradient(160deg, #251f16 0%, #332a1a 100%);
        box-shadow: 0 0 24px rgba(201, 169, 110, 0.15);
        position: relative;
    }

    .popular-tag {
        position: absolute;
        top: 14px;
        right: 14px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background-color: #c9a96e;
        color: #1c1917;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        padding: 4px 10px;
        border-radius: 20px;
    }

    .tier-header {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .tier-badge {
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: #c9a96e;
    }

    .tier h3 {
        font-size: 1.15rem;
        font-weight: 700;
        color: #e8dfc8;
        margin: 0;
    }

    .tier p {
        font-size: 0.92rem;
        color: #9e9080;
        line-height: 1.55;
        flex: 1;
    }

    .tier-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: auto;
        padding-top: 16px;
        border-top: 1px solid #2d2520;
        gap: 12px;
    }

    .price {
        font-size: 1.4rem;
        font-weight: 700;
        color: #c9a96e;
    }

    .add-to-basket {
        display: flex;
        align-items: center;
        gap: 6px;
        background-color: transparent;
        color: #c9a96e;
        border: 1.5px solid #c9a96e;
        border-radius: 8px;
        padding: 7px 13px;
        font-family: inherit;
        font-size: 0.82rem;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.2s ease, color 0.2s ease, box-shadow 0.2s ease;
        white-space: nowrap;
    }

    .add-to-basket:hover {
        background-color: #c9a96e;
        color: #1c1917;
        box-shadow: 0 0 12px rgba(201, 169, 110, 0.4);
    }

    @media (max-width: 900px) {
        .tiers {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 520px) {
        .tiers {
            grid-template-columns: 1fr;
        }
    }
</style>