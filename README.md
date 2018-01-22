Common Crawler Index
=====================

Common Crawler library based on `PHP` using `Zend Framework`

#### How to run from web !

``` <<project url>>/commoncrawler```

#### How to run from console !

```  php public/index.php commooncrawler```


### Download / Install
~~~
 composer require vrkansagara/common-crawl
~~~

### Demo

`https://vrkansagara.in/commoncrawler`

### SQL

~~~sql
CREATE TABLE `common_index` (
  `id` int(11) NOT NULL,
  `cindex` varchar(25) NOT NULL,
  `name` varchar(20) NOT NULL,
  `timegate` varchar(50) NOT NULL,
  `cdx_api` varchar(55) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

~~~

### SQLite
~~~sqlite
CREATE TABLE common_index
(
    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    "index" VARCHAR(25) NOT NULL,
    name VARCHAR(20) NOT NULL,
    timegate VARCHAR(50) NOT NULL,
    cdx_api VARCHAR(55) NOT NULL
);
~~~


To follow the path 
look to the master 
follow the master 
walk with the master 
see through the master 
become the master.

