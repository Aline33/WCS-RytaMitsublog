<?php

namespace App\Controller;

class LegalNoticeController extends AbstractController
{
    public function legalNotice(): string
    {
        return $this->twig->render('Legal/bt-legal-notice.html.twig');
    }

    public function privacyPolicy(): string
    {
        return $this->twig->render('Legal/bt-privacy-policy.html.Twig');
    }

    public function rgpd(): string
    {
        return $this->twig->render('Legal/bt-RGPD.html.twig');
    }

    public function cgu(): string
    {
        return $this->twig->render('Legal/bt-CGU.html.twig');
    }
}
