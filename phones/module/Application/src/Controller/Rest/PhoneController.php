<?php
namespace Application\Controller\Rest;

use Application\Filter\PhoneFilter;
use Application\Model\Phone;
use Application\Model\PhoneTable;
use Application\Service\PhoneService;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class PhoneController extends AbstractRestfulController
{
    private $collectionOptions = array('GET', 'POST');
    private $resourceOptions = array('DELETE', 'GET', 'PUT');
    private $PhoneTable;
    private $Phone;
    private $PhoneService;
    private $PhoneFilter;


    // try catch and error handling
    // NAMING NAMING NAMING
    public function __construct(
        PhoneTable $PhoneTable,
        Phone $Phone,
        PhoneService $PhoneService,
        PhoneFilter $PhoneFilter
    )
    {
        $this->PhoneTable = $PhoneTable;
        $this->Phone = $Phone;
        $this->PhoneService = $PhoneService;
        $this->PhoneFilter = $PhoneFilter;
    }

    /**
     * get phone details
     *
     * @param mixed $phoneId
     * @return mixed|JsonModel
     */
    public function get($phoneId)
    {
        $phoneId = $this->PhoneFilter->validateAndSanitize(
            ['phoneId' => $phoneId], ['phoneId'])['phoneId'];
        if (!$phoneId) {
            return $this->PhoneService
                ->raiseResponseCode($this->getResponse(), 451);
        }

        $jsonData = $this->PhoneTable->fetchPhone($phoneId)->json_data;

        $error = $this->PhoneFilter->validateProcess($jsonData, $this);
        if ($error) {
           return $error;
        }

        $phoneDetails = $this->Phone->decodeJsonDataFromDb($jsonData);

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

        $error = $this->PhoneFilter->validateProcess($rawPhoneList, $this);
        if ($error) {
            return $error;
        }

        $phoneList = $this->Phone
            ->transformPhonesJsonDataToList($rawPhoneList);

        return new JsonModel($phoneList);
    }


    /**
     * insert phones
     *
     * @param mixed $data
     * @return mixed
     */
    public function create($data)
    {
        $data = $this->PhoneFilter->validateAndSanitize($data);
        if (!$data) {
            return $this->PhoneService
                ->raiseResponseCode($this->getResponse(), 451);
        }

        $phoneId = $data['phoneId'];
        $jsonData = json_encode($data['jsonData']);
        $insertFlag = $this->PhoneTable->insertPhone($phoneId, $jsonData);

        $error = $this->PhoneFilter->validateProcess($insertFlag, $this);
        if ($error) {
            return $error;
        }

        return $this->PhoneService
            ->raiseResponseCode($this->getResponse(), 201);
    }

    /**
     * update phone
     *
     * @param mixed $id
     * @param mixed $data
     * @return mixed
     */
    public function update($id, $data)
    {
        $data = ['phoneId' => $id,
            'jsonData' => json_encode($data['jsonData'])];
        $data = $this->PhoneFilter->validateAndSanitize($data);
        if (!$data) {
            return $this->PhoneService
                ->raiseResponseCode($this->getResponse(), 451);
        }

        $updateFlag = $this->PhoneTable->updatePhone($data['phoneId'],
            ['json_data' => json_encode($data['jsonData'])]);

        if (!$updateFlag) {
            $this->notFoundAction();
        }

        $error = $this->PhoneFilter->validateProcess($updateFlag, $this);
        if ($error) {
            return $error;
        }

        return $this->PhoneService
            ->raiseResponseCode($this->getResponse(), 202);
    }

    /**
     * delete phone
     *
     * @param mixed $phoneId
     * @return mixed
     */
    public function delete($phoneId)
    {
        $data = ['phoneId' => $phoneId];
        $phoneId = $this->PhoneFilter
            ->validateAndSanitize($data,['phoneId'])['phoneId'];
        if (!$phoneId) {
            return $this->PhoneService
                ->raiseResponseCode($this->getResponse(), 451);
        }

        $deleteFlag = $this->PhoneTable->deletePhone($phoneId);

        $error = $this->PhoneFilter->validateProcess($deleteFlag, $this);
        if ($error) {
            return $error;
        }

        return $this->PhoneService
            ->raiseResponseCode($this->getResponse(), 204);
    }

    /**
     * client options
     *
     * @return mixed|\Zend\Stdlib\ResponseInterface
     */
    public function options()
    {
        if ($this->params->fromRoute('id', false)) {
            $options = $this->resourceOptions;
        } else {
            $options = $this->collectionOptions;
        }
        $response = $this->getResponse();
        $response->getHeaders()
            ->addHeaderLine('Allow', implode(',', $options));
        return $response;
    }

    /**
     * check client option
     *
     * @param $e
     * @return void|\Zend\Stdlib\ResponseInterface
     */
    public function checkOptions($e)
    {
        if ($this->params->fromRoute('id', false)) {
            $options = $this->resourceOptions;
        } else {
            $options = $this->collectionOptions;
        }
        if (in_array($e->getRequest()->getMethod(), $options)) {
            // HTTP method is allowed!
            return;
        }
        $response = $this->getResponse();
        $response->setStatusCode(405); // Method Not Allowed
        return $response;
    }
}