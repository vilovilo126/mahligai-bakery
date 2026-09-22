const chatEl = document.getElementById('customer-chat');
const chatBody = document.body;

if (chatEl) {
    const chatMessages = chatEl.querySelector('[data-chat-messages]');
    const chatForm = chatEl.querySelector('[data-chat-form]');
    const chatInput = chatEl.querySelector('[data-chat-input]');
    const chatSend = chatEl.querySelector('[data-chat-send]');

    let lastId = 0;
    let pollTimer = null;

    function appendMessage(message, prepend = false) {
        if (!chatMessages) return;
        const mine = message.sender === 'customer';
        const el = document.createElement('div');
        el.className = `flex ${mine ? 'justify-end' : 'justify-start'}`;
        el.innerHTML = `
            <div class="max-w-[80%]">
                <div class="${mine
                    ? 'bg-gradient-to-br from-brand-600 to-brand-800 text-white rounded-2xl rounded-br-md'
                    : 'bg-white text-brand-950 ring-1 ring-brand-950/10 rounded-2xl rounded-bl-md'} px-4 py-2.5 text-sm whitespace-pre-wrap break-words">
                    ${escapeHtml(message.message)}
                </div>
                <p class="mt-1 text-[0.65rem] text-brand-950/40 ${mine ? 'text-right' : 'text-left'}">${message.created_at || ''}</p>
            </div>
        `;
        if (prepend) chatMessages.insertAdjacentElement('afterbegin', el);
        else chatMessages.appendChild(el);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function escapeHtml(str) {
        return String(str || '').replace(/[&<>"']/g, (c) => ({
            '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;',
        }[c]));
    }

    function open() {
        chatEl.classList.remove('hidden');
        chatEl.classList.add('flex');
        chatBody.classList.add('overflow-hidden');
        requestAnimationFrame(() => chatEl.querySelector('[data-chat-card]')?.classList.replace('scale-95', 'scale-100'));
        requestAnimationFrame(() => chatEl.querySelector('[data-chat-card]')?.classList.remove('opacity-0'));
        loadInitial();
        startPolling();
    }

    function close() {
        const card = chatEl.querySelector('[data-chat-card]');
        card?.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            chatEl.classList.add('hidden');
            chatEl.classList.remove('flex');
        }, 200);
        chatBody.classList.remove('overflow-hidden');
        stopPolling();
    }

    async function loadInitial() {
        try {
            const response = await fetch('/customer/chat', { headers: { Accept: 'application/json' } });
            const data = await response.json();
            chatMessages.innerHTML = '';
            lastId = 0;
            (data.messages || []).forEach((m) => {
                appendMessage(m);
                lastId = Math.max(lastId, m.id);
            });
            if ((data.messages || []).length === 0) showEmptyState();
        } catch (e) {
            showEmptyState();
        }
    }

    function showEmptyState() {
        if (!chatMessages || chatMessages.children.length > 0) return;
        chatMessages.innerHTML = `
            <div class="mx-auto max-w-xs pt-10 text-center">
                <span class="mx-auto grid h-12 w-12 place-items-center rounded-full bg-brand-100 text-brand-600">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2Z"/></svg>
                </span>
                <p class="mt-3 text-sm font-semibold text-brand-900">Hai, ada yang bisa kami bantu?</p>
                <p class="mt-1 text-xs text-brand-950/50">Tulis pertanyaan Anda dan admin akan membalasnya.</p>
            </div>
        `;
    }

    async function poll() {
        try {
            const response = await fetch(`/customer/chat/poll?after=${lastId}`, { headers: { Accept: 'application/json' } });
            const data = await response.json();
            (data.messages || []).forEach((m) => {
                appendMessage(m);
                lastId = Math.max(lastId, m.id);
            });
        } catch (e) {
            // abaikan
        }
    }

    function startPolling() {
        stopPolling();
        pollTimer = window.setInterval(poll, 12000);
    }

    function stopPolling() {
        if (pollTimer) {
            window.clearInterval(pollTimer);
            pollTimer = null;
        }
    }

    async function sendMessage(text) {
        if (!text.trim()) return;
        chatSend.disabled = true;
        try {
            const response = await fetch('/customer/chat/send', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    Accept: 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                },
                body: JSON.stringify({ message: text }),
            });
            const data = await response.json();
            if (!response.ok || !data.success) throw new Error('Gagal mengirim pesan.');
            appendMessage(data.message);
            lastId = Math.max(lastId, data.message.id);
            chatInput.value = '';
            chatInput.style.height = 'auto';
        } catch (e) {
            // tampilkan pesan singkat
        } finally {
            chatSend.disabled = false;
        }
    }

    document.querySelectorAll('[data-chat-open]').forEach((btn) => btn.addEventListener('click', open));
    chatEl.querySelectorAll('[data-chat-close]').forEach((btn) => btn.addEventListener('click', close));

    chatEl.addEventListener('click', (event) => {
        if (event.target === chatEl) close();
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && chatEl && !chatEl.classList.contains('hidden')) close();
    });

    chatForm?.addEventListener('submit', (event) => {
        event.preventDefault();
        sendMessage(chatInput.value);
    });

    chatInput?.addEventListener('keydown', (event) => {
        if (event.key === 'Enter' && !event.shiftKey) {
            event.preventDefault();
            sendMessage(chatInput.value);
        }
    });

    chatInput?.addEventListener('input', () => {
        chatInput.style.height = 'auto';
        chatInput.style.height = Math.min(chatInput.scrollHeight, 128) + 'px';
    });

    document.addEventListener('visibilitychange', () => {
        if (document.visibilityState === 'visible' && !chatEl.classList.contains('hidden')) {
            poll();
            startPolling();
        } else if (document.visibilityState === 'hidden') {
            stopPolling();
        }
    });
}