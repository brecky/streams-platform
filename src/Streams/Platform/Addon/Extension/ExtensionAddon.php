<?php namespace Streams\Platform\Addon\Extension;

use Streams\Platform\Addon\Addon;
use Streams\Platform\Contract\PresentableInterface;

class ExtensionAddon extends Addon implements PresentableInterface
{
    protected $type = 'extension';

    public function newPresenter()
    {
        return new ExtensionPresenter($this);
    }
}
