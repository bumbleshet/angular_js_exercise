<?php
namespace Application\Controller;

use Application\Model\PhoneTable;
use Application\Service\PhoneService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    private $PhoneTable;
    private $PhoneService;

    public function __construct (
        PhoneTable $PhoneTable,
        PhoneService $PhoneService
    )
    {
        $this->PhoneTable = $PhoneTable;
        $this->PhoneService = $PhoneService;
    }

    public function indexAction()
    {
        return new ViewModel();
    }

    public function insertPhonesToDbAction()
    {
        $phonesPath = glob("./data/phones/*");
        foreach($phonesPath as $phonePath) {
            $jsonData = file_get_contents($phonePath);
            $phoneId = $this->PhoneService->getPhoneId($phonePath);
            $insertFlag = $this->PhoneTable->insertPhone($phoneId, $jsonData);
            $message = $insertFlag ? "success" : "failed";
            \Zend\Debug\Debug::dump($message);
        }
            exit;
    }
}
