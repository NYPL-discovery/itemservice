# NYPL Item Service

[![Coverage Status](https://coveralls.io/repos/github/NYPL-discovery/itemservice/badge.svg?branch=travis)](https://coveralls.io/github/NYPL-discovery/itemservice?branch=travis)

This package is intended to be used as a Lambda-based Node.js/PHP Item Service using the
[NYPL PHP Microservice Starter](https://github.com/NYPL/php-microservice-starter).

This package adheres to [PSR-1](http://www.php-fig.org/psr/psr-1/),
[PSR-2](http://www.php-fig.org/psr/psr-2/), and [PSR-4](http://www.php-fig.org/psr/psr-4/)
(using the [Composer](https://getcomposer.org/) autoloader).

## Requirements
* Docker >= v4.34

## Installation

1. Clone the repo.
2. Setup [local configuration file](#configuration).
   * Copy the `config/development.env` file to `config/local.env`.
3. Replace values in `config/local.env` with appropriate local, development configuration values.
   * Acquire the value for DB_PASSWORD from the NYPL Digital Dev Parameter Store on AWS.

## Configuration

Various files are used to configure and deploy the Lambda.

### .env

`.env` is used by `node-lambda` for deploying to and configuring Lambda in *all* environments.

You should use this file to configure the common settings for the Lambda (e.g. timeout, Node version).

### config/global.env

Configures (non-secret) environment variables common to *all* environments.

### config/*environment*.env

Configures environment variables specific to each environment.

### config/event_sources_*environment*.json

Configures Lambda event sources (triggers) specific to each environment.

Secrets *MUST* be encrypted using KMS.

## Usage

### Run as a Web Server

We use Docker Compose to provide a local development environment. See docker-compose.yml and Dockerfile. The base image is the Bref PHP 8.3 FPM Docker Image, which provides a PHP runtime for Lambda. To start the PHP development development server, run:

~~~~
docker compose up --build
~~~~

You can then make a request to the Lambda at localhost:8000, (e.g. `http://localhost:8000/api/v0.1/items`).


### Swagger Documentation Generator

Create a Swagger route to generate Swagger specification documentation:

~~~~
$service->get("/swagger", function (Request $request, Response $response) {
    return SwaggerGenerator::generate([__DIR__ . "/src"], $response);
});
~~~~

## Git Workflow & Deployment

### Git Workflow

We follow a [feature-branch](https://www.atlassian.com/git/tutorials/comparing-workflows/feature-branch-workflow) workflow.  
Our branches, ordered from least-stable to most stable are:

| branch                                                                                                                                                     | tier        | AWS account      |
|:-----------------------------------------------------------------------------------------------------------------------------------------------------------|:------------|:-----------------|
| `development` [![Build Status](https://travis-ci.org/NYPL-discovery/itemservice.svg?branch=development)](https://travis-ci.org/NYPL-discovery/itemservice) | development | nypl-sandbox     |
| `qa` [![Build Status](https://travis-ci.org/NYPL-discovery/itemservice.svg?branch=qa)](https://travis-ci.org/NYPL-discovery/itemservice)                   | qa          | nypl-digital-dev |
| `master` [![Build Status](https://travis-ci.org/NYPL-discovery/itemservice.svg?branch=master)](https://travis-ci.org/NYPL-discovery/itemservice)           | production  | nypl-digital-dev |

Cut feature branches off of, and file PRs into `development`.
Merge `development` => `qa` & `qa` => `master`.

### Deployment

Travis CI is configured to run our build and deployment process on AWS.
Our Travis CI/CD pipeline will execute the following steps for each deployment trigger:

* Run unit test coverage
* Build Lambda deployment packages
* Execute the `deploy` hook only for `development`, `qa` and `master` branches to adhere to our `node-lambda` deployment process
* Developers _do not_ need to manually deploy the application unless an error occurred via Travis.
