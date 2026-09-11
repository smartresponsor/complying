#!/usr/bin/env bash
# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
set -e
php tools/slo/compliance_slo_check.php "${1:-http://localhost:8080/compliance/status}" "${2:-30}" "${3:-700}" "${4:-0.5}"
