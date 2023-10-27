![GitHub contributors](https://img.shields.io/github/contributors/sparkbits/adiutor) ![GitHub followers](https://img.shields.io/github/followers/sparkbits) ![GitHub issues](https://img.shields.io/github/issues/sparkbits/adiutor) ![GitHub forks](https://img.shields.io/github/forks/sparkbits/adiutor) ![GitHub](https://img.shields.io/github/license/sparkbits/adiutor) ![GitHub last commit (branch)](https://img.shields.io/github/last-commit/sparkbits/adiutor/main) ![Static Badge](https://img.shields.io/badge/Language-php-brightgreen)

# Adiutor

<h3 align="center">Another php autoloader</h3>

# Table of Contents

- [About The Project](#About-The-Project)
   - [Built With](#Built-With)
- [Getting Started](#Getting-Started)
  - [Prerequisites](#Prerequisites)
  - [Installation](#Installation)
- [Usage](#Usage)
- [Roadmap](#Roadmap)
- [Contributing](#Contributing)
- [License](#License)
- [Contact](#Contact)
- [Acknowledgments](#Acknowledgments)

# About The Project

There are plenty of autoloaders for PHP. I just want to make my own. I usually make projects from the scratch and I require something easy to incorporate to
my projects in order to avoid long list of includes in each file. I require that each class included in a namespace or without namespace can be loaded by my
autoloader feature. Even, when the class and the file doesn't match.

To be honest my main goal is fun. I like it. :)

## Built With

The autoloader is build with php. Tested on php 8.1 but it should works on previous versions (7.x).

# Getting Started

Here explain what do you need to start to use this project.

## Prerequisites

- PHP 8.1 and above.

## Installation

1. Download or copy the three files of the project (autoloader.php, build.php, Manifestbuilder.php) into a directory inside your project.

```
📦 
├─ adiutor
│  ├─ autoloader.php
│  ├─ build.php
│  └─ Manifestbuilder.php
├─ src
└─ whatever
```
> *Note*: adiutor directory can be any name you with.

2. Once you have all your files and directories, you have to run build.php which will create a manifest.properties json file which contains all the classes and path. The file will be created inside the adiutor directory.

# Usage

1. Include the file autoloader.php in your main script. 

```php

if (!@include dirname(__DIR__) . 
                DIRECTORY_SEPARATOR . "adiutor" .
                DIRECTORY_SEPARATOR . "Autoloader.php") {
                die("[syserror]: Unable to find autoloader module.");
    }
```
> *Note*: you can use a simple include('/mypath/Autoloader.php');

## How it works?

When you create an instance of a class, spl_autoloader_register invoke the class Autloader defined in Autoloader.php. with the namespace and Class
name autoloader look for the class and try to include the file automatically. If it fails, it generate a RuntimeException.

# Roadmap

- [ ] Customize to use exceptions or trigger_errors
- [ ] Multilanguage support.

# Contributing

Contributions are what make the open source community such an amazing place to learn, inspire, and create. Any contributions you make are **greatly appreciated**.

If you have a suggestion that would make this better, please fork the repo and create a pull request. You can also simply open an issue with the tag "enhancement".
Don't forget to give the project a star! Thanks again!

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

# License

Distributed under the MIT License. See LICENSE.txt for more information.

# Contact

[coding.se6ky@passmail.net](mailto:coding.se6ky@passmail.net)
[Discord](https://discordapp.com/users/682980233657319463)

# Acknowledgments





