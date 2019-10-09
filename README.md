# console-app
simple console application for PHP.

## Usage

```bash
$ php console RssReader {option} {url} {file-name}
```

### option
+ --strip(-a): title is 10 characters, body is 30 characters.
+ --convert(-b): Convert certain characters

### url
+ Rss feed or text file.

### file-name
+ print: Standard output
+ others: Export file name

## Install

### composer

```bash
composer install
```

## License

This software is released under the MIT License, see LICENSE.txt.
