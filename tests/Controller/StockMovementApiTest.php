<?php

declare(strict_types=1);

namespace Tests\Setono\SyliusStockMovementPlugin\Controller;

use ApiTestCase\JsonApiTestCase;
use Setono\SyliusStockMovementPlugin\Model\StockMovementInterface;
use Sylius\Component\Product\Model\ProductVariantInterface;
use Sylius\Tests\Controller\ProductApiTest;
use Symfony\Component\HttpFoundation\Response;

/**
 * TODO a test for PUT is missing @see ProductApiTest::it_allows_updating_product() for example
 * TODO a test for showing a product is missing @see ProductApiTest::it_allows_showing_product() for example
 */
final class StockMovementApiTest extends JsonApiTestCase
{
    /** @var array */
    private static $authorizedHeaderWithContentType = [
        'HTTP_Authorization' => 'Bearer SampleTokenNjZkNjY2MDEwMTAzMDkxMGE0OTlhYzU3NzYyMTE0ZGQ3ODcyMDAwM2EwMDZjNDI5NDlhMDdlMQ',
        'CONTENT_TYPE' => 'application/json',
    ];

    /** @var array */
    private static $authorizedHeaderWithAccept = [
        'HTTP_Authorization' => 'Bearer SampleTokenNjZkNjY2MDEwMTAzMDkxMGE0OTlhYzU3NzYyMTE0ZGQ3ODcyMDAwM2EwMDZjNDI5NDlhMDdlMQ',
        'ACCEPT' => 'application/json',
    ];

    /**
     * @test
     */
    public function it_does_not_allow_to_show_stock_movement_list_when_access_is_denied(): void
    {
        $this->loadFixturesFromFile('resources/stock_movements.yaml');
        $this->client->request('GET', '/api/v1/stock-movements/');

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'authentication/access_denied_response', Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @test
     */
    public function it_does_not_allow_to_show_stock_movement_when_it_does_not_exist(): void
    {
        $this->loadFixturesFromFile('authentication/api_administrator.yaml');

        $this->client->request('GET', '/api/v1/stock-movements/-1', [], [], static::$authorizedHeaderWithAccept);

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'error/not_found_response', Response::HTTP_NOT_FOUND);
    }

    /**
     * @test
     */
    public function it_allows_indexing_stock_movements(): void
    {
        $this->loadFixturesFromFile('authentication/api_administrator.yaml');
        $this->loadFixturesFromFile('resources/stock_movements.yaml');
        $this->loadFixturesFromFile('resources/many_stock_movements.yaml');

        $this->client->request('GET', '/api/v1/stock-movements/', [], [], static::$authorizedHeaderWithAccept);

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'stock_movement/index_response', Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function it_does_not_allow_delete_stock_movement_if_it_does_not_exist(): void
    {
        $this->loadFixturesFromFile('authentication/api_administrator.yaml');

        $this->client->request('DELETE', '/api/v1/products/-1', [], [], static::$authorizedHeaderWithAccept);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'error/not_found_response', Response::HTTP_NOT_FOUND);
    }

    /**
     * @test
     */
    public function it_allows_delete_stock_movement(): void
    {
        $this->loadFixturesFromFile('authentication/api_administrator.yaml');
        $stockMovements = $this->loadFixturesFromFile('resources/stock_movements.yaml');
        $stockMovement = $stockMovements['stockMovement1'];
        $stockMovementUrl = $this->getStockMovementUrl($stockMovement);

        $this->client->request('DELETE', $stockMovementUrl, [], [], static::$authorizedHeaderWithContentType);

        $response = $this->client->getResponse();
        $this->assertResponseCode($response, Response::HTTP_NO_CONTENT);

        $this->client->request('GET', $stockMovementUrl, [], [], static::$authorizedHeaderWithAccept);

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'error/not_found_response', Response::HTTP_NOT_FOUND);
    }

    /**
     * @test
     */
    public function it_does_not_allow_to_create_stock_movement_without_required_fields(): void
    {
        $this->loadFixturesFromFile('authentication/api_administrator.yaml');

        $this->client->request('POST', '/api/v1/stock-movements/', [], [], static::$authorizedHeaderWithContentType);

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'stock_movement/create_validation_fail_response', Response::HTTP_BAD_REQUEST);
    }

    /**
     * @test
     */
    public function it_allows_create_stock_movement(): void
    {
        $this->loadFixturesFromFile('authentication/api_administrator.yaml');
        $productVariants = $this->loadFixturesFromFile('../../../vendor/sylius/sylius/tests/DataFixtures/ORM/resources/product_variants.yml');

        /** @var ProductVariantInterface $productVariant */
        $productVariant = $productVariants['productVariant1'];
        $code = $productVariant->getCode();

        $data =
<<<EOT
        {
            "quantity": 1,
            "variant": "$code",
            "price": "EUR 100"
        }
EOT;

        $this->client->request('POST', '/api/v1/stock-movements/', [], [], static::$authorizedHeaderWithContentType, $data);

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'stock_movement/create_response', Response::HTTP_CREATED);
    }

    /**
     * @test
     */
    public function it_allows_updating_partial_information_about_stock_movement(): void
    {
        $this->loadFixturesFromFile('authentication/api_administrator.yaml');
        $stockMovements = $this->loadFixturesFromFile('resources/stock_movements.yaml');
        $stockMovement = $stockMovements['stockMovement1'];

        $data =
<<<EOT
        {
            "quantity": 2
        }
EOT;
        $this->client->request('PATCH', $this->getStockMovementUrl($stockMovement), [], [], static::$authorizedHeaderWithContentType, $data);
        $response = $this->client->getResponse();

        $this->assertResponseCode($response, Response::HTTP_NO_CONTENT);
    }

    /**
     * @test
     */
    public function it_allows_paginating_the_index_of_stock_movements(): void
    {
        $this->loadFixturesFromFile('authentication/api_administrator.yaml');
        $this->loadFixturesFromFile('resources/stock_movements.yaml');
        $this->loadFixturesFromFile('resources/many_stock_movements.yaml');

        $this->client->request('GET', '/api/v1/stock-movements/', ['page' => 2], [], static::$authorizedHeaderWithAccept);
        $response = $this->client->getResponse();
        $this->assertResponse($response, 'stock_movement/paginated_index_response');
    }

    private function getStockMovementUrl(StockMovementInterface $stockMovement): string
    {
        return '/api/v1/stock-movements/' . $stockMovement->getId();
    }
}
