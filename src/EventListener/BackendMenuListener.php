<?php
// src/EventListener/BackendMenuListener.php
namespace Bits\Iso_Productfeed\EventListener;

use Bits\Iso_Productfeed\Controller\BackendController;
use Contao\CoreBundle\Event\ContaoCoreEvents;
use Contao\CoreBundle\Event\MenuEvent;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Routing\RouterInterface;

#[AsEventListener(ContaoCoreEvents::BACKEND_MENU_BUILD, priority: -4005)]
class BackendMenuListener
{
    protected $router;
    protected $requestStack;

    public function __construct(RouterInterface $router, RequestStack $requestStack)
    {
        $this->router = $router;
        $this->requestStack = $requestStack;
        
    }

    public function __invoke(MenuEvent $event): void
    {
        $factory = $event->getFactory();
        $tree = $event->getTree();

        if ('mainMenu' !== $tree->getName()) {
            return;
        }

        $contentNode = $tree->getChild('isotope');

        $node = $factory
            ->createItem('iso_productfeed')
                ->setUri($this->router->generate(BackendController::class))
                ->setLabel('Iso Productfeed')
                ->setLinkAttribute('title', 'Iso Productfeed')
                ->setLinkAttribute('class', 'iso-productfeed')
                ->setCurrent($this->requestStack->getCurrentRequest()->get('_controller') === BackendController::class)
        ;

        $contentNode->addChild($node);
    }
}
