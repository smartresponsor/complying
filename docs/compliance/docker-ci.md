docker/ci sketch
- docker/compliance/Dockerfile
- docker-compose.yml (app + postgres)
- scripts/smoke/compliance-smoke.sh
run:
  docker compose up -d --build
  ./scripts/smoke/compliance-smoke.sh
