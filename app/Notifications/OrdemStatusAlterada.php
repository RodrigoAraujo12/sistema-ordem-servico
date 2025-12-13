<?php

namespace App\Notifications;

use App\Models\OrdemServico;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrdemStatusAlterada extends Notification implements ShouldQueue
{
    use Queueable;

    public $ordem;
    public $statusAntigo;
    public $statusNovo;

    /**
     * Create a new notification instance.
     */
    public function __construct(OrdemServico $ordem, $statusAntigo, $statusNovo)
    {
        $this->ordem = $ordem;
        $this->statusAntigo = $statusAntigo;
        $this->statusNovo = $statusNovo;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $statusAntigoFormatado = OrdemServico::STATUS[$this->statusAntigo] ?? $this->statusAntigo;
        $statusNovoFormatado = OrdemServico::STATUS[$this->statusNovo] ?? $this->statusNovo;

        return (new MailMessage)
                    ->subject('Atualização na sua Ordem de Serviço #' . $this->ordem->numero_ordem)
                    ->greeting('Olá, ' . $notifiable->nome . '!')
                    ->line('Sua ordem de serviço **' . $this->ordem->numero_ordem . '** teve uma atualização de status.')
                    ->line('**Aparelho:** ' . $this->ordem->aparelho)
                    ->line('**Status anterior:** ' . $statusAntigoFormatado)
                    ->line('**Novo status:** ' . $statusNovoFormatado)
                    ->when($this->statusNovo === 'concluido', function($mail) {
                        return $mail->line('🎉 Seu equipamento está pronto para retirada!');
                    })
                    ->when($this->statusNovo === 'entregue', function($mail) {
                        return $mail->line('✅ Obrigado por confiar em nossos serviços!');
                    })
                    ->action('Ver Detalhes da Ordem', route('ordem.publica', ['token' => $this->ordem->public_token]))
                    ->line('Você pode acessar esse link a qualquer momento para acompanhar sua ordem.')
                    ->line('Obrigado por escolher nossos serviços!')
                    ->salutation('Atenciosamente, Equipe de Assistência Técnica');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'ordem_id' => $this->ordem->id,
            'numero_ordem' => $this->ordem->numero_ordem,
            'status_antigo' => $this->statusAntigo,
            'status_novo' => $this->statusNovo,
        ];
    }
}
