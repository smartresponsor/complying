compliance schema migrations pack (sketch25)
apply order:
  1. 001_compliance_decision_log.sql
  2. 002_compliance_case_queue.sql
  3. 003_compliance_audit_log.sql
  4. 004_compliance_policy_registry.sql
  5. 005_compliance_decision_log_archive.sql
  6. 006_compliance_config.sql

psql -h ... -U ... -d ... -f migrations/sql/001_compliance_decision_log.sql
...
