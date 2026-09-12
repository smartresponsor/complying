<?php

declare(strict_types=1);

namespace App\Complying\Service;

use Doctrine\DBAL\Connection;
use Psr\Log\LoggerInterface;

final class RiskScorer
{
    public function __construct(
        private readonly Connection $db,
        private readonly LoggerInterface $logger,
    ) {
    }

    public function scoreVendor(int $vendorId): float
    {
        $velocity = 0;
        try {
            $velocity = (int) $this->db->fetchOne('SELECT COUNT(*) FROM ledger_entry WHERE reference_id = :v AND created_at >= DATE_SUB(NOW(), INTERVAL 1 DAY)', ['v' => $vendorId]);
        } catch (\Throwable $e) {
            $this->logger->warning('Compliance velocity risk signal unavailable', ['vendor_id' => $vendorId, 'exception' => $e]);
        }

        $aml = 0;
        try {
            $aml = (int) $this->db->fetchOne("SELECT COUNT(*) FROM aml_screening WHERE vendor_id = :v AND result != 'clear'", ['v' => $vendorId]);
        } catch (\Throwable $e) {
            $this->logger->warning('Compliance AML risk signal unavailable', ['vendor_id' => $vendorId, 'exception' => $e]);
        }

        $fraud = 0;
        try {
            $fraud = (int) $this->db->fetchOne('SELECT COUNT(*) FROM fraud_signal WHERE vendor_id = :v AND score >= 70', ['v' => $vendorId]);
        } catch (\Throwable $e) {
            $this->logger->warning('Compliance fraud risk signal unavailable', ['vendor_id' => $vendorId, 'exception' => $e]);
        }

        return min(100.0, $velocity * 2 + $aml * 20 + $fraud * 10);
    }
}
