<?php
namespace Application\Filter;

use Application\Controller\Rest\PhoneController;
use Zend\InputFilter\InputFilter;
use Zend\Validator\NotEmpty;


class PhoneFilter extends InputFilter
{
    public function __construct()
    {
        $this->add(array(
            'name' => 'phoneId',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            NotEmpty::IS_EMPTY => 'Phone Id is required.',
                        ),
                    ),
                ),
            ),
        ));

        $this->add(array(
            'name' => 'jsonData',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            NotEmpty::IS_EMPTY => 'JSON data is required',
                        ),
                    ),
                ),
            ),
        ));
    }

    /**
     * @param $data
     * @param string $validationGroup|array
     * @return array|bool
     */
    public function validateAndSanitize($data, $validationGroup = self::VALIDATE_ALL) {
        $this->setData($data);
        $this->setValidationGroup($validationGroup);

        if ($this->isValid()) {
            return $this->getValues();
        } else {
            return false;
        }
    }

    /**
     * @param $data
     * @param PhoneController $PhoneController
     * @return array|\Zend\Stdlib\ResponseInterface
     */
    public function validateProcess($data, PhoneController $PhoneController)
    {
        if (!$data) {
            return $PhoneController->notFoundAction();
        } elseif ($data === 'dbError') {
            $response = $PhoneController->getResponse();
            $response->setStatusCode(500); // Internal Error

            return $response;
        }
    }
}
