<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscountUse extends Model
{
    protected $fillable = [
        'discount_code_id', // ID do código de desconto usado
        'user_id', // ID do usuário que utilizou o desconto
        'service_id', // ID do serviço relacionado
        'amount_discounted', // Quantidade de desconto aplicada
        'booking_id', // ID da reserva (opcional)
    ];

    // Relacionamento com o modelo DiscountCode
    public function discountCode()
    {
        return $this->belongsTo(DiscountCode::class);
    }

    // Relacionamento com o modelo User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relacionamento com o modelo Service
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    // Relacionamento com o modelo Booking (caso necessário)
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}

