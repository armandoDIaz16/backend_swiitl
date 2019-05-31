<?php
/**
 * Created by PhpStorm.
 * User: deborahlev
 * Date: 8/04/19
 * Time: 09:35 AM
 */

namespace App;


class Respuesta
{

    public $estado;
    public $http_code;
    public $message;
    public $data;

    public function __construct($estado = 'OK', $http_code = 200, $message = "", $data = []){
        $this->estado        = $estado;
        $this->http_code     = $http_code;
        $this->message       = $message;
        $this->data          = $data;
    }

    /**
     * @return string
     */
    public function getEstado(): string
    {
        return $this->estado;
    }

    /**
     * @param string $estado
     */
    public function setEstado(string $estado): void
    {
        $this->estado = $estado;
    }

    /**
     * @return int
     */
    public function getHttpCode(): int
    {
        return $this->http_code;
    }

    /**
     * @param int $http_code
     */
    public function setHttpCode(int $http_code): void
    {
        $this->http_code = $http_code;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }
}
