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

namespace Sylius\Behat\Page\Admin\CatalogPromotion;

use Behat\Mink\Element\NodeElement;
use Sylius\Behat\Behaviour\ChecksCodeImmutability;
use Sylius\Behat\Page\Admin\Crud\UpdatePage as BaseUpdatePage;

class UpdatePage extends BaseUpdatePage implements UpdatePageInterface
{
    use ChecksCodeImmutability;

    public function isStartDateDisabled(): bool
    {
        return 'disabled' === $this->getElement('start_date')->getAttribute('disabled');
    }

    public function isEndDateDisabled(): bool
    {
        return 'disabled' === $this->getElement('start_date')->getAttribute('disabled');
    }

    protected function getCodeElement(): NodeElement
    {
        return $this->getElement('code');
    }

    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'code' => '#sylius_catalog_promotion_code',
            'end_date' => '#sylius_catalog_promotion_endDate',
            'start_date' => '#sylius_catalog_promotion_startDate',
        ]);
    }
}
