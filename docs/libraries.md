# Adding External libraries

Sometimes a drupal module needs a external library in order to function correctly. There libraries are normally 
javascript libraries that are no available in [packagist](https://packagist.org/). In order to added it to the project 
you must update the composer.json and then require the library.

## Updating composer.json
Normally all of these libraries have a CSV repository page (normally Github) and have a release section with all the 
tags. Copy the url and tag and replace it in the json below. Also don't forget to replace the `PROJECT-NAME` and the 
`LIBRARY-NAME` with the correct values.

```json
{
    "type": "package",
    "package": {
        "name": "PROJECT-NAME/LIBRARY-NAME",
        "version": "VERSION-STRING--PLEASE-REPLACE-ME!!!!!!!!!!",
        "type": "drupal-library",
        "dist": {
            "type": "zip",
            "url": "FULL-URL-TO-THE-ZIP-FILE--PLEASE-REPLACE-ME!!!!!!!!!!"
        },
        "autoload": {
            "classmap": ["."]
        }
    }
}
```
Copy the json above, with the correct values, and add it to the `composer.json` located in the root of the project. Find
the `repositories` key and paste it there.

## Adding the library to the project
Finally in other to add the library you just have to run `composer require PROJECT-NAME/LIBRARY-NAME`. If you did 
everything correctly and composer doesn't throw any errors you should be able to see the library in `build/html/libraries`
