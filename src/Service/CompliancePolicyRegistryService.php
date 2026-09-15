<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

use App\Complying\Entity\CompliancePolicyRegistry;
use App\Complying\Repository\CompliancePolicyRegistryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Coordinates the compliance policy registry service responsibility within the Complying component and its explicit boundaries.
 */
final class CompliancePolicyRegistryService
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly CompliancePolicyRegistryRepository $repo,
        private readonly EntityManagerInterface $em,
        private readonly LoggerInterface $logger,
        private readonly string $endpoint,
    ) {
    }

    /**
     * Performs the refresh behavior as part of the owning compliance responsibility.
     */
    public function refresh(): int
    {
        $resp = $this->httpClient->request('GET', $this->endpoint, ['timeout' => 3.0]);
        $data = $resp->toArray(false);

        $count = 0;
        foreach ($data as $item) {
            if (!isset($item['id'], $item['version'])) {
                continue;
            }
            $policyId = (string) $item['id'];
            $version = (string) $item['version'];
            $desc = $item['description'] ?? null;

            $existing = $this->repo->findOneByPolicyId($policyId);
            if ($existing) {
                $existing->setFrom($version, $desc, 'role');
            } else {
                $this->em->persist(new CompliancePolicyRegistry($policyId, $version, $desc, 'role'));
            }
            ++$count;
        }

        if ($count > 0) {
            $this->em->flush();
        }

        $this->logger->info('Compliance policy registry refreshed', ['count' => $count]);

        return $count;
    }

    /**
     * Performs the list behavior as part of the owning compliance responsibility.
     *
     * @return array<int, array<string, mixed>>
     */
    public function list(): array
    {
        $all = $this->repo->findBy([], ['policyId' => 'ASC']);
        $rows = [];
        foreach ($all as $item) {
            $rows[] = [
                'policy_id' => $item->getPolicyId(),
                'version' => $item->getPolicyVersion(),
                'description' => $item->getDescription(),
                'source' => $item->getSource(),
                'updated_at' => $item->getUpdatedAt()?->format(\DATE_ATOM),
            ];
        }

        return $rows;
    }
}
