slo-tests sketch
- tools/slo/compliance_slo_check.php endpoint iterations p95_max error_max
- exit 1 если p95 или error-rate не проходит
- scripts/slo/run-slo-check.sh для CI
- пример: php tools/slo/compliance_slo_check.php http://srv/compliance/status 50 700 0.5
