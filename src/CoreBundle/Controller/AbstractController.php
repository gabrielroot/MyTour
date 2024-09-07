<?php

namespace MyTour\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as BaseController;

abstract class AbstractController extends BaseController
{
    public function __construct()
    {
    }

    /**
     * @param $message
     */
    protected function addErrorMessage($message)
    {
        $this->addFlash('danger', $message);
    }

    /**
     * @param $message
     */
    protected function addWarningMessage($message)
    {
        $this->addFlash('warning', $message);
    }

    /**
     * @param $message
     */
    protected function addSuccessMessage($message)
    {
        $this->addFlash('success', $message);
    }

    /**
     * @param $message
     */
    protected function addInfoMessage($message)
    {
        $this->addFlash('info', $message);
    }
}