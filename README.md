# NYPL Item Service

[![Coverage Status](https://coveralls.io/repos/github/NYPL-discovery/itemservice/badge.svg?branch=travis)](https://coveralls.io/github/NYPL-discovery/itemservice?branch=travis)

This package is intended to be used as a Lambda-based Node.js/PHP Item Service using the
[NYPL PHP Microservice Starter](https://github.com/NYPL/php-microservice-starter).

This package adheres to [PSR-1](http://www.php-fig.org/psr/psr-1/),
[PSR-2](http://www.php-fig.org/psr/psr-2/), and [PSR-4](http://www.php-fig.org/psr/psr-4/)
(using the [Composer](https://getcomposer.org/) autoloader).

## Requirements
* Docker >= v27

## Installation

1. Clone the repo.
2. Setup [local configuration file](#configuration).
    * Copy the `config/local.env.dist` file to `config/local.env`.
3. Replace values in `config/local.env` with appropriate local, development configuration values.
    * Add values for AWS_ACCESS_KEY_ID and AWS_SECRET_ACCESS_KEY using keys generated for your IAM user under the nypl-digital-dev AWS account.

## Configuration

Various files are used to configure and deploy the Lambda.

### config/global.env

Configures (non-secret) environment variables common to *all* environments.

### config/*environment*.env

Defines environment variables specific to each environment: local, development, qa, and production. The  actual production values, but the secret values for DB_PASSWORD and SLACK_TOKEN are encrypted using AWS 
encryption. 

## Usage

### Run as a Web Server

We use Docker Compose to provide a local development environment. See docker-compose.yml and Dockerfile. The base image 
is the Bref PHP 8.3 FPM Docker Image, which provides a PHP runtime for Lambda. To start the PHP development server, run:

~~~~
docker compose up --build
~~~~

You can then make a request to the Lambda at localhost:8000, (e.g. `http://localhost:8000/api/v0.1/items`).

### Swagger Documentation

Swagger documentation exists at `/docs/item`. This endpoint is used by platformdocs.nypl.org to get schemas and data 
samples to present as documentation for developers and to help with API testings. Metadata for swagger is defined in 
docblocks throughout the codebase, wherever you see the @OA tag.

Note: This codebase was upgraded to use Swagger 3.x and may produce errors on platformdocs until it is also upgraded.   

## Git Workflow & Deployment

### Git Workflow

We follow a [feature-branch](https://www.atlassian.com/git/tutorials/comparing-workflows/feature-branch-workflow) 
workflow. Our branches, ordered from least-stable to most stable are:

| branch                                                                                                                                                                              | tier        | AWS account      |
|:------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|:------------|:-----------------|
| `qa` [![Build Status](https://github.com/NYPL-discovery/itemservice/actions/workflows/main.yml/badge.svg?branch=qa)](https://github.com/NYPL-discovery/itemservice/actions)         | qa          | nypl-digital-dev |
| `master` [![Build Status](https://github.com/NYPL-discovery/itemservice/actions/workflows/main.yml/badge.svg?branch=master)](https://github.com/NYPL-discovery/itemservice/actions) | production  | nypl-digital-dev |

Cut feature branches off of, and file PRs into `development`.
Merge `development` => `qa` & `qa` => `master`.

### Deployment

The application is hosted on AWS Lambda. Upon pushing a change to the `qa` or `production` branches, the Github Actions
script `.github/workflows/deploy.yml` will be run on Github. This script will run Unit tests and PHP Code Sniffer, build 
the Docker container as defined by `Dockerfile`, push the image to ECR, and finally, update the Lambda function to pull 
in the new image.
