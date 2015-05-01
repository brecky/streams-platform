<?php namespace Anomaly\Streams\Platform\Field\Form\Command;

use Anomaly\Streams\Platform\Field\FieldManager;
use Anomaly\Streams\Platform\Field\Form\FieldFormBuilder;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class AutoAssignField
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Field\Form\Command
 */
class AutoAssignField implements SelfHandling
{

    /**
     * The field form builder.
     *
     * @var FieldFormBuilder
     */
    protected $builder;

    /**
     * Create a new AutoAssignField instance.
     *
     * @param FieldFormBuilder $builder
     */
    public function __construct(FieldFormBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Handle the command.
     *
     * @param FieldManager $manager
     */
    public function handle(FieldManager $manager)
    {
        if ($this->builder->getFormOption('auto_assign') === true && $this->builder->getFormMode() === 'create') {
            $manager->assign($this->builder->getFormEntry(), $this->builder->getStream());
        }
    }
}