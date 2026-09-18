// Modul chat AI Gemini.
//
// Backend Gemini (AiChatController, GeminiService, config/ai.php) tetap
// dipertahankan. Floating button diganti menjadi WhatsApp sehingga panel
// chat tidak lagi ditampilkan di UI. Modul ini dijaga agar tidak error
// jika elemen chat tidak ada di halaman.
const launcher = document.getElementById('chat-launcher');
const panel = document.getElementById('chat-panel');

if (launcher && panel) {
    const closeButton = document.getElementById('chat-close');
    const form = document.getElementById('chat-form');
    const input = document.getElementById('chat-input');
    const messages = document.getElementById('chat-messages');
    const suggestions = document.querySelectorAll('[data-chat-suggestion]');
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

    let busy = false;

    function scrollToBottom() {
        if (messages) messages.scrollTop = messages.scrollHeight;
    }

    function addMessage(text, role) {
        if (!messages) return;
        const wrapper = document.createElement('div');
        wrapper.className = `chat-msg ${role === 'user' ? 'justify-end' : 'justify-start'}`;
        const bubble = document.createElement('div');
        bubble.className =
            role === 'user'
                ? 'max-w-[85%] rounded-2xl rounded-tr-sm bg-brand-600 px-4 py-2.5 text-sm text-white shadow-sm'
                : 'max-w-[85%] rounded-2xl rounded-tl-sm bg-cream-100 px-4 py-2.5 text-sm text-brand-950';
        bubble.textContent = text;
        wrapper.appendChild(bubble);
        messages.appendChild(wrapper);
        scrollToBottom();
    }

    function setTyping(active) {
        let indicator = messages?.querySelector('[data-typing]');
        if (active && !indicator) {
            indicator = document.createElement('div');
            indicator.dataset.typing = '';
            indicator.className = 'chat-msg justify-start';
            const bubble = document.createElement('div');
            bubble.className = 'flex items-center gap-1.5 rounded-2xl rounded-tl-sm bg-cream-100 px-4 py-3.5';
            for (let i = 0; i < 3; i += 1) {
                const dot = document.createElement('span');
                dot.className = 'typing-dot';
                bubble.appendChild(dot);
            }
            indicator.appendChild(bubble);
            messages.appendChild(indicator);
            scrollToBottom();
        }
        if (!active && indicator) indicator.remove();
    }

    function togglePanel(force) {
        const open = typeof force === 'boolean' ? force : panel.classList.toggle('hidden');
        if (typeof force === 'boolean') panel.classList.toggle('hidden', !open);
        launcher?.classList.toggle('hidden', open);
        document.body.classList.toggle('overflow-hidden', open);
        if (open) {
            input?.focus();
            scrollToBottom();
        }
    }

    launcher?.addEventListener('click', () => togglePanel());
    closeButton?.addEventListener('click', () => togglePanel(false));

    suggestions.forEach((button) => {
        button.addEventListener('click', () => {
            const suggestion = button.textContent.trim();
            togglePanel(false);
            input.value = suggestion;
            form?.dispatchEvent(new Event('submit', { cancelable: true }));
        });
    });

    form?.addEventListener('submit', (event) => {
        event.preventDefault();
        const text = input.value.trim();
        if (!text || busy) return;

        input.value = '';
        addMessage(text, 'user');
        setTyping(true);
        busy = true;

        fetch('/ai/chat', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                Accept: 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify({ message: text }),
        })
            .then(async (response) => {
                const data = await response.json().catch(() => ({}));
                return { ok: response.ok, data };
            })
            .then(({ ok, data }) => {
                setTyping(false);
                addMessage(data.reply || (ok ? '' : 'Maaf, saya sedang bermasalah. Silakan coba lagi nanti.'), 'bot');
            })
            .catch(() => {
                setTyping(false);
                addMessage('Maaf, koneksi ke server bermasalah. Silakan coba lagi.', 'bot');
            })
            .finally(() => {
                busy = false;
                input?.focus();
            });
    });
}
