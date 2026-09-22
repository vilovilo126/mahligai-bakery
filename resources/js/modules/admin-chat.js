const page = document.querySelector('[data-admin-chat-page]');

if (page) {
    const chatList = page.querySelector('[data-chat-list]');
    const chatHeaderTitle = page.querySelector('[data-chat-title]');
    const chatHeaderSubtitle = page.querySelector('[data-chat-subtitle]');
    const chatAvatar = page.querySelector('[data-chat-avatar]');
    const chatMessages = page.querySelector('[data-chat-messages]');
    const chatForm = page.querySelector('[data-chat-form]');
    const chatInput = page.querySelector('[data-chat-input]');
    const chatSend = page.querySelector('[data-chat-send]');

    let activeChatId = null;
    let activeName = 'Pelanggan';
    let lastMessageId = 0;
    let messagesTimer = null;

    function escapeHtml(str) {
        return String(str || '').replace(/[&<>"']/g, (c) => ({
            '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;',
        }[c]));
    }

    function appendMessage(message) {
        if (!chatMessages) return;
        const mine = message.sender === 'admin';
        const el = document.createElement('div');
        el.className = `flex ${mine ? 'justify-end' : 'justify-start'}`;
        el.innerHTML = `
            <div class="max-w-[78%]">
                <div class="${mine
                    ? 'bg-gradient-to-br from-brand-600 to-brand-800 text-white rounded-2xl rounded-br-md'
                    : 'bg-white text-brand-950 ring-1 ring-brand-950/10 rounded-2xl rounded-bl-md'} px-4 py-2.5 text-sm whitespace-pre-wrap break-words">
                    ${escapeHtml(message.message)}
                </div>
                <p class="mt-1 text-[0.65rem] text-brand-950/40 ${mine ? 'text-right' : 'text-left'}">${message.created_at || ''}</p>
            </div>
        `;
        chatMessages.appendChild(el);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    async function loadChat(chatId, name) {
        activeChatId = chatId;
        activeName = name;
        lastMessageId = 0;
        chatHeaderTitle.textContent = name;
        chatHeaderSubtitle.textContent = 'Memuat pesan…';
        chatAvatar.textContent = (name || 'K').charAt(0).toUpperCase();
        chatMessages.innerHTML = '';
        chatForm?.classList.remove('hidden');
        chatInput.focus();

        try {
            const response = await fetch(`/admin/chat/${chatId}/messages`, { headers: { Accept: 'application/json' } });
            const data = await response.json();
            (data.messages || []).forEach((m) => {
                appendMessage(m);
                lastMessageId = Math.max(lastMessageId, m.id);
            });
            chatHeaderSubtitle.textContent = (data.messages || []).length > 0 ? '' : 'Belum ada pesan';
            clearUnread(chatId);
        } catch (e) {
            chatHeaderSubtitle.textContent = 'Gagal memuat pesan';
        }

        startMessagesPolling();
    }

    async function pollMessages() {
        if (!activeChatId) return;
        try {
            const response = await fetch(`/admin/chat/${activeChatId}/messages`, { headers: { Accept: 'application/json' } });
            const data = await response.json();
            let added = false;
            (data.messages || []).forEach((m) => {
                if (m.id > lastMessageId) {
                    appendMessage(m);
                    lastMessageId = m.id;
                    added = true;
                }
            });
            if (added) clearUnread(activeChatId);
        } catch (e) {
            // abaikan
        }
    }

    function startMessagesPolling() {
        if (messagesTimer) window.clearInterval(messagesTimer);
        messagesTimer = window.setInterval(pollMessages, 8000);
    }

    function clearUnread(chatId) {
        page.querySelectorAll(`[data-chat-item][data-chat-id="${chatId}"] [data-chat-unread]`).forEach((el) => el.remove());
    }

    // Pilih percakapan dari query ?chat=...
    chatList?.querySelectorAll('[data-chat-item]').forEach((item) => {
        item.addEventListener('click', () => {
            const id = item.dataset.chatId;
            if (id === String(activeChatId)) return;
            page.querySelectorAll('[data-chat-item]').forEach((el) => {
                el.classList.remove('bg-brand-50');
                el.classList.add('hover:bg-brand-50');
            });
            item.classList.add('bg-brand-50');
            item.classList.remove('hover:bg-brand-50');
            loadChat(id, item.dataset.customerName || 'Pelanggan');
        });
    });

    chatForm?.addEventListener('submit', async (event) => {
        event.preventDefault();
        if (!activeChatId) return;
        const text = chatInput.value.trim();
        if (!text) return;
        chatSend.disabled = true;
        try {
            const response = await fetch(`/admin/chat/${activeChatId}/send`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    Accept: 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                },
                body: JSON.stringify({ message: text }),
            });
            const data = await response.json();
            if (!response.ok || !data.success) throw new Error('Gagal mengirim.');
            appendMessage(data.message);
            lastMessageId = Math.max(lastMessageId, data.message.id);
            chatInput.value = '';
            chatInput.style.height = 'auto';
        } catch (e) {
            // abaikan
        } finally {
            chatSend.disabled = false;
        }
    });

    chatInput?.addEventListener('keydown', (event) => {
        if (event.key === 'Enter' && !event.shiftKey) {
            event.preventDefault();
            chatForm.requestSubmit();
        }
    });

    chatInput?.addEventListener('input', () => {
        chatInput.style.height = 'auto';
        chatInput.style.height = Math.min(chatInput.scrollHeight, 128) + 'px';
    });

    // Buka auto dari query param
    const params = new URLSearchParams(window.location.search);
    const autoChatId = params.get('chat');
    if (autoChatId) {
        const item = page.querySelector(`[data-chat-item][data-chat-id="${autoChatId}"]`);
        item?.click();
    } else {
        const first = chatList?.querySelector('[data-chat-item]');
        if (first) first.click();
    }
}