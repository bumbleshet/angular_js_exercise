<?php
namespace Application\Controller\Rest;

use Application\Model\Phone;
use Application\Model\PhoneTable;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class PhoneController extends AbstractRestfulController
{
    private $PhoneTable;
    private $Phone;


    public function __construct(PhoneTable $PhoneTable, Phone $Phone)
    {
        $this->PhoneTable = $PhoneTable;
        $this->Phone = $Phone;
    }

    /**
     * get phone details
     *
     * @param mixed $phoneId
     * @return mixed|JsonModel
     */
    public function get($phoneId)
    {
        $jsonData = $this->PhoneTable->fetchPhone($phoneId)->json_data;

        if (!$jsonData) {
            $this->notFoundAction();
        }

        $phoneDetails = $this->Phone->processPhoneDetails($jsonData);

        return new JsonModel($phoneDetails);
    }

    /**
     * get phone list
     *
     * @return mixed|JsonModel
     */
    public function getList()
    {
        $rawPhoneList = $this->PhoneTable->fetchPhones();

        if (!$rawPhoneList) {
            $this->notFoundAction();
        }

        $phoneList = $this->Phone->processPhoneDataForJson($rawPhoneList);

        return new JsonModel($phoneList);
    }

    /**
     * insert phone
     *
     * @param mixed $data
     * @return array|mixed
     */
    public function create($jsonData)
    {
        $insertFlag = $this->PhoneTable->insertPhone($phoneId, $jsonData);

        if (!$insertFlag) {
            $this->notFoundAction();
        }
    }

    /**
     * delete phone
     *
     * @param mixed $phoneId
     * @return mixed|void
     */
    public function delete($phoneId)
    {
        $deleteFlag = $this->PhoneTable->deletePhone($phoneId);

        if (!$deleteFlag) {
            $this->notFoundAction();
        }
    }
}