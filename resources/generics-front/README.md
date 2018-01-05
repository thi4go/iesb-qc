# Generics Frontend #


### What is this repository for? ###

* This repo is the generics repository for management of EduQC's platforms


### How do I get set up? ###

To use the generics for front, go to your package.json, delete all dependencies and then add:

```
#!json

"@eduqc/generics-front-qc": "^0.*"
```

The *package.json* of your application should look like: 


```
#!json

{
  "private": true,
  "scripts": {
    "dev": "node node_modules/cross-env/dist/bin/cross-env.js NODE_ENV=development node_modules/webpack/bin/webpack.js --progress --hide-modules --config=node_modules/laravel-mix/setup/webpack.config.js",
    "watch": "node node_modules/cross-env/dist/bin/cross-env.js NODE_ENV=development node_modules/webpack/bin/webpack.js --watch --watch-poll --progress --hide-modules --config=node_modules/laravel-mix/setup/webpack.config.js",
    "hot": "node node_modules/cross-env/dist/bin/cross-env.js NODE_ENV=development node_modules/webpack-dev-server/bin/webpack-dev-server.js --inline --hot --config=node_modules/laravel-mix/setup/webpack.config.js",
    "production": "node node_modules/cross-env/dist/bin/cross-env.js NODE_ENV=production node_modules/webpack/bin/webpack.js --progress --hide-modules --config=node_modules/laravel-mix/setup/webpack.config.js"
  },
  "dependencies": {

    "@eduqc/generics-front-qc": "^0.*"

  }
}
```

### How to make changes: ###

* Edit the files you want.
* After doing the changes, change the version of generics-front's *package.json*- **not the repository you 
are using the generics**. It should look like this:
```
#!json
{
"name": "generics-front-qc",
"version": "<your-version>",
...
}
```
* Publish the changes
```
#!terminal
npm publish

```