sanction import sketch
- console: bin/console compliance:sanction:import sanctions.json
- http: POST /compliance/sanction/import
payload example:
[{"name": "ACME Corp", "source": "ofac"}, {"name": "John Doe", "source": "eu"}]
dedupe by name
