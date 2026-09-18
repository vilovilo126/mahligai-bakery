---
paths:
  - config/menu.php
---

# Config

## Menu catalog is config-driven, not DB
The homepage Menu catalog (Roti Unyil, Roti Sisir, Aneka Roti/Regular, Roti Tawar) is driven entirely by config/menu.php (groups > variants/variant_groups, packages, add_ons). The products/categories DB tables exist but are NOT used by the homepage menu (only for legacy seeders). Edit config/menu.php to change names/prices/packages. Price formatting uses 'Rp'.number_format($n,0,',','.'). Card detail payloads are emitted as data-detail='@json($detail)' and parsed by resources/js/modules/product-modal.js.
