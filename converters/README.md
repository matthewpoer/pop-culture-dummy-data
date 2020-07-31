# Converters
Most tools and spreadsheet applications will natively open CSV files, but what if you need your data in JSON? or a PHP array? This directory contains scripts to help with that.

## PHP
`php-arrays.php` reads both `company.csv` and `person.csv` and creates PHP associative arrays from each, placing the output in `company.php` and `person.php`. Run the script like `php -f converters/php-arrays.php`

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

## Golang
`golang-dummydata-maps.go` reads both `company.csv` and `person.csv` and creates Golang Structs and Maps from each, placing the output in `company.go` and `person.go`. The output files reference a common `package dummydata`. Run the script like `go run golang-dummydata-maps.go`.

The output will look like:
```
package dummydata

type Company struct {
	AccountName  string
	AccountEmail string
	Website      string
}

var companyData map[string]Company

func buildCompanyData() {
	companyData["Merry Melodies"] = Company{
		AccountName:  "Merry Melodies",
		AccountEmail: "hello@merrymelodies.com",
		Website:      "http://merrymelodies.com",
	}
	companyData["The Muppet Show"] = Company{
		AccountName:  "The Muppet Show",
		AccountEmail: "info@muppetshow.org",
		Website:      "http://muppetshow.org",
	}
}
```