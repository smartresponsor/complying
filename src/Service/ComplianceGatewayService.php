<?php

declare(strict_types=1);

namespace App\Complying\Service;

use App\Complying\Entity\ComplianceAmlScreening;
use App\Complying\Entity\ComplianceFraudSignal;
use App\Complying\Entity\ComplianceKycProfile;
use App\Complying\Entity\ComplianceLimitPolicy;
use Doctrine\ORM\EntityManagerInterface;

final class ComplianceGatewayService
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

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

    public function recordAml(int $vendorId, string $result, array $hits = []): ComplianceAmlScreening
    {
        $aml = new ComplianceAmlScreening($vendorId, $result, $hits);
        $this->em->persist($aml);
        $this->em->flush();

        return $aml;
    }

    public function addFraudSignal(int $vendorId, string $type, float $score, array $ctx = []): ComplianceFraudSignal
    {
        $signal = new ComplianceFraudSignal($vendorId, $type, (string) $score, $ctx);
        $this->em->persist($signal);
        $this->em->flush();

        return $signal;
    }

    public function setLimits(int $vendorId, int $dailyMinor, int $monthlyMinor): ComplianceLimitPolicy
    {
        $repo = $this->em->getRepository(ComplianceLimitPolicy::class);
        $p = $repo->findOneBy(['vendorId' => $vendorId]) ?? new ComplianceLimitPolicy($vendorId, $dailyMinor, $monthlyMinor);
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
