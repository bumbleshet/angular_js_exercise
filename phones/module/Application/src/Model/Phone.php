<?php
namespace Application\Model;

class Phone
{
    /**
     * decoded as object stdClass
     * get_object_vars is used for solution
     *
     * @param $phone
     * @return array
     */
    public function decodeJsonDataFromDb($phone)
    {
       $jsonData = json_decode($phone);
       $phoneDetails = get_object_vars($jsonData);

       return $phoneDetails;
    }

    /**
     * receives phones jsonData
     * select properties from jsonData
     *
     * @param $phones
     * @return array
     */
    public function transformPhonesJsonDataToList($phones)
    {
        $phoneList = array();

        foreach ($phones as $phone) {
            $phoneDetails = null;
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