<?php

declare(strict_types=1);

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Framework\Controller\AbstractController;

class HomeController extends AbstractController
{
    private const ROUTES = [
        ["name" => "Lemmerweg", "minutes" => 25],
        ["name" => "Stationsstraat", "minutes" => 15],
        ["name" => "Rondweg Noord", "minutes" => 30],
        ["name" => "Prins Hendrikkade", "minutes" => 20],
    ];

    public function index(ServerRequestInterface $request): ResponseInterface
    {
        $query = $request->getQueryParams();
        $temperature = isset($query["temperature"]) && $query["temperature"] !== ""
            ? (float) $query["temperature"]
            : null;

        $frequency = $temperature !== null
            ? $this->calculateFrequency($temperature)
            : null;

        $items = [];
        $totalMinutes = 0;

        if ($frequency !== null) {
            foreach (self::ROUTES as $route) {
                $calculated = $route["minutes"] * $frequency;
                $totalMinutes += $calculated;
                $items[] = [
                    "name" => $route["name"],
                    "baseMinutes" => $route["minutes"],
                    "totalMinutes" => $calculated,
                ];
            }
        }

        $trucksNeeded = $totalMinutes > 0
            ? (int) ceil($totalMinutes / 480)
            : 0;

        return $this->render("home/index", [
            "temperature" => $temperature,
            "frequency" => $frequency,
            "items" => $items,
            "totalMinutes" => $totalMinutes,
            "trucksNeeded" => $trucksNeeded,
        ]);
    }

    private function calculateFrequency(float $temperature): int
    {
        if ($temperature >= 1) {
            return 1;
        }

        if ($temperature >= 0) {
            return 2;
        }

        return 3;
    }
}
