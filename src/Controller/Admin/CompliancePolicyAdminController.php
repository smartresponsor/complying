<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Controller\Admin;

use App\Complying\Entity\CompliancePolicyRegistry;
use App\Complying\Repository\CompliancePolicyRegistryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Handles the compliance policy admin controller HTTP boundary and delegates compliance behavior to application services.
 */
final class CompliancePolicyAdminController
{
    /**
     * Performs the list behavior as part of the owning compliance responsibility.
     *
     * @return array<string, mixed>
     */
    #[Route(path: '/admin/compliance/policies', name: 'admin_compliance_policies', methods: ['GET'])]
    public function list(CompliancePolicyRegistryRepository $repo): array
    {
        return $this->viewPayload('policy-list', [
            'items' => $repo->findAll(),
        ]);
    }

    /**
     * Performs the new behavior as part of the owning compliance responsibility.
     *
     * @return Response|array<string, mixed>
     */
    #[Route(path: '/admin/compliance/policies/new', name: 'admin_compliance_policies_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em, UrlGeneratorInterface $urlGenerator): Response|array
    {
        if ($request->isMethod('POST')) {
            $description = (string) $request->request->get('description', '');
            $entity = new CompliancePolicyRegistry(
                (string) $request->request->get('policyId', ''),
                (string) $request->request->get('policyVersion', 'v1'),
                '' !== $description ? $description : null,
                'manual',
            );
            $em->persist($entity);
            $em->flush();

            return new RedirectResponse($urlGenerator->generate('admin_compliance_policies'));
        }

        return $this->viewPayload('policy-form', [
            'item' => null,
            'action' => 'create',
        ]);
    }

    /**
     * Performs the edit behavior as part of the owning compliance responsibility.
     *
     * @return Response|array<string, mixed>
     */
    #[Route(path: '/admin/compliance/policies/edit/{id}', name: 'admin_compliance_policies_edit', methods: ['GET', 'POST'])]
    public function edit(int $id, Request $request, CompliancePolicyRegistryRepository $repo, EntityManagerInterface $em): Response|array
    {
        $item = $repo->find($id);
        if (!$item) {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException();
        }

        if ($request->isMethod('POST')) {
            $description = (string) $request->request->get('description', '');
            $item->setFrom(
                (string) $request->request->get('policyVersion', $item->getPolicyVersion()),
                '' !== $description ? $description : null,
                'manual'
            );
            $em->flush();

            return new RedirectResponse('/admin/compliance/policies');
        }

        return $this->viewPayload('policy-form', [
            'item' => $item,
            'action' => 'edit',
        ]);
    }

    /**
     * Performs the view payload behavior as part of the owning compliance responsibility.
     *
     * @param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    private function viewPayload(string $operation, array $data): array
    {
        return [
            '_view' => [
                'surface' => 'compliance',
                'operation' => $operation,
                'component' => 'Complying',
                'intent' => 'admin',
            ],
            'data' => $data,
            'meta' => [
                'source_controller' => self::class,
            ],
        ];
    }
}
