incident-webhook sketch
- service: ComplianceIncidentWebhookService (send + retry)
- entity: compliance_incident_webhook (url, payload, attempts)
- cli: bin/console compliance:webhook:retry
- интеграция: дергать send() из message-bus handler’а
- политика retry: до 5 попыток, потом в audit как failed
