#!/usr/bin/env bash
# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
set -e
SERVER_URL=${1:-http://localhost:8080}
echo "[ops] decisions today:"
curl -s "$SERVER_URL/compliance/report/daily" | jq . || cat "$SERVER_URL/compliance/report/daily"
