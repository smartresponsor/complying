webhook sketch
- service: App\Complying\Service\ComplianceWebhookNotifier
- config: compliance_webhook.yaml (endpoint, secret)
- can be used from decision writer (DENY/REVIEW only)
payload:
  event, outcome, object_id, policy_id, policy_version, facts
