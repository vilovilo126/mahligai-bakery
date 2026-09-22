<?php

namespace App\Models;

use App\Support\OrderHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    public const ORDER_STATUSES = [
        'pesanan_dibuat' => 'Pesanan Dibuat',
        'menunggu_pembayaran' => 'Menunggu Pembayaran',
        'pembayaran_diproses' => 'Pembayaran Diproses',
        'pembayaran_berhasil' => 'Pembayaran Berhasil',
        'pesanan_diproses' => 'Pesanan Diproses',
        'pesanan_siap' => 'Pesanan Siap',
        'pesanan_selesai' => 'Pesanan Selesai',
        'pesanan_dibatalkan' => 'Pesanan Dibatalkan',
    ];

    public const PAYMENT_STATUSES = [
        'belum_bayar' => 'Menunggu Pembayaran',
        'diproses' => 'Diproses',
        'sukses' => 'Sukses',
        'gagal' => 'Gagal',
    ];

    protected $fillable = [
        'customer_id',
        'customer_name',
        'customer_phone',
        'payment_method',
        'order_status',
        'payment_status',
        'queue_number',
        'pickup_date',
        'pickup_time',
        'bakery_request',
        'subtotal',
        'add_ons_total',
        'qris_fee',
        'total',
        'order_data',
    ];

    protected $casts = [
        'order_data' => 'array',
        'subtotal' => 'integer',
        'add_ons_total' => 'integer',
        'qris_fee' => 'integer',
        'total' => 'integer',
        'queue_number' => 'integer',
        'pickup_date' => 'date',
        'pickup_time' => 'string',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function getOrderNumberAttribute(): string
    {
        return 'MB-'.str_pad((string) $this->id, 4, '0', STR_PAD_LEFT);
    }

    public function getPaymentMethodLabelAttribute(): string
    {
        return $this->payment_method === 'qris' ? 'QRIS' : 'WhatsApp';
    }

    public function getOrderStatusLabelAttribute(): string
    {
        return self::ORDER_STATUSES[$this->order_status] ?? $this->order_status;
    }

    public function getPaymentStatusLabelAttribute(): string
    {
        return self::PAYMENT_STATUSES[$this->payment_status] ?? $this->payment_status;
    }

    public function getPickupLabelAttribute(): string
    {
        if (! $this->pickup_date) {
            return '';
        }

        $date = $this->pickup_date->format('d M Y');
        $time = $this->pickup_time ? substr((string) $this->pickup_time, 0, 5) : '';

        return trim($date.' '.$time);
    }

    public function getWaOrderLinkAttribute(): string
    {
        return OrderHelper::waOrderLink($this);
    }

    public function getChatWhatsappLinkAttribute(): string
    {
        return OrderHelper::customerChatWhatsAppLink($this);
    }

    public function scopeLatest($query)
    {
        return $query->orderByDesc('id');
    }

    public function scopeForCustomer($query, User $customer)
    {
        return $query->where('customer_id', $customer->id);
    }
}
