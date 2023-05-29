<?php

namespace web\Core\Http;

class Request {
    public function getQueryParams()
    {
        return $_GET;
    }
    public function getParsedBody()
    {
        return $_POST ?: null;
    }
}
