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
```
Get a piece of the stored VDM posts.
Each call get a page of 100 VDM posts maximum.
For more data, iterate over the pages

Note: The `{pageNumber}` is optional and start at 1.

Returns "304 No Content" when there is no data in the page. In case of available data, the result is a JSON array of Post objects (schema described just bellow)

---
```
GET /api/v1/post/{id}
```
Get a specific VDM post

Returns "404 Not Found" when no corresponding data is found, or a Post object following this schema:
```
{
    id: int,
    content: string,
    author: string,
    publishedAt: datetime('Y-m-d H:i:s')
}
```
