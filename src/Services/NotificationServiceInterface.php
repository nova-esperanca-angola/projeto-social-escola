<?php
declare(strict_types=1);

namespace NovaEsperanca\Services;

interface NotificationServiceInterface
{
    /**
     * Notifica os coordenadores da escola sobre uma nova intenção de apadrinhamento.
     *
     * @param array<string, mixed> $donationData
     * @return bool
     */
    public function notifyNewDonation(array $donationData): bool;

    /**
     * Recupera as notificações recentes registradas para auditoria.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getRecentDispatches(): array;
}
