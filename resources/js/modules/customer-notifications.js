const notifToggle = document.querySelector('[data-notif-toggle]');
const notifDropdown = document.querySelector('[data-notif-dropdown]');
const notifUnread = document.querySelector('[data-notif-unread]');
const notifList = document.querySelector('[data-notif-list]');
const notifEmpty = document.querySelector('[data-notif-empty]');

if (notifToggle && notifDropdown) {
    let pollTimer = null;

    notifToggle.addEventListener('click', (event) => {
        event.stopPropagation();
        const isOpen = !notifDropdown.classList.contains('hidden');
        notifDropdown.classList.toggle('hidden', isOpen);
        if (!isOpen) fetchNotifications();
    });

    const close = (event) => {
        if (!notifDropdown.classList.contains('hidden')
            && !notifToggle.contains(event.target)
            && !notifDropdown.contains(event.target)) {
            notifDropdown.classList.add('hidden');
        }
    };
    document.addEventListener('click', close);
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') notifDropdown.classList.add('hidden');
    });

    function renderCount(count) {
        if (!notifUnread) return;
        const n = Number(count || 0);
        notifUnread.classList.toggle('hidden', n === 0);
        notifUnread.textContent = n > 99 ? '99+' : String(n);
    }

    function renderList(notifications) {
        if (!notifList) return;
        if (!Array.isArray(notifications) || notifications.length === 0) {
            notifList.innerHTML = notifEmpty && notifEmpty.outerHTML
                ? notifEmpty.outerHTML
                : '<p class="px-4 py-8 text-center text-sm text-brand-950/45">Belum ada notifikasi.</p>';
            return;
        }

        notifList.innerHTML = notifications.map((n) => `
            <div class="${n.read ? '' : 'bg-brand-50/70'} flex gap-3 border-b border-brand-950/5 px-4 py-3 last:border-b-0">
                ${n.read ? '' : '<span class="mt-1.5 h-2 w-2 shrink-0 rounded-full bg-brand-600"></span>'}
                <div class="min-w-0">
                    ${n.url
                        ? `<a href="${n.url}" class="block text-sm font-semibold text-brand-900 hover:underline">${n.title}</a>`
                        : `<p class="text-sm font-semibold text-brand-900">${n.title}</p>`}
                    <p class="mt-0.5 line-clamp-2 text-xs text-brand-950/55">${n.body}</p>
                    <p class="mt-1 text-[0.7rem] text-brand-950/40">${n.created_at || ''}</p>
                </div>
            </div>
        `).join('');
    }

    async function fetchNotifications() {
        try {
            const response = await fetch('/customer/notifications/list', {
                headers: { Accept: 'application/json' },
            });
            const data = await response.json();
            renderCount(data.unread_count);
            renderList(data.notifications);

            if (data.unread_count > 0 && !notifDropdown.classList.contains('hidden')) {
                fetch('/customer/notifications/read', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                        Accept: 'application/json',
                    },
                }).then((res) => res.json()).then((readData) => renderCount(readData.unread_count)).catch(() => {});
            }
        } catch (e) {
            // abaikan kegagalan polling
        }
    }

    function startPolling() {
        fetchNotifications();
        pollTimer = window.setInterval(fetchNotifications, 30000);
    }

    document.addEventListener('visibilitychange', () => {
        if (document.visibilityState === 'visible') {
            fetchNotifications();
            if (!pollTimer) startPolling();
        } else if (pollTimer) {
            window.clearInterval(pollTimer);
            pollTimer = null;
        }
    });

    startPolling();
}