compliance DR runbook
1. stop writers
2. restore DB from latest backup
3. restore compliance_policy_registry (if exported separately)
4. replay ndjson:
   - php tools/dr/replay-ndjson.php /backup/compliance/decision-log-*.ndjson
5. check /compliance/report/daily
