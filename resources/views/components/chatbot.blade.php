{{-- Floating WhatsApp button (posisi kanan bawah) --}}
<a id="wa-floating" href="https://wa.me/{{ config('business.whatsapp_number') }}?text={{ rawurlencode(config('business.wa_order_message')) }}"
    target="_blank" rel="noopener"
    class="wa-float group fixed bottom-5 right-5 z-50 sm:bottom-6 sm:right-6" aria-label="Chat WhatsApp Mahligai Bakery">
    <span class="anim-pulse-ring absolute inset-0 rounded-full bg-emerald-500/40"></span>
    <span class="relative grid h-14 w-14 place-items-center rounded-full bg-gradient-to-br from-emerald-400 to-emerald-600 text-white shadow-xl shadow-emerald-600/30 transition-transform duration-300 group-hover:scale-110">
        <svg viewBox="0 0 24 24" fill="currentColor" class="h-7 w-7">
            <path d="M12 2a9.9 9.9 0 0 0-8.5 14.9L2 22l5.3-1.4A10 10 0 1 0 12 2Zm5.1 14.1c-.2.6-1.2 1.2-1.7 1.2-.5.1-1 .2-3.3-.7-2.8-1.1-4.6-4-4.7-4.2-.1-.2-1.1-1.5-1.1-2.9s.7-2 1-2.3c.2-.3.5-.3.7-.3h.5c.2 0 .4 0 .6.5l.9 2.2c.1.2.1.4 0 .6l-.4.6-.5.5c-.2.2-.3.4-.1.7.2.3.8 1.4 1.8 2.3 1.3 1.2 2.3 1.5 2.7 1.7.3.2.5.1.7-.1l1-1.2c.2-.3.4-.2.7-.1l2.2 1c.3.2.5.3.6.4.1.2.1.6-.1 1Z"/>
        </svg>
    </span>
    <span class="pointer-events-none absolute right-[3.75rem] top-1/2 -translate-y-1/2 whitespace-nowrap rounded-full bg-brand-950/90 px-3 py-1.5 text-xs font-semibold text-white opacity-0 shadow-lg transition-opacity duration-200 group-hover:opacity-100">
        Chat WhatsApp
    </span>
</a>
