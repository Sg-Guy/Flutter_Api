<?php

namespace App;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: "1.0.0",
    title: "Shop API",
    description: "Documentation officielle de l'API Shop"
)]

#[OA\Server(
    url: "http://127.0.0.1:8000",
    description: "Serveur local"
)]

class OpenApi {}