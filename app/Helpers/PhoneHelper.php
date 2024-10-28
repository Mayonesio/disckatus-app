<?php

namespace App\Helpers;

class PhoneHelper
{
    public static function format($phone)
    {
        if (!$phone) return null;
        
        // Eliminar todos los caracteres no numéricos excepto '+'
        $phone = preg_replace('/[^0-9+]/', '', $phone);
        
        // Si no tiene prefijo internacional, añadir +34
        if (!str_starts_with($phone, '+')) {
            $phone = '+34' . $phone;
        }
        
        return $phone;
    }
}