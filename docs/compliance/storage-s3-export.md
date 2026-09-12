storage-s3-export sketch
- service: ComplianceS3ExportClient (aws sdk)
- ComplianceS3DecisionExportService → берёт exportDecisions() и грузит в s3
- env: COMPLIANCE_EXPORT_BUCKET
- prefix: compliance/export
