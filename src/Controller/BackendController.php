<?php

namespace Bits\IsoProductfeed\Controller;

use Contao\CoreBundle\Routing\ScopeMatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Contao\CoreBundle\Controller\AbstractBackendController;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

use Contao\System;

#[Route(' %contao.backend.route_prefix%/iso_productfeed', name: self::class, defaults: ['_scope' => 'backend'])]  
class BackendController extends AbstractBackendController
{
    
    public function __construct(
        private readonly ScopeMatcher $scopeMatcher
    ) {
          
    }

       public function __invoke(Request $request): Response
    {
                 
        if (!$this->scopeMatcher->isBackendRequest($request)) {
            throw new AccessDeniedHttpException('You are not in a Contao backend scope.');
        }
        
      
        
           return 'TEST';
      
           
         
    }
    
   
 
}


?>