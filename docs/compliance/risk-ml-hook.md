risk-ml-hook sketch
- ComplianceExternalRiskClient дергает внешний ML/LLM endpoint (POST JSON)
- decorator ComplianceExternalRiskScoreService → если facts.needs_ml=true, дозапрашиваем
- берём максимум из локального и внешнего score
- endpoint задаём через EXTERNAL_RISK_ENDPOINT
