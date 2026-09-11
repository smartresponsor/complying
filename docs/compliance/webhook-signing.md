webhook-signing sketch
- decorator SignedIncidentWebhookService
- добавляет X-Compliance-Sign (HMAC sha256 по payload)
- ключ: COMPLIANCE_WEBHOOK_SECRET
- совместимо с incident-webhook (sketch31)
