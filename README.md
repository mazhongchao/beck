# What is Beck?

Beck is a very small system written in PHP for generating static web pages.

# Structure

The directory `adm` is the entrance to the management system.The directory `public` can be used as a directory to store static pages of your website. You can also set the `beck` directory in the `Beck` system as the storage directory, or set any location, as long as the `Beck` system has read permission.

```
|-- beck                         # beck
    |-- adm                      # admin's root
    |   |-- lib/
    |   |-- data/
    |   |-- static/
    |   |-- tempalte/
    |   `-- <other_admin_files>
    |-- public                   # site's root
        |-- index.html
        |-- static/
        |-- ssi/
        |   |-- body.html
        |   |-- header.html
        |   |-- header_nav.html
        |   |-- footer.html
        |   |-- sidebar.html
        |   |-- pagination.html
        |-- archive/
        |   |-- index.html
        |   |-- yyyy
        |       |-- index.html
        |       `-- mm
        |           `-- index.html
        |-- tag/
        |   `--index.html
        `-- <site category dirs>
            `-- index.html
        
```

