message-bus-hook sketch
- message: App\Complying\Message\ComplianceIncidentCreated
- handler: App\Complying\MessageHandler\ComplianceIncidentCreatedHandler (logs, optional webhook)
- decorator: App\Complying\Service\MessengerCompliancePolicyService
  - dispatch on DENY/REVIEW
- config: config/packages/messenger_compliance.yaml (in-memory, can switch to amqp)
