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

namespace BitExpert\Sulu\RobotstxtBundle\Controller\Website;

use BitExpert\Sulu\RobotstxtBundle\Entity\Robotstxt;
use BitExpert\Sulu\RobotstxtBundle\Repository\RobotstxtRepository;
use Sulu\Component\Webspace\Analyzer\Attributes\RequestAttributes;
use Sulu\Component\Webspace\Portal;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RobotstxtWebsiteController extends AbstractController
{
    public function __construct(
        private readonly RobotstxtRepository $repository
    ) {
    }

    public function getAction(Request $request): Response
    {
        /** @var RequestAttributes|null $sulu */
        $sulu = $request->attributes->get('_sulu', null);
        if ($sulu === null) {
            throw $this->createNotFoundException();
        }

        /** @var Portal|null $webspace */
        $webspace = $sulu->getAttribute('webspace', null);
        if ($webspace === null) {
            throw $this->createNotFoundException();
        }

        $entity = $this->repository->findByWebspaceKey($webspace->getKey());
        if (!$entity instanceof Robotstxt) {
            throw $this->createNotFoundException();
        }

        $response = new Response((string) $entity->getContent());
        $response->headers->set('Content-Type', 'text/plain; charset=utf-8');

        return $response;
    }
}