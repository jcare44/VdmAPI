#VdmAPI

The purpose en VdmAPI is to provide a personal VDM
scraper and an open API to access the scraped VDMs.

##Installation
```
$ git clone
$ cd VdmAPI
$ composer install
```
Note: The scraped VDM posts are stored in your database unsing doctrine2,
so you must configure it well and initialize it using:
```
$ php app/console doctrine:database:create
$ php app/console doctrine:schema:update --force
```

##Usage
###Scraper
The scraping is triggered when executing the `vdm:scrape` console command:
```
$ php app/console vdm:scrape
```

###API
Once your server started, you can access your data through two API calls:
```
GET /api/v1/posts/{pageNumber}
GET /api/v1/post/{id}
```
Note: The `{pageNumber}` is optional and start at 1.
