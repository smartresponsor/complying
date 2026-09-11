<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

declare(strict_types=1);

namespace App\Complying\Controller\Admin;

use App\Complying\Entity\ComplianceConfig;
use App\Complying\Repository\ComplianceConfigRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class ComplianceConfigAdminController
{
    #[Route(path: '/admin/compliance/config', name: 'admin_compliance_config_list', methods: ['GET'])]
    /**
     * @return Response|array<string, mixed>
     */
    public function list(ComplianceConfigRepository $repo): Response|array
    {
        return $this->viewPayload('config-list', [
            'items' => $repo->findAll(),
        ]);
    }

    #[Route(path: '/admin/compliance/config/new', name: 'admin_compliance_config_new', methods: ['GET', 'POST'])]
    /**
     * @return Response|array<string, mixed>
     */
    public function new(Request $request, EntityManagerInterface $em, UrlGeneratorInterface $urlGenerator): Response|array
    {
        if ($request->isMethod('POST')) {
            $entity = new ComplianceConfig(
                $request->request->get('keyName', ''),
                $request->request->get('value') ?: null,
                $request->request->get('scope') ?: null,
            );
            $em->persist($entity);
            $em->flush();

            return new RedirectResponse($urlGenerator->generate('admin_compliance_config_list'));
        }

        return $this->viewPayload('config-form', [
            'item' => new ComplianceConfig('', ''),
            'action' => 'create',
        ]);
    }

    #[Route(path: '/admin/compliance/config/{id}/edit', name: 'admin_compliance_config_edit', methods: ['GET', 'POST'])]
    /**
     * @return Response|array<string, mixed>
     */
    public function edit(int $id, Request $request, ComplianceConfigRepository $repo, EntityManagerInterface $em): Response|array
    {
        $item = $repo->find($id);
        if (!$item) {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException();
        }

        if ($request->isMethod('POST')) {
            $item->setValue($request->request->get('value') ?: null);
            $item->setScope($request->request->get('scope') ?: null);
            $em->flush();

            return new RedirectResponse('/admin/compliance/config');
        }

        return $this->viewPayload('config-form', [
            'item' => $item,
            'action' => 'edit',
        ]);
    }

    /**
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
