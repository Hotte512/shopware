<?php declare(strict_types=1);

namespace Shopware\Api\Config\Event\ConfigFormFieldValue;

use Shopware\Api\Config\Collection\ConfigFormFieldValueBasicCollection;
use Shopware\Context\Struct\ShopContext;
use Shopware\Framework\Event\NestedEvent;

class ConfigFormFieldValueBasicLoadedEvent extends NestedEvent
{
    public const NAME = 'config_form_field_value.basic.loaded';

    /**
     * @var ShopContext
     */
    protected $context;

    /**
     * @var ConfigFormFieldValueBasicCollection
     */
    protected $configFormFieldValues;

    public function __construct(ConfigFormFieldValueBasicCollection $configFormFieldValues, ShopContext $context)
    {
        $this->context = $context;
        $this->configFormFieldValues = $configFormFieldValues;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getContext(): ShopContext
    {
        return $this->context;
    }

    public function getConfigFormFieldValues(): ConfigFormFieldValueBasicCollection
    {
        return $this->configFormFieldValues;
    }
}