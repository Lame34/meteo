<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class WeatherController extends AbstractController
{
    public function __construct(
        #[Autowire('%env(OPEN_WEATHER_API_KEY)%')]
        private readonly string $openWeatherApiKey,
    ) {
    }

    #[Route('/', name: 'app_weather_home')]
    public function index(): Response
    {
        return $this->render('weather/index.html.twig');
    }

    #[Route('/api/weather/{city}', name: 'api_weather', methods: ['GET'])]
    public function getWeather(string $city, HttpClientInterface $client): JsonResponse
    {
        $apiKey = $this->openWeatherApiKey;

        try {
            $response = $client->request(
                'GET',
                "https://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$apiKey}&units=metric&lang=fr"
            );

            $data = $response->toArray();

            return $this->json($data);
        } catch (\Exception $e) {
            return $this->json(['error' => 'Ville introuvable'], 404);
        }
    }
}
