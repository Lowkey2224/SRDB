<?php
/**
 * Created by Marcus "Loki" Jenz 
 * Date: 08.03.14
 * Time: 18:40
 */

namespace Loki\CharacterBundle\Service\ErrorHandler;

use Symfony\Component\Form\Form;

class Service {

    /**
     * Extracts all error messages from a given form
     * @param Form $form The form where error messages are to be extracted
     * @return array returns an array with all error messages,
     *      returns an empty array if no messages had been extracted
     */
    public function getErrorMessages(Form $form)
    {
        $errors = array();
        foreach ($form->getErrors() as $error) {
            $errors[] = $error->getMessage();
        }

        return $errors;
    }

}