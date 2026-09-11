e2e-tests sketch
- tools/e2e/deny.php http://host
- tools/e2e/review.php http://host
- tools/e2e/permit.php http://host
- fixtures/compliance/e2e-fixtures.sql
- прогон в CI: php tools/e2e/deny.php && php tools/e2e/review.php && php tools/e2e/permit.php
note:
  - ожидание, что endpoint /compliance/status уже существует
  - можно обернуть в junit, если надо
