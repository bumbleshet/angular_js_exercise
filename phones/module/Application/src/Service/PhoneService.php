<?php
namespace Application\Service;

class PhoneService
{
    public function getPhoneId($path)
    {
        $path = str_replace("./data/phones/", "", $path);
        $phoneId = str_replace(".json", "", $path);

        return $phoneId;
    }

    public function raiseResponseCode($response, $status_code)
    {
        $response->setStatusCode($status_code);
        return $response;
    }
}