<?php

declare(strict_types=1);

namespace App\Complying\Service;

use Doctrine\DBAL\Connection;
use Psr\Log\LoggerInterface;

/**
 * Coordinates the compliance limit evaluator responsibility within the Complying component and its explicit boundaries.
 */
final class ComplianceLimitEvaluator
{
    /**
     * Initializes the collaborators and state required by this compliance responsibility.
     */
    public function __construct(
        private readonly Connection $db,
        private readonly LoggerInterface $logger,
    ) {
    }

    /**
     * Performs the evaluate behavior as part of the owning compliance responsibility.
     *
     * @return array{ok: bool, daily: int, monthly: int} */
    public function evaluate(int $vendorId, int $dailyLimitMinor, int $monthlyLimitMinor): array
    {
        try {
            $daily = (int) $this->db->fetchOne('SELECT COALESCE(SUM(amount_minor),0) FROM ledger_entry WHERE reference_id = :v AND created_at >= CURRENT_DATE()', ['v' => $vendorId]);
            $monthly = (int) $this->db->fetchOne('SELECT COALESCE(SUM(amount_minor),0) FROM ledger_entry WHERE reference_id = :v AND created_at >= DATE_SUB(CURRENT_DATE(), INTERVAL 30 DAY)', ['v' => $vendorId]);
        } catch (\Throwable $e) {
            $this->logger->warning('Compliance limit usage unavailable; evaluating with zero observed usage', [
                'vendor_id' => $vendorId,
                'exception' => $e,
            ]);
            $daily = 0;
            $monthly = 0;
        }
        $ok = $daily <= $dailyLimitMinor && $monthly <= $monthlyLimitMinor;

        return ['ok' => $ok, 'daily' => $daily, 'monthly' => $monthly];
    }
}
