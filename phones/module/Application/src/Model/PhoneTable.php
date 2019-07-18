<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;

class PhoneTable
{
    private $PhonesTableGateway;

    public function __construct(TableGateway $PhonesTableGateway)
    {
        $this->PhonesTableGateway = $PhonesTableGateway;
    }

    public function insertPhone($phoneId, $jsonData)
    {
        if (!$this->checkDbConnection()) {
            return false;
        }

        $insertFlag = $this->PhonesTableGateway->insert([
            'phone_id' => $phoneId,
            'json_data' => $jsonData
        ]);

        return $insertFlag;
    }

    public function fetchPhone($phoneId)
    {
        if (!$this->checkDbConnection()) {
            return false;
        }

        $select = $this->PhonesTableGateway->getSql()->select()
            ->where(['phone_id' => $phoneId]);
        $resultSet = $this->PhonesTableGateway->selectWith($select)->current();

        return $resultSet;
    }

    public function fetchPhones()
    {
        if (!$this->checkDbConnection()) {
            return false;
        }

        $select = $this->PhonesTableGateway->getSql()->select()
            ->columns(['json_data']);
        $resultSet = $this->PhonesTableGateway->selectWith($select);

        return $resultSet;
    }

    public function deletePhone($phoneId)
    {
        if (!$this->checkDbConnection()) {
            return false;
        }

        $deleteFlag = $this->PhonesTableGateway->delete([
            'phone_id' => $phoneId,
        ]);

        return $deleteFlag;
    }

    private function checkDbConnection()
    {
        try {
            $this->PhonesTableGateway->getAdapter()->getDriver()
                ->getConnection()->connect();
            return true;
        } catch (\Exception $e) {
            return false;
        }
        exit;
    }
}