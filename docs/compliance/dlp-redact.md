dlp-redact sketch
- service: App\Complying\Service\ComplianceDlpRedactor
  - redactString(): email/phone/card/ssn -> placeholders
  - redactArray(): рекурсивно по массивам
- decorator: App\Complying\Service\ComplianceDlpDecisionExportService
  - if keep_raw=false -> чистит facts перед экспортом
  - если true -> пропускает как есть
- config: config/packages/compliance_dlp.yaml
