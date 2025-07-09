<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Producto;

class StockBajoNotification extends Notification
{
    use Queueable;

    public $producto;

    public function __construct(Producto $producto)
    {
        $this->producto = $producto;
    }

    public function via(object $notifiable): array
    {
        return ['database']; // 👈 Solo por base de datos
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('⚠️ Stock bajo de producto')
            ->greeting('Hola ' . $notifiable->name . ',')
            ->line("El producto **{$this->producto->nombre}** tiene un stock bajo.")
            ->line("Cantidad disponible: **{$this->producto->stock}** unidades.")
            ->action('Ver producto', url('/productos')) // Ajusta esta URL
            ->line('Por favor, revisa el inventario para tomar acción.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'mensaje' => "⚠️ El producto '{$this->producto->nombre}' tiene un stock bajo ({$this->producto->stock}).",
            'producto_id' => $this->producto->id,
        ];
    }
}
