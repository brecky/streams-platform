<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Field\Guesser;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class WarningsGuesser
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Field\Guesser
 */
class WarningsGuesser
{

    /**
     * Guess the field warnings.
     *
     * @param FormBuilder $builder
     */
    public function guess(FormBuilder $builder)
    {
        $fields = $builder->getFields();
        $stream = $builder->getFormStream();

        foreach ($fields as &$field) {

            $locale = array_get($field, 'locale');

            /**
             * If the warning is already set then use it.
             */
            if (isset($field['warning'])) {

                if (str_is('*::*', $field['warning'])) {
                    $field['warning'] = trans($field['warning'], [], null, $locale);
                }

                continue;
            }

            /**
             * If we don't have a field then we
             * can not really guess anything here.
             */
            if (!isset($field['field'])) {
                continue;
            }

            /**
             * No stream means we can't
             * really do much here.
             */
            if (!$stream || !$stream->getAssignment($field['field'])) {

                $warning = "module::field.{$field['field']}.warning";

                if (str_is('*::*', $warning) && trans()->has($warning)) {
                    $field['warning'] = trans($warning, [], null, $locale);
                }

                continue;
            }

            $assignment = $stream->getAssignment($field['field']);

            /**
             * No assignment means we still do
             * not have anything to do here.
             */
            if (!$assignment) {
                continue;
            }

            /**
             * Try using the assignment warning system.
             * This is generated but check for a field
             * specific variation first.
             */
            $warning = $assignment->getWarning() . '.' . $stream->getSlug();

            if (str_is('*::*', $warning) && trans()->has($warning, $locale)) {
                $field['warning'] = trans($warning, [], null, $locale);
            }

            /**
             * Next try using the fallback assignment
             * warning system as generated verbatim.
             */
            $warning = $assignment->getWarning() . '.default';

            if (!isset($field['warning']) && str_is('*::*', $warning) && trans()->has($warning, $locale)) {
                $field['warning'] = trans($warning, [], null, $locale);
            }

            /**
             * Next try using the default assignment
             * warning system as generated verbatim.
             */
            $warning = $assignment->getWarning();

            if (
                !isset($field['warning'])
                && str_is('*::*', $warning)
                && trans()->has($warning, $locale)
                && is_string($translated = trans($warning, [], null, $locale))
            ) {
                $field['warning'] = $translated;
            }

            /**
             * Lastly check if it's just a standard string.
             */
            if (!isset($field['warning']) && $warning && !str_is('*::*', $warning)) {
                $field['warning'] = $warning;
            }
        }

        $builder->setFields($fields);
    }
}
