<?php

class MagentoAPI
{

    protected $_magentoBaseUrl = 'http://m2geekhub.com/';

    protected $_magentoApiController = 'index.php/rest/V1/';

    protected $_token;
    protected $_message;

    function MagentoAPI($apiUsername, $apiPassword)
    {
        if (!$apiUsername || !$apiPassword) {
            return $this;
        }

        $authUrl = $this->_magentoBaseUrl . $this->_magentoApiController . 'integration/admin/token';
        $data = array(
            "username" => $apiUsername,
            "password" => $apiPassword
        );

        $data_string = json_encode($data);
        $ch = curl_init($authUrl);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
        );

        $response = curl_exec($ch);
        $response = json_decode($response);

        if (is_string($response)) {
            $this->_token = $response;
        } elseif (is_object($response)) {
            $this->_message = $response->message;
        }

        return $this;
    }

    public function getMessage()
    {
        return $this->_message;
    }

    public function getAllSampleRequests()
    {
        if (!$this->_token) {
            return false;
        }

        $headers = array("Authorization: Bearer $this->_token");

        $searchCriteria = [
            'searchCriteria' => [
                'sortOrders' => [
                    0 => [
                        'field'     => 'created_at',
                        'direction' => 'DESC',
                    ]
                ],
                'currentPage' => 1
            ]
        ];

        $searchCriteriaQuery = http_build_query($searchCriteria);

        $requestUrl = $this->_magentoBaseUrl . $this->_magentoApiController . 'requestSample/search?'.$searchCriteriaQuery;
        var_dump($requestUrl);

        $ch = curl_init($requestUrl);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        $result = json_decode($result);

        return $result->items;
    }

    public function getSampleRequest($requestSampleId)
    {
        if (!$this->_token) {
            return false;
        }

        $headers = array("Authorization: Bearer $this->_token");

        $requestUrl = $this->_magentoBaseUrl . $this->_magentoApiController . 'requestSample/'.$requestSampleId;

        var_dump($requestUrl);

        $ch = curl_init($requestUrl);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        $result = json_decode($result);

        return $result;
    }

    public function saveSampleRequest($requestSample)
    {
        if (!$this->_token) {
            return false;
        }

        $requestUrl = $this->_magentoBaseUrl . $this->_magentoApiController . 'requestSample';

        if ($requestSample->id) {
            $requestUrl .= '/'.$requestSample->id;
        }
        var_dump($requestUrl);

        $data_string = json_encode(
            ['requestSample' => $requestSample]
        );

        $headers = array(
            "Authorization: Bearer $this->_token",
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string)
        );

        $ch = curl_init($requestUrl);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        $response = json_decode($response);

        return $response;
    }
}

$magento = new MagentoAPI('admin', 'admin123');

$sampleRequest = $magento->getSampleRequest(1);
var_dump($sampleRequest);

unset($sampleRequest->created_at);
$sampleRequest->product_name .= ' (CHANGED)';
var_dump($magento->saveSampleRequest($sampleRequest));

var_dump($magento->getSampleRequest(1));

var_dump($magento->getAllSampleRequests());



