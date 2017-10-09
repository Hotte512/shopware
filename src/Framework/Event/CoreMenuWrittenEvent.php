<?php declare(strict_types=1);

namespace Shopware\Framework\Event;

use Shopware\Context\Struct\TranslationContext;

class CoreMenuWrittenEvent extends NestedEvent
{
    const NAME = 'core_menu.written';

    /**
     * @var string[]
     */
    protected $coreMenuUuids;

    /**
     * @var NestedEventCollection
     */
    protected $events;

    /**
     * @var array
     */
    protected $errors;

    /**
     * @var TranslationContext
     */
    protected $context;

    public function __construct(array $coreMenuUuids, TranslationContext $context, array $errors = [])
    {
        $this->coreMenuUuids = $coreMenuUuids;
        $this->events = new NestedEventCollection();
        $this->context = $context;
        $this->errors = $errors;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getContext(): TranslationContext
    {
        return $this->context;
    }

    /**
     * @return string[]
     */
    public function getCoreMenuUuids(): array
    {
        return $this->coreMenuUuids;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function hasErrors(): bool
    {
        return count($this->errors) > 0;
    }

    public function addEvent(NestedEvent $event): void
    {
        $this->events->add($event);
    }

    public function getEvents(): NestedEventCollection
    {
        return $this->events;
    }
}