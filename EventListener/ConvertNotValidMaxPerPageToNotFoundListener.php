<?php

namespace WhiteOctober\PagerfantaBundle\EventListener;

use Pagerfanta\Exception\NotValidMaxPerPageException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class ConvertNotValidMaxPerPageToNotFoundListener implements EventSubscriberInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => ['onException', 512],
        ];
    }

    /**
     * @param ExceptionEvent $event
     */
    public function onException(ExceptionEvent $event): void
    {
        $throwable = $event->getThrowable();

        if ($throwable instanceof NotValidMaxPerPageException) {
            $notFoundHttpException = new NotFoundHttpException('Page Not Found', $throwable);
            $event->setThrowable($notFoundHttpException);
        }
    }
}
