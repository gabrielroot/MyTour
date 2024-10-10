<?php

namespace MyTour\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as BaseController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

abstract class AbstractController extends BaseController
{
    public function __construct()
    {
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function redirectToReferer(Request $request, string $fallbackUrl): RedirectResponse
    {
        $referer = $request->headers->get('referer');
        return $this->redirect($referer ?: $fallbackUrl);
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