<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JsonRpcController extends Controller
{
    private $base_url;
    private $curl_instance;
    private $pending_data;
    private $data_template = [
        "method" => "",
        "params" => []
    ];

    public function __construct()
    {
        $this->base_url = sprintf(
            "http://%s:%s@%s:%s/",
            config("app.rpc_username", "garlicoind"),
            config("app.rpc_password", "garlicoind"),
            config("app.rpc_host", "127.0.0.1"),
            config("app.rpc_port", 42070)
        );
    }

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
        curl_setopt($this->curl_instance, CURLOPT_POST, count($this->pending_data));
        curl_setopt($this->curl_instance, CURLOPT_POSTFIELDS, json_encode($this->pending_data));
        curl_setopt($this->curl_instance, CURLOPT_RETURNTRANSFER, true);
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
