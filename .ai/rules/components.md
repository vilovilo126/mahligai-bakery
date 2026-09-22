---
paths:
  - resources/views/components/product-detail-modal.blade.php
---

# Components

## Checkout modal needs definite height for body scroll
`#product-modal [data-modal-card]` is a flex column with only max-h; without a definite `height` the flex container height is indefinite and the inner `flex-1 min-h-0 overflow-y-auto` body never becomes a real scroll area (content is clipped, can't reach Metode Pembayaran / Konfirmasi). Keep card `height:100dvh` (mobile) and `height:min(90dvh,calc(100dvh - 2rem))` (sm+), header/footer `shrink-0`, and a single scroll body with `overflow-x:hidden; overscroll-behavior:contain`. Checkout logic must stay disabled-safe: changes never shrink fonts/fields or remove payment options.

## Every modal step needs the `flex` class for its scroll body
Each `[data-modal-step]` must carry the `flex` class (e.g. `hidden min-h-0 flex flex-1 flex-col`) — `flex-col` alone does NOT set `display:flex`. The checkout step was missing `flex`, so when `showStep()` removed `hidden` it computed `display:block`, leaving the scroll body (`min-h-0 flex-1 overflow-y-auto`) inert (height=content, scrollHeight==clientHeight) and the card's `overflow:hidden` clipped payment options/Konfirmasi with no way to scroll. No wheel/touch JS handlers exist; this is purely markup. Card still needs a definite height (custom.css `#product-modal [data-modal-card]`) so `flex-1` + `min-height:0` produce one real scroll body.
