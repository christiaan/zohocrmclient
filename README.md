# ZohoCRMClient

Provides a clean readable PHP API to the [Zoho Rest API](https://www.zoho.com/crm/help/api/).

## Usage
```php
use Christiaan\ZohoCRMClient\ZohoCRMClient;

$client = new ZohoCRMClient('Leads', 'yourAuthKey');

$records = $client->getRecords()
    ->selectColumns('First Name', 'Last Name', 'Email')
    ->sortBy('Last Name')->sortAsc()
    ->since(date_create('last week'))
    ->request();

echo 'Content: ' . print_r($records, true) . PHP_EOL;

```

## Using custom transport settings to enable logging
```php
$buzzTransport = new BuzzTransport(
    new \Buzz\Browser(new \Buzz\Client\Curl()),
    'https://crm.zoho.com/crm/private/xml/'
);
$buzzTransport->setLogger($logger);

$transport = new XmlDataTransportDecorator(
    new AuthenticationTokenTransportDecorator(
        'yourAuthKey',
        $buzzTransport
    )
);

$client = new ZohoCRMClient('Leads', $transport);
```
