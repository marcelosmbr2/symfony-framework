<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

final class LoginSuccessListener
{
    public function __construct(
        private UrlGeneratorInterface $urlGenerator
    ) {
    }

    #[AsEventListener(event: LoginSuccessEvent::class)]
    public function onLoginSuccessEvent(LoginSuccessEvent $event): void
    {
        $targetUrl = $this->urlGenerator->generate('app_dashboard');
        $response = new RedirectResponse($targetUrl);
        $event->setResponse($response);
    }
}
