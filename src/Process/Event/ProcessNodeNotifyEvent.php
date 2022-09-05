<?php

namespace NoLoCo\Core\Process\Event;

use NoLoCo\Core\Process\Context\ContextInterface;
use NoLoCo\Core\Process\NodeCode\NodeCodeInterface;
use Symfony\Contracts\EventDispatcher\Event;

class ProcessNodeNotifyEvent extends Event
{
    /**
     * The node dispatching the event.
     * @var NodeCodeInterface
     */
    protected NodeCodeInterface $node;


    /**
     * @var ContextInterface
     */
    protected ContextInterface $context;

    /**
     * Information about the node
     * @var string
     */
    protected string $notice = '';

    /**
     * @return NodeCodeInterface
     */
    public function getNode(): NodeCodeInterface
    {
        return $this->node;
    }

    /**
     * @param NodeCodeInterface $node
     * @return ProcessNodeNotifyEvent
     */
    public function setNode(NodeCodeInterface $node): ProcessNodeNotifyEvent
    {
        $this->node = $node;
        return $this;
    }

    /**
     * @return string
     */
    public function getNotice(): string
    {
        return $this->notice;
    }

    /**
     * @param string $notice
     * @return ProcessNodeNotifyEvent
     */
    public function setNotice(string $notice): ProcessNodeNotifyEvent
    {
        $this->notice = $notice;
        return $this;
    }

    /**
     * @return ContextInterface
     */
    public function getContext(): ContextInterface
    {
        return $this->context;
    }

    /**
     * @param ContextInterface $context
     * @return ProcessNodeNotifyEvent
     */
    public function setContext(ContextInterface $context): ProcessNodeNotifyEvent
    {
        $this->context = $context;
        return $this;
    }
}
