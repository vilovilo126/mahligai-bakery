<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public const ORDER_STATUSES = [
        'menunggu_pembayaran' => 'Menunggu Pembayaran',
        'pembayaran_diproses' => 'Pembayaran Diproses',
        'pembayaran_berhasil' => 'Pembayaran Berhasil',
        'pesanan_diproses' => 'Pesanan Diproses',
        'pesanan_siap' => 'Pesanan Siap',
        'pesanan_selesai' => 'Pesanan Selesai',
        'pesanan_dibatalkan' => 'Pesanan Dibatalkan',
    ];

    public const PAYMENT_STATUSES = [
        'belum_bayar' => 'Belum Dibayar',
        'diproses' => 'Diproses',
        'sukses' => 'Sukses',
        'gagal' => 'Gagal',
    ];

    protected $fillable = [
        'customer_name',
        'customer_phone',
        'payment_method',
        'order_status',
        'payment_status',
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
    ];

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

    public function scopeLatest($query)
    {
        return $query->orderByDesc('id');
    }
}
