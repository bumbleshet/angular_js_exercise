<?php
namespace Application\Model;

class Phone
{
    public function processPhoneDetails($phone)
    {
       $jsonData = json_decode($phone);
       $phoneDetails = get_object_vars($jsonData);

       return $phoneDetails;
    }

    public function processPhoneDataForJson($phones)
    {
        $phoneList = array();

        foreach ($phones as $phone) {
            $phoneDetails->age = json_decode($phone->json_data)->age;
            $phoneDetails->id = json_decode($phone->json_data)->id;
            $phoneDetails->imageUrl = json_decode($phone->json_data)->imageUrl;
            $phoneDetails->name = json_decode($phone->json_data)->name;
            $phoneDetails->snippet = json_decode($phone->json_data)->snippet;
            $phoneList[] = get_object_vars($phoneDetails);
        }

        return $phoneList;
    }
}