# Converters
Most tools and spreadsheet applications will natively open CSV files, but what if you need your data in JSON? or a PHP array? This directory contains scripts to help with that.

## PHP
`convert.php` reads both `company.csv` and `person.csv` and creates PHP associative arrays from each, placing the output in `company.php` and `person.php`. Run the script like `php -f converters/convert.php`

The output will look like:
```
<?php
$company = array(
  array(
    'Account Name' => 'Merry Melodies',
    'Account Email' => 'hello@merrymelodies.com',
  ),
  array(
    'Account Name' => 'The Muppet Show',
    'Account Email' => 'info@muppetshow.org',
  ),
);
```
