# geocoding
GEOCODING
## Configuration

- Set to composer.json file next:
```
"repositories": [
        {
            "type": "git",
            "url": "https://github.com/sirko1990/geocoding.git"
        }
    ],
```    

- Set into require section of coposer.json next lines
  ```
  "sirko1990/geocoding": "0.0.4"
  ```

- Add Geocoding service container to config/app.php (providers section)
 ```
 Geocoding\GeocodongServiceProvider::class,
 ```
 
- if you want t use Geocoding service as Facade, then you can add new line to confing/app.php (aliases section)
 ```
 Geocoding' => Geocoding\GeocodingFacade::class
 ```

- End last you need to run next command for move Geocoding confing to app's config path
```
$ php artisan vendor:publish
```
 - Also you need add Api key to your env file

```
GEOCODING=AIzaSyBa40UZqziiMWFJtAUp9m5Ux4k0ON5A9g8
```

##Example
```
 $response = app('geocoding')->setLanguage('ja')->addressToСoordinates('1600 Amphitheatre Parkway, Mountain View, CA');

 //As Facade
 $response = \Geocoding::setLanguage('ja')->coordinatesToAddress('40.714224,-73.961452');
 ```
