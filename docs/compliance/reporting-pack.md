reporting-pack sketch
- service: App\Complying\Service\ComplianceReportingService->daily(?date)
  - агрегирует compliance_decision_log по outcome за день
- endpoint: GET /compliance/report/daily?date=2025-11-02
  - JSON по умолчанию
  - ?csv=1 → CSV
- можно крутить в Grafana через JSON API
