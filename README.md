# ZohoCRMClient
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/christiaan/zohocrmclient/badges/quality-score.png?s=67d109ea323c9024fb43ff1c8a23a5b4c676dbce)](https://scrutinizer-ci.com/g/christiaan/zohocrmclient/)
[![Build Status](https://travis-ci.org/christiaan/zohocrmclient.png)](https://travis-ci.org/christiaan/zohocrmclient)

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

### Enabling logging

You can enable logging by adding the following line after instantiating the client:

```php
$client->setLogger($myPsrLogger);
```
The logger should implement the PSR `LoggerInterface`. If the transport being used implements `LoggerAwareInterface`, this call will chaing to set the logger for the transport as well. The build in transport supports this.

### Choosing a different Zoho realm

ZohoCRMClient will by default connect to the API at `crm.zoho.com`. If you wish to connect to a different one, you can supply the TLD as the third parameter to the constructor. For example, customer on the EU realm should instantiate the client like this:

``` php
$client = new ZohoCRMClient('Leads', 'yourAuthKey', 'eu');
```

### Using custom transport

If we wish, you can supply a custom transport class to ZohoCRMClient, as shown here:

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

## Implemented Calls
At the moment only the following calls are supported
- [getRecords](https://www.zoho.eu/crm/help/api/getrecords.html)
- [getRecordById](https://www.zoho.eu/crm/help/api/getrecordbyid.html) 
- [insertRecords](https://www.zoho.eu/crm/help/api/insertrecords.html)
- [updateRecords](https://www.zoho.eu/crm/help/api/updaterecords.html)
- [getFields](https://www.zoho.eu/crm/help/api/getfields.html)
- [searchResults](https://www.zoho.eu/crm/help/api/searchrecords.html)

It is rather easy to add new calls, look at one of the classes in the Request dir for examples.
After the Request class is made it might be necessary to alter the parsing of the response XML in the XmlDataTransportDecorator class.

## More examples

### insertRecords()

```php
use Christiaan\ZohoCRMClient\ZohoCRMClient;

$client = new ZohoCRMClient('Contacts', 'yourAuthKey');

$records = $client
            ->insertRecords()
            ->addRecord([
                'Email' => 'john@example.com',
                'First Name' => 'John'
            ])
            ->request();
```

Optionally, you can add `onDuplicateUpdate()` or `onDuplicateError()` to the chain, before `request()`, to instruct Zoho to either update or fail on duplicated records.
Duplicate checking depends on the module being targeted, see the list in the [Zoho documentation](https://www.zoho.eu/crm/help/api/insertrecords.html#Duplicate_Check_Fields).

The `$records` array will contain an entry for each record you have tried to create, which on success will contain the ID of the new (or updated) record.

### updateRecords()

```php
use Christiaan\ZohoCRMClient\ZohoCRMClient;

$client = new ZohoCRMClient('Contacts', 'yourAuthKey');

$records = $client
            ->updateRecords()
            ->addRecord([
                'Id' => '(ID returned from insert, search, ...)'
                'Last Name' => 'Smith'
            ])
            ->request();
```

Specifying the ID per record is necessary when updating multiple records. Alternatively, you may call `id()` to set the ID if you are only updating a single record. Setting the ID per record works in either case.

### searchResults()

```php
use Christiaan\ZohoCRMClient\ZohoCRMClient;

$client = new ZohoCRMClient('Contacts', 'yourAuthKey');

$records = $client
            ->searchRecords()
            ->criteria('Email:john@example.com')
            ->request();
```

See the [Zoho documentation](https://www.zoho.eu/crm/help/api/searchrecords.html) for the full explanation of how to write the criteria.
