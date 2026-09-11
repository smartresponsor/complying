#!/usr/bin/env bash
# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
set -e
k6 run tools/perf/compliance_decision_flow.js
