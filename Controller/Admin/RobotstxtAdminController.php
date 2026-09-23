<?php
/*
 * This file is part of the Sulu Robotstxt bundle.
 *
 * (c) bitExpert AG
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace BitExpert\Sulu\RobotstxtBundle\Controller\Admin;

use BitExpert\Sulu\RobotstxtBundle\Common\DoctrineListRepresentationFactory;
use BitExpert\Sulu\RobotstxtBundle\Entity\Robotstxt;
use BitExpert\Sulu\RobotstxtBundle\Repository\RobotstxtRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * @phpstan-type RobotstxtData array{
 *     id: int|null,
 *     webspace_key: string|null,
 *     content: string,
 * }
 */
#[Route('/admin/api')]
class RobotstxtAdminController extends AbstractController
{
    public function __construct(
        private readonly RobotstxtRepository $repository,
        private readonly DoctrineListRepresentationFactory $doctrineListRepresentationFactory,
    ) {
    }

    #[Route(path: '/robotstxt/{id}', name: 'bitexpert.get_robotstxt', methods: ['GET'])]
    public function getAction(int $id): Response
    {
        $entity = $this->repository->findById($id);
        if (!$entity instanceof Robotstxt) {
            throw $this->createNotFoundException();
        }

        return $this->json($this->getDataForEntity($entity));
    }

    #[Route(path: '/robotstxt/{id}', name: 'bitexpert.put_robotstxt', methods: ['PUT'])]
    public function putAction(int $id, Request $request): Response
    {
        $entity = $this->repository->findById($id);
        if (!$entity instanceof Robotstxt) {
            throw $this->createNotFoundException();
        }

        /** @var RobotstxtData $data */
        $data = $request->toArray();
        $this->mapDataToEntity($data, $entity);

        $this->repository->save($entity);

        return $this->json($this->getDataForEntity($entity));
    }

    #[Route(path: '/robotstxt', name: 'bitexpert.post_robotstxt', methods: ['POST'])]
    public function postAction(Request $request): Response
    {
        $entity = $this->repository->create();

        /** @var RobotstxtData $data */
        $data = $request->toArray();
        $data['webspace_key'] = $request->get('webspace');
        $this->mapDataToEntity($data, $entity);

        $this->repository->save($entity);

        return $this->json($this->getDataForEntity($entity), 201);
    }

    #[Route(path: '/robotstxt/{id}', name: 'bitexpert.delete_robotstxt', methods: ['DELETE'])]
    public function deleteAction(int $id): Response
    {
        $this->repository->remove($id);

        return $this->json(null, 204);
    }

    #[Route(path: '/robotstxt', name: 'bitexpert.get_robotstxt_list', methods: ['GET'])]
    public function getListAction(): Response
    {
        $listRepresentation = $this->doctrineListRepresentationFactory->createDoctrineListRepresentation(
            Robotstxt::RESOURCE_KEY,
        );

        return $this->json($listRepresentation->toArray());
    }

    /**
     * @return RobotstxtData
     */
    protected function getDataForEntity(Robotstxt $entity): array
    {
        return [
            'id' => $entity->getId(),
            'webspace_key' => $entity->getWebspaceKey(),
            'content' => $entity->getContent() ?? '',
        ];
    }

    /**
     * @param RobotstxtData $data
     */
    protected function mapDataToEntity(array $data, Robotstxt $entity): void
    {
        $entity->setWebspaceKey($data['webspace_key']);
        $entity->setContent($data['content'] ?? '');
    }
}