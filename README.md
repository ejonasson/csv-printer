# CSV Printer

I kept forgetting the PHP syntax for CSVs, so I made a small service class that makes the process a bit simpler for reading and printing a file.

## Usage

1. Create an array of data, like this:
```
    $data = [
        [
            'firstName' => 'Erik',
            'lastName' => 'Jonasson',
            'emailAddress' => 'ejonasson@gmail.com'
        ],
        [
            'firstName' => 'Someone',
            'lastName' => 'Else',
            'emailAddress' => 'someone@example.com',
        ],
        [
            'firstName' => 'Foo',
            'lastName' => 'Bar',
            'emailAddress' => 'foobar@example.com'
        ]
    ];
```
2. Parse it with the CSV builder
```
$builder = CSVPrinter::fromArray($data);
```
3. Either store it in memory and receive the filename back, or download it right away
```
// Get the file path back, to read/use elsewhere
$filePath = $builder->toMemory('Example.csv');

// Or just download it right away
$builder->download('Example.csv');
```

### Omitting Items from CSV
By Default, every row in the accepted array will be printed in the CSV. To specify specific column headers, pass an array of the headers you would like to include:

```
$builder->setHeaders(['firstName', 'lastName'])->download(); // Will Only download firstName and lastName columns
```

To drop a single header, you can use `omitHeader` to pass a single header

```
$builder->omitHeader('firstName')->download() // Will download all columns except 'firstName'
```
