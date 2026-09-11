#!/usr/bin/env bash
# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
set -e

echo "[smoke] checking compliance status ..."
curl -s http://localhost:8081/compliance/status || exit 1

echo "[smoke] checking compliance metrics ..."
curl -s http://localhost:8081/compliance/metrics || exit 1

echo "[smoke] OK"
