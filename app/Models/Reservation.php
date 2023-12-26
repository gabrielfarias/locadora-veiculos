<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Reservation extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = ['user_id', 'vehicle_id', 'pickup_date', 'return_date'];
    protected $dates = ['pickup_date', 'return_date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public static function vehicleAlreadyReserved($vehicleId, $userId, $pickupDate, $returnDate, $currentReservationId = null)
    {
        $query = self::where('vehicle_id', $vehicleId)
            ->where('user_id', '<>', $userId) // Não permitir o mesmo usuário
            ->where(function ($query) use ($pickupDate, $returnDate) {
                $query->whereBetween('pickup_date', [$pickupDate, $returnDate])
                    ->orWhereBetween('return_date', [$pickupDate, $returnDate])
                    ->orWhere(function ($query) use ($pickupDate, $returnDate) {
                        $query->where('pickup_date', '<=', $pickupDate)
                            ->where('return_date', '>=', $returnDate);
                    });
            });

        // Excluir a reserva atual da verificação
        if ($currentReservationId) {
            $query->where('id', '<>', $currentReservationId);
        }

        return $query->exists();
    }
}
