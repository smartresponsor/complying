<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

use App\Complying\Entity\ComplianceIncidentWebhook;
use App\Complying\Repository\IncidentWebhookRepository;
use App\Complying\ServiceInterface\ComplianceAuditTrailServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class IncidentWebhookService
{
    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly EntityManagerInterface $em,
        private readonly IncidentWebhookRepository $repo,
        private readonly ComplianceAuditTrailServiceInterface $audit,
        private readonly string $targetUrl,
    ) {
    }

    /**
     * @param array<string, mixed> $incident
     */
    public function send(array $incident): void
    {
        try {
            $resp = $this->httpClient->request('POST', $this->targetUrl, [
                'json' => $incident,
                'timeout' => 3.0,
            ]);
            $code = $resp->getStatusCode();

            if ($code >= 200 && $code < 300) {
                $this->audit->add('compliance.webhook.sent', $incident);

                return;
            }
        } catch (\Throwable $e) {
            // fallthrough to persist for retry
        }

        $entity = new ComplianceIncidentWebhook($this->targetUrl, $incident);
        $this->em->persist($entity);
        $this->em->flush();

        $this->audit->add('compliance.webhook.enqueue', $incident);
    }

    public function retry(int $limit = 20): int
    {
        $items = $this->repo->findPending($limit);
        $sent = 0;

        foreach ($items as $item) {
            $payload = json_decode($item->getPayload(), true, 512, \JSON_THROW_ON_ERROR);
            try {
                $resp = $this->httpClient->request('POST', $item->getUrl(), [
                    'json' => $payload,
                    'timeout' => 3.0,
                ]);
                if ($resp->getStatusCode() >= 200 && $resp->getStatusCode() < 300) {
                    $this->em->remove($item);
                    $this->audit->add('compliance.webhook.retry.sent', $payload);
                    ++$sent;
                    continue;
                }
            } catch (\Throwable) {
                // keep
            }
            $item->incAttempts();
            if ($item->getAttempts() >= 5) {
                $this->audit->add('compliance.webhook.retry.failed', $payload);
                $this->em->remove($item);
            }
        }

        $this->em->flush();

        return $sent;
    }
}
