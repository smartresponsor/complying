<?php

declare(strict_types=1);

namespace App\Complying\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Models the persisted compliance limit policy entity concept and protects its compliance workflow invariants.
 */
#[ORM\Entity]
#[ORM\Table(name: 'limit_policy')]
class ComplianceLimitPolicyEntity
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'integer')]
    private int $vendorId;

    #[ORM\Column(type: 'bigint')]
    private int $dailyLimitMinor = 0;

    #[ORM\Column(type: 'bigint')]
    private int $monthlyLimitMinor = 0;

    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(int $vendorId, int $dailyLimitMinor, int $monthlyLimitMinor)
    {
        $this->vendorId = $vendorId;
        $this->dailyLimitMinor = $dailyLimitMinor;
        $this->monthlyLimitMinor = $monthlyLimitMinor;
    }

    /**
     * Returns the get vendor id value exposed by this compliance responsibility.
     */
    public function getVendorId(): int
    {
        return $this->vendorId;
    }

    /**
     * Returns the get daily limit minor value exposed by this compliance responsibility.
     */
    public function getDailyLimitMinor(): int
    {
        return $this->dailyLimitMinor;
    }

    /**
     * Returns the get monthly limit minor value exposed by this compliance responsibility.
     */
    public function getMonthlyLimitMinor(): int
    {
        return $this->monthlyLimitMinor;
    }
}
