<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace spec\Sylius\Component\Mailer\Sender;

use PhpSpec\ObjectBehavior;
use Sylius\Component\Mailer\Model\EmailInterface;
use Sylius\Component\Mailer\Provider\DefaultSettingsProviderInterface;
use Sylius\Component\Mailer\Provider\EmailProviderInterface;
use Sylius\Component\Mailer\Renderer\Adapter\AdapterInterface as RendererAdapterInterface;
use Sylius\Component\Mailer\Renderer\RenderedEmail;
use Sylius\Component\Mailer\Sender\Adapter\AdapterInterface as SenderAdapterInterface;

/**
 * @author Paweł Jędrzejewski <pawel@sylius.org>
 */
final class SenderSpec extends ObjectBehavior
{
    function let(
        RendererAdapterInterface $rendererAdapter,
        SenderAdapterInterface $senderAdapter,
        EmailProviderInterface $provider,
        DefaultSettingsProviderInterface $defaultSettingsProvider
    ): void {
        $this->beConstructedWith($rendererAdapter, $senderAdapter, $provider, $defaultSettingsProvider);
    }

    function it_sends_an_email_through_the_adapter(
        EmailInterface $email,
        EmailProviderInterface $provider,
        RenderedEmail $renderedEmail,
        RendererAdapterInterface $rendererAdapter,
        SenderAdapterInterface $senderAdapter
    ): void {
        $provider->getEmail('bar')->willReturn($email);
        $email->isEnabled()->willReturn(true);
        $email->getSenderAddress()->willReturn('sender@example.com');
        $email->getSenderName()->willReturn('Sender');

        $data = ['foo' => 2];

        $rendererAdapter->render($email, ['foo' => 2])->willReturn($renderedEmail);
        $senderAdapter->send(['john@example.com'], 'sender@example.com', 'Sender', $renderedEmail, $email, $data, [], [])->shouldBeCalled();

        $this->send('bar', ['john@example.com'], $data, []);
    }

    function it_does_not_send_disabled_emails(
        EmailInterface $email,
        EmailProviderInterface $provider,
        RendererAdapterInterface $rendererAdapter,
        SenderAdapterInterface $senderAdapter
    ): void {
        $provider->getEmail('bar')->willReturn($email);
        $email->isEnabled()->willReturn(false);

        $rendererAdapter->render($email, ['foo' => 2])->shouldNotBeCalled();
        $senderAdapter->send(['john@example.com'], 'mail@sylius.org', 'Sylius Mailer', null, $email, [], [], [])->shouldNotBeCalled();

        $this->send('bar', ['john@example.com'], ['foo' => 2], []);
    }
}
