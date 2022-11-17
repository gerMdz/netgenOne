<?php

namespace App\Twig\Components;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\ValidatableComponentTrait;

#[AsLiveComponent('subscribe_newsletter')]
final class SubscribeNewsletterComponent
{
    use DefaultActionTrait;
    use ValidatableComponentTrait;

    #[Assert\NotBlank]
    #[LiveProp(writable: true)]
    public string $firstName = '';

    #[Assert\Email]
    #[Assert\NotBlank]
    #[LiveProp(writable: true)]
    public string $email = '';

    #[LiveProp]
    public bool $isSuccessful = false;

    #[LiveAction]
    public function signUp(): void
    {
        $this->validate();

        // TODO: actually save the email somewhere

        $this->isSuccessful = true;
    }
}
