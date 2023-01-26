# What is Beck?

Beck is a very small system written in PHP for generating static web pages.

# Structure

Beck's directory structure

```
|-- beck                         # beck
    |-- adm                      # admin's root
    |   |-- lib/
    |   |-- data/
    |   |-- static/
    |   |-- tempalte/
    |   `-- <other_admin_files>
    |-- public                   # site's root
        |-- static/
        |-- ssi/
        |   |-- head.hml
        |   |-- head_nav.html
        |   |-- foot.html
        |   |-- sidebar.html
        |   |-- pagination.html
        |-- archive/
        |   |-- index.html
        |   |-- yyyy
        |   |   |-- index.html
        |   |   `-- mm
        |   |       `-- index.html
        |-- tag/
        |   `--index.html
        |-- <site category dirs>
        |   `-- index.html
        `-- index.html
```

