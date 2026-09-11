#!/usr/bin/env bash
# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
set -e

SERVER_URL=${1:-http://localhost:8080}

echo "[ops] run slo..."
php tools/slo/compliance_slo_check.php "$SERVER_URL/compliance/status" 30 700 0.5

echo "[ops] run e2e..."
php tools/e2e/deny.php "$SERVER_URL"
php tools/e2e/review.php "$SERVER_URL"
php tools/e2e/permit.php "$SERVER_URL"

echo "[ops] webhook retry..."
if [ -f "bin/console" ]; then
  php bin/console compliance:webhook:retry || true
else
  echo "[ops] skip webhook retry (bin/console not found)"
fi

echo "[ops] report daily..."
curl -s "$SERVER_URL/compliance/report/daily?csv=1" -o report-daily.csv

echo "[ops] done."
