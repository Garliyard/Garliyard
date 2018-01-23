<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JsonRpcController extends Controller
{
    public $base_url;
    public $curl_instance;
    private $pending_data;
    private $data_template = [
        "jsonrpc" => "1.0",
        "method" => "",
        "params" => [],
        "id" => 1
    ];

    /**
     * Build a new request.
     *
     * @return array
     */
    public function newRequest()
    {
        $this->pending_data = $this->data_template;
        return $this->pending_data;
    }

    /**
     * Set Method
     *
     * Set the method of the pending data.
     *
     * @param string $method
     * @return array
     */
    public function setMethod(string $method): array
    {
        $this->pending_data["method"] = $method;
        return $this->pending_data;
    }

    /**
     * Set Parameters
     *
     * Set parameters of the pending data.
     *
     * @param array $parameters
     * @return mixed
     */
    public function setParameters(array $parameters = [])
    {
        $this->pending_data["params"] = $parameters;
        return $this->pending_data;
    }

    /**
     * New Curl Instance
     *
     * Create a new CURL Instance.
     */
    public function newCurlInstance()
    {
        $this->curl_instance = curl_init();
        curl_setopt($this->curl_instance, CURLOPT_POST, 1);
        curl_setopt($this->curl_instance, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl_instance, CURLOPT_POSTFIELDS, json_encode($this->pending_data));
        return $this->curl_instance;
    }

    /**
     * Post to server
     *
     * @return array
     */
    public function post(): array
    {
        curl_setopt($this->curl_instance, CURLOPT_URL, $this->base_url);
        $result = json_decode(curl_exec($this->curl_instance), true);
        curl_close($this->curl_instance);
        return $result;
    }
}
