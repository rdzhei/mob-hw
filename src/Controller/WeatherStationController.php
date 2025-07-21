<?php

declare(strict_types=1);

namespace App\Controller;

use App\Services\WeatherStationProviderInterface;
use App\Utils\Factories\ResponseFactoryInterface;
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
    public function index(): Response
    {
        $weatherStationStructs = $this->weatherStationProvider->getAllWeatherStationIdNames();

        return $this->responseFactory->createSuccessfulDataResponse(
            data: $weatherStationStructs,
        );
    }

    #[Route(path: '/stations/{stationId}', name:'stations_show', methods: ['GET'])]
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
