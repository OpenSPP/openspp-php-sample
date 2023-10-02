<?php

namespace OpenSPP\Odoo;

use Laminas\Http\Client as HttpClient;
use Laminas\XmlRpc\Client as XmlRpcClient;

class OdooReader
{
    protected $host;
    protected $uid = null;
    protected $user;
    protected $database;
    protected $password;
    protected $client;
    protected $path;
    protected $httpClient;

    public function __construct(
        string $host,
        string $database,
        string $user,
        string $password,
        ?HttpClient $httpClient = null
    ) {
        $this->host = $host;
        $this->database = $database;
        $this->user = $user;
        $this->password = $password;
        $this->httpClient = $httpClient;
    }

    protected function getClient(?string $path = null): XmlRpcClient
    {
        if ($path === null) {
            return $this->client;
        }

        if ($this->path === $path) {
            return $this->client;
        }

        $this->path = $path;
        $this->client = new XmlRpcClient($this->host . '/' . $path, $this->httpClient);
        $this->client->setSkipSystemLookup(true);

        return $this->client;
    }

    protected function uid(): ?int
    {
        if ($this->uid === null) {
            $client = $this->getClient('common');
            $response = $client->call('login', [
                $this->database,
                $this->user,
                $this->password
            ]);

            $this->uid = is_int($response) ? $response : null;
        }

        return $this->uid;
    }

    protected function buildParams(array $params): array
    {
        return array_merge([
            $this->database,
            $this->uid(),
            $this->password
        ], $params);
    }

    public function read(string $model, array $ids, array $fields = []): array
    {
        $params = $this->buildParams([
            $model,
            'read',
            $ids,
            $fields
        ]);

        $response = $this->getClient('object')->call('execute', $params);

        return is_array($response) ? $response : [];
    }

    public function searchRead(
        string $model,
        array $data = [],
        array $fields = [],
        int $offset = 0,
        int $limit = 100
    ): array {
        $params = $this->buildParams([
            $model,
            'search_read',
            $data,
            $fields,
            $offset,
            $limit
        ]);

        $response = $this->getClient('object')->call('execute', $params);

        return is_array($response) ? $response : [];
    }

    public function version(): array
    {
        $response = $this->getClient('common')->call('version');

        return is_array($response) ? $response : [];
    }
}
