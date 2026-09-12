ops-metrics sketch
- service: App\Complying\Service\ComplianceMetricsRegistry
  - incDecision()
  - setCasesOpen(count)
  - incImportFail()
  - export() -> prometheus text format
- endpoint: GET /compliance/metrics
- добавить вызовы в writer/import/case worker
