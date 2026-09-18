---
paths:
  - 'app/Services/Order/**'
---

# Order

## Orders recompute all prices from config/menu.php
OrderController->store uses OrderCalculatorService to recompute subtotal/add_ons/qris_fee/total from config/menu.php. Never trust prices sent from the frontend. Store money as integer Rupiah; Order casts to integer. QRIS fee lives per-item in config/menu.php (default 0).
