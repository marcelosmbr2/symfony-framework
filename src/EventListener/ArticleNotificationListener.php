<?php

namespace App\EventListener;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Notifier\Recipient\Recipient;

#[AsEntityListener(event: Events::postPersist, method: 'onPostPersist', entity: Article::class)]
#[AsEntityListener(event: Events::postUpdate, method: 'onPostUpdate', entity: Article::class)]
#[AsEntityListener(event: Events::postRemove, method: 'onPostRemove', entity: Article::class)]
class ArticleNotificationListener
{
    public function __construct(
        private NotifierInterface $notifier
    ) {}

    public function onPostPersist(Article $article): void
    {
        $recipient = new Recipient($article->getAuthor()->getEmail());

        $notification = new Notification('Novo Artigo: ' . $article->getName(), ['email']);
        $notification->content('O artigo ' . $article->getName() . ' foi publicado no sistema.');
        
        $this->notifier->send($notification, $recipient);
    }

    public function onPostUpdate(Article $article): void
    {
        $recipient = new Recipient($article->getAuthor()->getEmail());

        $notification = new Notification('Artigo Atualizado: ' . $article->getName(), ['email']);
        $notification->content('O artigo ' . $article->getName() . ' foi atualizado no sistema.');
        
        $this->notifier->send($notification, $recipient);
    }

    public function onPostRemove(Article $article): void
    {
        $recipient = new Recipient($article->getAuthor()->getEmail());
 
        $notification = new Notification('Artigo Removido', ['email']);
        $notification->content('O artigo ' . $article->getName() . ' foi removido do sistema.');
        
       $this->notifier->send($notification, $recipient);
    }
}