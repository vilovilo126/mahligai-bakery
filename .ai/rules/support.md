---
paths:
  - 'app/Support/**'
---

# Support

## OrderHelper = single source for WhatsApp links & order messages
All wa.me links use config('business.whatsapp_number') (628113996988). customerOrderMessage() builds the order-summary text from the stored order snapshot (queue number, order number MB-####, items, subtotal, payment label, qris fee, total, pickup label, bakery request) - never from request data.
