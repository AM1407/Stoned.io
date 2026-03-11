```
             _____
          .-'        '-.
        .'    _.--._    '.
       /    .'      '.    \
      ;    /   O    O \    ;
      |   |     __     |   |
      ;    \   '=='   /    ;
       \    '._    _.'    /
        '.     '--'     .'
          '-._______.-'
           |||     |||  ---> Dave the Rock
```

# 🪨 Stoned.io

**The internet's most premium rock image store.**

> "We sell pictures of rocks. For real money. And people buy them. We don't understand it either."

---

## 📸 What is this?

Stoned.io is a joke e-commerce website that sells **digital images of rocks** as gimmick gifts. Not actual rocks. Not NFTs. Just good old-fashioned JPEGs of geological specimens, delivered with love, a backstory, and absolutely zero nutritional value.

It's the perfect gift for someone who has everything — because now they can also have a picture of a rock.

## 🏗️ Tech Stack

| Layer       | Technology                         |
|-------------|------------------------------------|
| Backend     | PHP 8+ with Composer (PSR-4)       |
| Frontend    | Vanilla HTML/CSS, Bootstrap Icons  |
| Font        | DM Sans (Google Fonts)             |
| Payments    | Stripe Checkout                    |
| Webhook     | Stripe Webhook Handler            |
| Tips/Support| Ko-fi *(coming soon)*              |

## 📁 Project Structure

```
wackywebshop/
├── public/             # Web root — all publicly accessible pages
│   ├── index.php       # Homepage with product tiers
│   ├── about.php       # The legendary origin story
│   ├── contact.php     # Get in touch (or don't)
│   ├── reroute.php     # Social media redirect (surprise!)
│   ├── checkout.php    # Stripe Checkout integration
│   ├── webhook.php     # Stripe Webhook handler
│   ├── style.css       # Global styles
│   └── ...             # Legal pages, assets
├── src/                # PHP classes (PSR-4 autoloaded)
├── templates/          # Reusable page components
│   ├── navbar.php      # Sticky obsidian navbar
│   ├── products.php    # Tier cards (the money makers)
│   └── footer.php      # Footer with disclaimer
├── vendor/             # Composer dependencies
└── composer.json
```

## 🛒 Product Tiers

| Tier | Name                   | Price | What You Get                                      |
|------|------------------------|-------|---------------------------------------------------|
| 1    | Pebble Package         | 1€    | A rock image with a name                           |
| 2    | Boulder Package        | 10€   | A rock image with a name and a backstory           |
| 3    | ROCKstar Package ⭐    | 20€   | Everything from tier 1 & 2 but customisable        |
| 4    | Pristine Stone Package | 50€   | 5 high quality rock images with adoption certs     |

## 🚧 Roadmap

- [x] Core site structure & styling
- [x] Product tier cards
- [x] About page with origin story
- [x] Contact page
- [x] Footer with legally questionable disclaimer
- [x] Stripe integration for payments ✅
- [x] Shopping basket functionality ✅
- [x] Order confirmation emails (with rock PDFs) ✅
- [x] Rock customisation for tier 3+ ✅
- [x] Stripe webhook integration ✅
- [ ] Ko-fi integration for tips & support

## � Future Possibilities

### Rock Trading Card Game (TCG)

Since every rock already gets a unique character with a name, backstory, and personality, a natural next step would be turning them into **collectible trading cards**. Each rock could receive:

- **Stats** — Attack, Defence, Weight, Shininess, Charisma
- **Abilities** — Unique powers based on their assigned character (e.g. *Sylvester Stallstone* gets "Rocky Punch", *Dwayne 'The Rock' Johnson* gets "People's Elbow")
- **Rarity tiers** — Common pebbles, rare boulders, legendary monoliths
- **Card art** — Styled portraits of each rock character

Players could collect, compare, and (eventually) battle their rocks against friends' collections. Think Pokémon cards, but significantly more geological.

This would add a whole new layer to the gifting experience — you're not just buying someone a picture of a rock, you're giving them a **battle-ready companion**.

## �🚀 Getting Started

```bash
# Clone the repo
git clone https://github.com/AM1407/Stoned.io.git
cd Stoned.io

# Install dependencies
composer install

# Serve locally (from the public directory)
php -S localhost:8000 -t public
```

Then open `http://localhost:8000` and prepare to question your life choices.

## 💛 Support the Project

This project is built with love, sarcasm, and an unreasonable amount of time spent choosing the right shade of sandstone gold.

- **Ko-fi** — Coming soon. Buy us a coffee (we'll spend it on more rock photos).
- **Stripe** — Coming soon. For when you actually want to buy a picture of a rock.

## ⚖️ Disclaimer

All rocks displayed on this site are digital images for illustrative purposes only. You will not receive a physical rock — they are gimmick gifts for friends and family. Stoned.io is not responsible for any emotional attachment formed with stock photography.

## 📄 License

This project is unlicensed chaos. Use it however you want. We're selling rock pictures — we're not exactly guarding trade secrets here.

---

*Made with 🪨 by [AM1407](https://github.com/AM1407)*
