<?php namespace Anomaly\Streams\Platform\Ui\Form;

/**
 * Class FormMessages
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form
 */
class FormMessages
{

    /**
     * Make custom validation messages.
     *
     * @param FormBuilder $builder
     * @return array
     */
    public function make(FormBuilder $builder)
    {
        $messages = [];

        foreach ($builder->getFormFields() as $field) {

            foreach ($field->getValidators() as $rule => $validator) {
                $messages[$rule] = trans(array_get($validator, 'message'));
            }

            foreach ($field->getMessages() as $rule => $message) {
                $messages[$rule] = trans($message);
            }
        }

        return $messages;
    }
}
