---
paths:
  - 'app/Models/**'
---

# Models

## Notifications & chat read-flags semantics
Notifications use Laravel database notifications (uuid, morphs notifiable) for User via AppNotification with data{title,body,url}. Every customer is a User (role customer); there is no App\Models\Customer anymore, so notifications always notifiable_type App\Models\User. Chat: one chats row per customer; ChatMessage sender customer|admin with read_by_customer/read_by_admin. Sending/reading by the admin marks admin-read; polling by the customer marks customer-read. Fetching admin.chat.messages marks unread customer messages as read by admin.
