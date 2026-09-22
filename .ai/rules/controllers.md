---
paths:
  - 'app/Http/Controllers/**'
---

# Controllers

## Customer controllers use auth()->user() via middleware aliases, not guard('customer')
Middleware is ['auth'] plus web group; role checks are via EnsureCustomer (alias 'customer') and EnsureAdmin (alias 'admin') middleware on route groups, NOT per-controller guard('customer') calls. Customer-scoped controllers read auth()->user() (calls typed as App\Models\User) and scope via User relationships/scopeForCustomer — never Auth::guard('customer'). POST /orders requires the 'customer' middleware; order_status defaults to 'pesanan_dibuat' + payment_status 'belum_bayar', global queue_number via OrderHelper::nextQueueNumber() inside a DB::transaction. Admin verifies payment manually.
