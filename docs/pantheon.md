# Deploying to pantheon
## Create a New Composer Project
* In your local terminal, from the repository root of your project, move to the
build directory:
```bash
cd build
```
* Use Composer to create a new project, using the Pantheon Drupal 8 Composer 
repository:
```bash
composer create-project pantheon-systems/example-drops-8-composer composer
```
This will create a new directory based on the example project 
pantheon-systems/example-drops-8-composer in the build directory. This will 
become the codebase for the pantheon repo.

### New site
If you are creating a new site in pantheon:
* Rename `composer` to `pantheon`.
* Go to the new pantheon directory and run
```bash
git init
git remote add origin <pantheon-git-repository>
git add .
git commit -m "Initial commit"
git push origin master -f
```

### Existing site
* Clone the current pantheon repo into `build/pantheon`.
* Make sure that all contrib themes/modules/profiles/library are in the 
`composer.json` of the project.
```bash
composer require drupal/module_name
```
* Copy the configuration to `src/config/` directory and custom code to the 
`src` directory
* Copy the content of `pantheon-composer` into `pantheon`

## Prepare to Deploy
At this point, your new project directory should contain all of the unique 
code from your existing Drupal 8 site, plus all of the code required to make a
Composer driven project work. Since Pantheon requires all runtime code to be 
present when deploying to the platform, if no CI solution is a part of your 
workflow, you must now modify the project to be deployable straight to Pantheon.
From the $site-composer directory, run the following:
```bash
composer prepare-for-pantheon
```

## Change Upstreams
Your Pantheon site is no longer compatible with traditional upstream updates.
Avoid confusion by moving your site to an empty upstream:
```bash
terminus site:upstream:set $site empty
```

## Deploying to pantheon
Adds the variable `PANTHEON_SITE_ID` to the `.env` file with the site ID
