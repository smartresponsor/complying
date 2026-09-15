<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Service;

use App\Complying\Entity\ComplianceConfig;
use App\Complying\Repository\ComplianceConfigRepository;
use App\Complying\ServiceInterface\ComplianceAuditTrailServiceInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Coordinates the compliance config service responsibility within the Complying component and its explicit boundaries.
 */
final class ComplianceConfigService
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(
        private readonly ComplianceConfigRepository $repo,
        private readonly EntityManagerInterface $em,
        private readonly ?ComplianceAuditTrailServiceInterface $audit = null,
    ) {
    }

    /**
     * Returns the get value exposed by this compliance responsibility.
     */
    public function get(string $key): ?ComplianceConfig
    {
        return $this->repo->getByKey($key);
    }

    /**
     * Updates the set value while preserving the owning compliance invariant.
     */
    public function set(string $key, ?string $value, ?string $scope = null): ComplianceConfig
    {
        $cfg = $this->repo->getByKey($key);

        if (!$cfg) {
            $cfg = new ComplianceConfig($key, $value, $scope);
            $this->em->persist($cfg);
        } else {
            $cfg->setValue($value);
            if (null !== $scope) {
                $cfg->setScope($scope);
            }
        }

        $this->em->flush();

        if ($this->audit) {
            $this->audit->add('compliance.config.set', ['key' => $key, 'value' => $value, 'scope' => $scope]);
        }

        return $cfg;
    }

    /**
     * Performs the list behavior as part of the owning compliance responsibility.
     *
     * @return array<int, array<string, mixed>>
     */
    public function list(): array
    {
        $all = $this->repo->findAll();
        $rows = [];
        foreach ($all as $cfg) {
            $rows[] = [
                'key' => $cfg->getKeyName(),
                'value' => $cfg->getValue(),
                'scope' => $cfg->getScope(),
                'updated_at' => $cfg->getUpdatedAt()?->format(\DATE_ATOM),
            ];
        }

        return $rows;
    }
}
