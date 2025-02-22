# Fakturownia.pl Rest Client

Dokumentacja API serwisu Fakturownia.pl znajduje się [tutaj](https://app.fakturownia.pl/api).

## Instalacja

Aby skorzystać z biblioteki wystarczy dodać wpis do composer.json:
```json
{
    "require": {
        "agsystemspl/fakturownia-rest-client": "dev-master",
    },
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/agsystemspl/fakturownia-rest-client"
        }
    ]
}
```

## Korzysztnie

### Inicjalizacja

```php
use AGSystems\Fakturownia\REST\Client as ClientService;

$service = new ClientService($accessToken, $fakturowniaUrl);
```

### Zarządzenie klientami

```php
// Wszyscy klienci

$clientData = $this->clients->get([ ... ])
# Ex. ["page" => 1, "per_page" => 10]
echo $clientData->id;

// Pobranie wybranego klienta po ID

$clientId = 63727;
$clientData = $this->{"clients/$clientId"}->get()
echo $clientData->id;

// Dodanie klienta

$clientData = $service->clients->post([ ... ]);
echo $clientData->id;

// Aktualizacja klienta po ID

$clientId = 63727;
$clientData = $this->{"clients/$clientId"}->put([ ... ]);
echo $clientData->id;
```

### Zarządzenie fakturami i innymi zasobami

Podobnie jak klientami, zmienia się tylko ścieżka z `clients` np. np. `invoices`