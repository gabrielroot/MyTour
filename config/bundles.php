<?php

use MyTour\CoreBundle\MyTourCoreBundle;
use MyTour\ExcursionBundle\MyTourExcursionBundle;
use MyTour\UserBundle\MyTourUserBundle;

return [
    ### DOMAIN_BUNDLES ##
    MyTourCoreBundle::class => ['all' => true],
    MyTourExcursionBundle::class => ['all' => true],
    MyTourUserBundle::class => ['all' => true],
    ### APP_BUNDLES ##
    Symfony\Bundle\FrameworkBundle\FrameworkBundle::class => ['all' => true],
];
