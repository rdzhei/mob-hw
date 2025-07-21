<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\WeatherStation;
use App\DTO\WeatherStationIdName;
use App\Services\WeatherStationProviderInterface;
use App\Utils\Factories\ResponseFactoryInterface;
use OpenApi\Attributes\Get;
use OpenApi\Attributes\Items;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Parameter;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;

class WeatherStationController extends AbstractController
{

    public function __construct(
        private readonly WeatherStationProviderInterface $weatherStationProvider,
        private readonly ResponseFactoryInterface $responseFactory,
    ) {
    }

    #[Route(path: '/stations', name:'stations_index', methods: ['GET'])]
    #[Get(
        path: '/stations',
        summary: 'Get all weather station ids and names',
        responses: [
            new \OpenApi\Attributes\Response(
                response: 200,
                description: 'Success',
                content: new JsonContent(
                    type: 'object',
                    properties: [
                        new \OpenApi\Attributes\Property(property: 'success', type: 'boolean', default: false),
                        new \OpenApi\Attributes\Property(
                            property: 'data',
                            type: 'array',
                            items: new \OpenApi\Attributes\Items(ref: WeatherStationIdName::class)
                        ),
                    ],
                )
            ),
            new \OpenApi\Attributes\Response(
                response: 500,
                description: 'Error',
                content: new JsonContent(
                    type: 'object',
                    properties: [
                        new \OpenApi\Attributes\Property(property: 'success', type: 'boolean', default: false),
                        new \OpenApi\Attributes\Property(property: 'message', type: 'string',),
                    ],
                )
            )
        ]
    )]
    public function index(): Response
    {
        $weatherStationStructs = $this->weatherStationProvider->getAllWeatherStationIdNames();

        return $this->responseFactory->createSuccessfulDataResponse(
            data: $weatherStationStructs,
        );
    }

    #[Route(path: '/stations/{stationId}', name:'stations_show', methods: ['GET'])]
    #[Get(
        path: '/stations/{stationId}',
        summary: 'Get elaborate weather station data by id',
        parameters: [
            new Parameter(
                name: 'stationId',
                description: 'Weather station id',
                in: 'path',
                required: true,
                schema: new Schema(
                    type: 'string',
                    example: 'KALNCIEM'
                )
            )
        ],
        responses: [
            new \OpenApi\Attributes\Response(
                response: 200,
                description: 'Success',
                content: new JsonContent(
                    properties: [
                        new \OpenApi\Attributes\Property(property: 'success', type: 'boolean'),
                        new \OpenApi\Attributes\Property(
                            property: 'data',
                            ref: WeatherStation::class
                        ),
                    ],
                    type: 'object')
            ),
            new \OpenApi\Attributes\Response(
                response: 404,
                description: 'Weather station not found',
                content: new JsonContent(

                    properties: [
                        new \OpenApi\Attributes\Property(property: 'success', type: 'boolean'),
                        new \OpenApi\Attributes\Property(property: 'message', type: 'string',),
                    ],
                    type: 'object')
            ),
            new \OpenApi\Attributes\Response(
                response: 500,
                description: 'Error',
                content: new JsonContent(

                    properties: [
                        new \OpenApi\Attributes\Property(property: 'success', type: 'boolean'),
                        new \OpenApi\Attributes\Property(property: 'message', type: 'string',),
                    ],
                    type: 'object')
            )
        ]
    )]
    public function show(string $stationId): Response
    {
        $weatherStation = $this->weatherStationProvider->getWeatherStation($stationId);

        if (! $weatherStation) {
            throw new NotFoundHttpException(
                'Weather station not found',
                null,
                404
            );
        }

        return $this->responseFactory->createSuccessfulDataResponse(
            data: $weatherStation,
        );
    }
}
