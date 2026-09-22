const sidebar = document.querySelector('[data-admin-sidebar]');
const overlay = document.querySelector('[data-admin-overlay]');

function closeSidebar() {
    sidebar?.classList.remove('is-open');
    overlay?.classList.add('hidden');
}

document.querySelectorAll('[data-admin-sidebar-toggle]').forEach((btn) => {
    btn.addEventListener('click', () => {
        sidebar?.classList.add('is-open');
        overlay?.classList.remove('hidden');
    });
});

document.querySelectorAll('[data-admin-sidebar-close]').forEach((btn) => btn.addEventListener('click', closeSidebar));
overlay?.addEventListener('click', closeSidebar);

// ---------- Notifikasi bell ----------
const notifToggle = document.querySelector('[data-admin-notif-toggle]');
const notifDropdown = document.querySelector('[data-admin-notif-dropdown]');
const notifList = document.querySelector('[data-admin-notif-list]');
const notifBadge = document.querySelector('[data-admin-notif-badge]');
const sidebarNotifBadge = document.querySelector('[data-admin-unread-notif]');

function renderNotifCount(count) {
    const n = Number(count || 0);
    notifBadge?.classList.toggle('hidden', n === 0);
    if (notifBadge) notifBadge.textContent = n > 99 ? '99+' : String(n);
    if (sidebarNotifBadge) {
        sidebarNotifBadge.classList.toggle('hidden', n === 0);
        sidebarNotifBadge.textContent = String(n);
    }
}

if (notifToggle && notifDropdown) {
    let timer = null;

    notifToggle.addEventListener('click', (event) => {
        event.stopPropagation();
        const isOpen = !notifDropdown.classList.contains('hidden');
        notifDropdown.classList.toggle('hidden', isOpen);
        if (!isOpen) fetchNotifications(true);
    });

    const close = (event) => {
        if (!notifDropdown.classList.contains('hidden')
            && !notifToggle.contains(event.target)
            && !notifDropdown.contains(event.target)) {
            notifDropdown.classList.add('hidden');
        }
    };
    document.addEventListener('click', close);

    async function fetchNotifications(markRead = false) {
        try {
            const response = await fetch('/admin/notifications/list', { headers: { Accept: 'application/json' } });
            const data = await response.json();
            renderNotifCount(data.unread_count);
            if (notifList) {
                if (!Array.isArray(data.notifications) || data.notifications.length === 0) {
                    notifList.innerHTML = '<p class="px-4 py-8 text-center text-sm text-brand-950/45">Belum ada notifikasi.</p>';
                } else {
                    notifList.innerHTML = data.notifications.map((n) => `
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
            }
            if (markRead && data.unread_count > 0) {
                await fetch('/admin/notifications/read', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                        Accept: 'application/json',
                    },
                });
                renderNotifCount(0);
            }
        } catch (e) {
            // abaikan
        }
    }

    function startPolling() {
        fetchNotifications(false);
        timer = window.setInterval(() => fetchNotifications(false), 20000);
    }

    document.addEventListener('visibilitychange', () => {
        if (document.visibilityState === 'visible') {
            fetchNotifications(false);
            fetchChatUnread();
            if (!timer) startPolling();
        } else if (timer) {
            window.clearInterval(timer);
            timer = null;
        }
    });

    startPolling();
}

// ---------- Badge chat ----------
const sidebarChatBadge = document.querySelector('[data-admin-unread-chat]');
const topbarChatDot = document.querySelector('[data-admin-chat-topbadge]');

async function fetchChatUnread() {
    try {
        const response = await fetch('/admin/chat/overview', { headers: { Accept: 'application/json' } });
        const data = await response.json();
        const n = Number(data.total_unread || 0);
        if (sidebarChatBadge) {
            sidebarChatBadge.classList.toggle('hidden', n === 0);
            sidebarChatBadge.textContent = String(n);
        }
        if (topbarChatDot) topbarChatDot.classList.toggle('hidden', n === 0);
    } catch (e) {
        // abaikan
    }
}

fetchChatUnread();
window.setInterval(fetchChatUnread, 20000);