<?php
declare (strict_types=1);

namespace Project\View;

class JsonModel
{
    protected $jsonConfig = [];

    public function __construct()
    {
        $this->initJsonConfig();
    }

    protected function initJsonConfig(): void
    {
        $this->jsonConfig['status'] = 'error';
    }

    public function addJsonConfig(string $name, $entry): void
    {
        $this->jsonConfig[$name] = $entry;
    }

    public function send(string $status = 'success'): void
    {
        $this->jsonConfig['status'] = $status;

        echo json_encode($this->jsonConfig);
    }
}