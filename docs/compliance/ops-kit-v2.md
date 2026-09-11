ops-kit-v2 sketch
- tools/ops/run-all.sh → slo + e2e + webhook:retry + report
- tools/ops/status.sh → быстрый статус
- docker/docker-compose.ops.yml → локальный стенд (app+db+otel)
- предполагает наличие:
  - tools/slo/...
  - tools/e2e/...
  - bin/console compliance:webhook:retry
  - endpoint /compliance/report/daily
