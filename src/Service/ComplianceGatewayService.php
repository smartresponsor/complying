<?php

declare(strict_types=1);

namespace App\Complying\Service;

use App\Complying\Entity\ComplianceAmlScreening;
use App\Complying\Entity\ComplianceFraudSignal;
use App\Complying\Entity\ComplianceKycProfile;
use App\Complying\Entity\ComplianceLimitPolicyEntity;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Coordinates the compliance gateway service responsibility within the Complying component and its explicit boundaries.
 */
final class ComplianceGatewayService
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    /**
     * Performs the upsert kyc behavior as part of the owning compliance responsibility.
     *
     * @param array<string, mixed> $data */
    public function upsertKyc(int $vendorId, array $data, string $status = 'pending'): ComplianceKycProfile
    {
        $repo = $this->em->getRepository(ComplianceKycProfile::class);
        $kyc = $repo->findOneBy(['vendorId' => $vendorId]) ?? new ComplianceKycProfile($vendorId, $data);
        if ('verified' === $status) {
            $kyc->markVerified();
        }
        if ('rejected' === $status) {
            $kyc->markRejected();
        }
        $this->em->persist($kyc);
        $this->em->flush();

        return $kyc;
    }

    /**
     * Performs the record aml behavior as part of the owning compliance responsibility.
     *
     * @param array<string, mixed> $hits */
    public function recordAml(int $vendorId, string $result, array $hits = []): ComplianceAmlScreening
    {
        $aml = new ComplianceAmlScreening($vendorId, $result, $hits);
        $this->em->persist($aml);
        $this->em->flush();

        return $aml;
    }

    /**
     * Performs the add fraud signal behavior as part of the owning compliance responsibility.
     *
     * @param array<string, mixed> $ctx */
    public function addFraudSignal(int $vendorId, string $type, float $score, array $ctx = []): ComplianceFraudSignal
    {
        $signal = new ComplianceFraudSignal($vendorId, $type, (string) $score, $ctx);
        $this->em->persist($signal);
        $this->em->flush();

        return $signal;
    }

    /**
     * Updates the set limits value while preserving the owning compliance invariant.
     */
    public function setLimits(int $vendorId, int $dailyMinor, int $monthlyMinor): ComplianceLimitPolicyEntity
    {
        $repo = $this->em->getRepository(ComplianceLimitPolicyEntity::class);
        $p = $repo->findOneBy(['vendorId' => $vendorId]) ?? new ComplianceLimitPolicyEntity($vendorId, $dailyMinor, $monthlyMinor);
        $ref = new \ReflectionProperty($p, 'dailyLimitMinor');
        $ref->setAccessible(true);
        $ref->setValue($p, $dailyMinor);
        $ref = new \ReflectionProperty($p, 'monthlyLimitMinor');
        $ref->setAccessible(true);
        $ref->setValue($p, $monthlyMinor);
        $this->em->persist($p);
        $this->em->flush();

        return $p;
    }
}
