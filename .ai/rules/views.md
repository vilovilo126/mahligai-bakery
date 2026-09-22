---
paths:
  - 'resources/views/**'
---

# Views

## Struk & customer pages render strictly from DB (server or JSON endpoint)
Receipt/struk data (order-receipt component, product modal step 3, Pesanan Saya, order-show) is rendered from the server response (POST /orders or customer.orders.json), never reconstructed client-side from cart state. Customer pages must extend layouts.landing; admin pages extend layouts.admin (which loads its own resources/js/admin.js bundle). Bank admin credentials never appear in frontend.

JS CSP/attrs: customer login modal posts to /customer/login (guest) - keep -; notifications list endpoints return unread_count; mark-read endpoints accept CSRF via meta tag.

## Landing vs customer page separation
`/` renders home.landing (company profile: hero, marquee, about, cerita, keunggulan, gallery, location, testimonials, contact — NO catalog/prices/cart). `/menu` renders home.index and is the authenticated customer shopping page (menu-hero + products + location + contact only); guests hitting /menu are redirected to `/`. Navbar branches per role (guest links have no cart icon); footer Menu links use landing anchors. Do not add catalog/cart content to landing.
