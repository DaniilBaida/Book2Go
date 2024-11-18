<?php

namespace App\Policies;

use App\Models\DiscountCode;
use App\Models\User;

class DiscountCodePolicy
{
    /**
     * Determine if the user can update the discount code.
     */
    public function update(User $user, DiscountCode $discountCode)
    {
        // Permitir apenas se o código de desconto pertence ao negócio do usuário autenticado
        return $discountCode->business_id === $user->business->id;
    }

    /**
     * Determine if the user can delete the discount code.
     */
    public function delete(User $user, DiscountCode $discountCode)
    {
        // Permitir apenas se o código de desconto pertence ao negócio do usuário autenticado
        return $discountCode->business_id === $user->business->id;
    }
}
