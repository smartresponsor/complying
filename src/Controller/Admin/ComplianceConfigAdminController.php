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
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class ComplianceConfigAdminController
{
    /**
     * @return array<string, mixed>
     */
    #[Route(path: '/admin/compliance/config', name: 'admin_compliance_config_list', methods: ['GET'])]
    public function list(ComplianceConfigRepository $repo): array
    {
        return $this->viewPayload('config-list', [
            'items' => $repo->findAll(),
        ]);
    }

    /**
     * @return Response|array<string, mixed>
     */
    #[Route(path: '/admin/compliance/config/new', name: 'admin_compliance_config_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em, UrlGeneratorInterface $urlGenerator): Response|array
    {
        if ($request->isMethod('POST')) {
            $entity = new ComplianceConfig(
                (string) $request->request->get('keyName', ''),
                '' !== ($value = (string) $request->request->get('value', '')) ? $value : null,
                '' !== ($scope = (string) $request->request->get('scope', '')) ? $scope : null,
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

    /**
     * @return Response|array<string, mixed>
     */
    #[Route(path: '/admin/compliance/config/{id}/edit', name: 'admin_compliance_config_edit', methods: ['GET', 'POST'])]
    public function edit(int $id, Request $request, ComplianceConfigRepository $repo, EntityManagerInterface $em): Response|array
    {
        $item = $repo->find($id);
        if (!$item) {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException();
        }

        if ($request->isMethod('POST')) {
            $value = (string) $request->request->get('value', '');
            $scope = (string) $request->request->get('scope', '');
            $item->setValue('' !== $value ? $value : null);
            $item->setScope('' !== $scope ? $scope : null);
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
