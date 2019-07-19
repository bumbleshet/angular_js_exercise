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

    /**
     * @param $phoneId
     * @param $jsonData
     * @return bool|int
     */
    public function insertPhone($phoneId, $jsonData)
    {
        if (!$this->checkDbConnection()) {
            return false;
        }

        $successFlag = $this->PhonesTableGateway->insert([
            'phone_id' => $phoneId,
            'json_data' => $jsonData
        ]);

        return $successFlag;
    }

    /**
     * @param $phoneId
     * @param $jsonData
     * @return bool|int
     */
    public function updatePhone($phoneId, $jsonData)
    {
        if (!$this->checkDbConnection()) {
            return false;
        }

        $where = array('phone_id' => $phoneId);
        $successFlag = $this->PhonesTableGateway->update($jsonData, $where);

        return $successFlag;
    }

    /**
     * @param $phoneId
     * @return bool|int
     */
    public function deletePhone($phoneId)
    {
        if (!$this->checkDbConnection()) {
            return false;
        }

        $successFlag = $this->PhonesTableGateway->delete(['phone_id' => $phoneId]);

        return $successFlag;
    }

    /**
     * @param $phoneId
     * @return string|\Zend\Db\ResultSet\ResultSetInterface
     */
    public function fetchPhone($phoneId)
    {
        if (!$this->checkDbConnection()) {
            return 'dbError';
        }

        $select = $this->PhonesTableGateway->getSql()->select()
            ->where(['phone_id' => $phoneId]);
        $ResultSet = $this->PhonesTableGateway->selectWith($select)->current();

        return $ResultSet;
    }

    /**
     * @return string|\Zend\Db\ResultSet\ResultSetInterface
     */
    public function fetchPhones()
    {
        if (!$this->checkDbConnection()) {
            return 'dbError';
        }

        $select = $this->PhonesTableGateway->getSql()->select()
            ->columns(['json_data']);
        $ResultSet = $this->PhonesTableGateway->selectWith($select);

        return $ResultSet;
    }

    /**
     * @return bool
     */
    private function checkDbConnection()
    {
        try {
            $this->PhonesTableGateway->getAdapter()->getDriver()
                ->getConnection()->connect();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}