<?php
namespace Bits\IsoProductfeed\Controller;

use Bits\IsoProductfeed\Backend\AboutOnloadCallback;
use Contao\CoreBundle\Framework\ContaoFramework;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AboutController extends AbstractController
{
    private $aboutService;

    public function __construct(AboutOnloadCallback $aboutService)
    {
        $this->aboutService = $aboutService;
    }

    public function index(): Response
    {
        // Verwenden des Injected Services
        $this->aboutService->getInfo();

        return new Response('About Service used');
    }
}
