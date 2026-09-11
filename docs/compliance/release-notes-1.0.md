Compliance component — draft release 1.0
date: 2025-11-03

included sketches: 1..45
- core, audit, registry, k8s, perf, enrich, cli, config, risk, ops, migrations
- export, bus, admin, slo, bucket, webhook, dlp, otel, e2e, fixtures
- tenant, expression, reporting, role-sync, ops-kit v2
- hmac, webhook-signing, ci-pack, helm-prod

breaking:
- expects role-domain present
- expects decision_log table
