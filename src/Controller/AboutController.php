<?php
namespace Bits\IsoProductfeed\Controller;

use Bits\IsoProductfeed\Backend\About;

class AboutController
{
    private $aboutService;

    public function __construct(About $aboutService)
    {
        $this->aboutService = $aboutService;
    }

    public function getInfo()
    {
        $this->aboutService->getInfo();
    }
}
