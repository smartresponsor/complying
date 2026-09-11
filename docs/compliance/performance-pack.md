performance-pack sketch
- tools/perf/compliance_decision_flow.js (k6 scenario)
- migrations/Version20251102CompliancePerf.sql (indexes on outcome, tenant_id, decided_at, case status)
- scripts/perf/compliance-k6-run.sh (local)
run:
  psql ... -f migrations/Version20251102CompliancePerf.sql
  k6 run tools/perf/compliance_decision_flow.js
target:
  - p95 <= 250ms for GET, <= 700ms for decision
  - error-rate <= 0.5%
