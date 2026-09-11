-- compliance e2e fixtures
INSERT INTO compliance_policy_registry (policy_id, policy_version, description, source)
VALUES ('order.created', 'v1', 'Order created base policy', 'fixture')
ON CONFLICT (policy_id) DO NOTHING;
