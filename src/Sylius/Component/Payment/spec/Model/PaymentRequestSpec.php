<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Sylius Sp. z o.o.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace spec\Sylius\Component\Payment\Model;

use PhpSpec\ObjectBehavior;
use stdClass;
use Sylius\Component\Payment\Model\PaymentInterface;
use Sylius\Component\Payment\Model\PaymentMethodInterface;
use Sylius\Component\Payment\Model\PaymentRequestInterface;

final class PaymentRequestSpec extends ObjectBehavior
{
    function let(PaymentInterface $payment, PaymentMethodInterface $method): void
    {
        $this->beConstructedWith($payment, $method);
    }

    function it_implements_sylius_payment_request_interface(): void
    {
        $this->shouldImplement(PaymentRequestInterface::class);
    }

    function it_has_no_hash_by_default(): void
    {
        $this->getId()->shouldReturn(null);
    }

    function it_has_a_payment_by_default(): void
    {
        $this->getPayment()->shouldReturnAnInstanceOf(PaymentInterface::class);
    }

    function it_has_a_payment_method_by_default(): void
    {
        $this->getMethod()->shouldReturnAnInstanceOf(PaymentMethodInterface::class);
    }

    function its_payment_method_is_mutable(PaymentMethodInterface $method): void
    {
        $this->setMethod($method);
        $this->getMethod()->shouldReturn($method);
    }

    function its_payment_is_mutable(PaymentInterface $payment): void
    {
        $this->setPayment($payment);
        $this->getPayment()->shouldReturn($payment);
    }

    function it_has_new_state_by_default(): void
    {
        $this->getState()->shouldReturn(PaymentRequestInterface::STATE_NEW);
    }

    function its_state_is_mutable(): void
    {
        $this->setState('test_state');
        $this->getState()->shouldReturn('test_state');
    }

    function it_has_capture_action_by_default(): void
    {
        $this->getAction()->shouldReturn(PaymentRequestInterface::ACTION_CAPTURE);
    }

    function its_action_is_mutable(): void
    {
        $this->setAction('test_action');
        $this->getAction()->shouldReturn('test_action');
    }

    function it_has_null_payload_by_default(): void
    {
        $this->getPayload()->shouldReturn(null);
    }

    function its_payload_is_mutable(): void
    {
        $stdClass = new stdClass();
        $this->setPayload($stdClass);
        $this->getPayload()->shouldReturn($stdClass);
    }

    function it_has_empty_array_response_data_by_default(): void
    {
        $this->getResponseData()->shouldReturn([]);
    }

    function its_response_data_are_mutable(): void
    {
        $this->setResponseData(['foo', 'bar']);
        $this->getResponseData()->shouldReturn(['foo', 'bar']);
    }

    function it_initializes_creation_date_by_default(): void
    {
        $this->getCreatedAt()->shouldHaveType('DateTime');
    }

    function its_creation_date_is_mutable(): void
    {
        $date = new \DateTime('last year');

        $this->setCreatedAt($date);
        $this->getCreatedAt()->shouldReturn($date);
    }

    function it_has_no_last_update_date_by_default(): void
    {
        $this->getUpdatedAt()->shouldReturn(null);
    }

    function its_last_update_date_is_mutable(): void
    {
        $date = new \DateTime('last year');

        $this->setUpdatedAt($date);
        $this->getUpdatedAt()->shouldReturn($date);
    }
}
