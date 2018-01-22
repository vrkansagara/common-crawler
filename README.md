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


###SQL

~~~sql
create table common_index
(
	id int auto_increment
		primary key,
	`index` varchar(25) not null,
	name varchar(20) not null,
	timegate varchar(50) not null,
	cdx_api varchar(55) not null,
	status tinyint(1) default '0' not null
)
engine=InnoDB
;
~~~

###SQLite
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

