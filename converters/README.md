# Converters
Most tools and spreadsheet applications will natively open CSV files, but what if you need your data in JSON? or a PHP array? This directory contains scripts to help with that.

## PHP
`php-arrays.php` reads both `company.csv` and `person.csv` and creates PHP associative arrays from each, placing the output in `company.php` and `person.php`. Run the script like `php -f converters/php-arrays.php`

The output will look like:
```php
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
```go
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

## SugarCRM (incl. SuiteCRM and SpiceCRM)
Create the MySQL (T-SQL not tested) compatible SQL `INSERT` statements to create Account, Contact, and Opportunity records, and create links between each. Run the script like `php -f converters/sugar-sql.php`.

The output will look like:
```sql
INSERT INTO accounts (id, name, website) VALUES ('9dfe5b93acc0ab7030430492b7cfb0f3','The Kwicky Koala Show','https://www.bcdb.com/cartoon/11795-Kwicky-Koala-Show-(Series)');
INSERT INTO contacts (id, first_name, last_name) VALUES ('ffe38bb522a55038602b2178a284bb6c','Kwicky','Koala');
INSERT INTO email_addresses (id, email_address, email_address_caps) VALUES ('9364cc7cf06d1a433963798a81bf8bc1','Kwicky.Koala@KwickyKoala.net','KWICKY.KOALA@KWICKYKOALA.NET');
INSERT INTO email_addr_bean_rel (id, email_address_id, bean_id, bean_module, primary_address) VALUES (UUID(), '9364cc7cf06d1a433963798a81bf8bc1', 'ffe38bb522a55038602b2178a284bb6c', 'Contacts', 1);
INSERT INTO accounts_contacts (id, account_id, contact_id) VALUES (UUID(),'9dfe5b93acc0ab7030430492b7cfb0f3','ffe38bb522a55038602b2178a284bb6c');
INSERT INTO opportunities (id, name, amount, amount_usdollar, date_closed, sales_stage, probability) VALUES ('fd20b5cf7ffcd8044b27f715a3cd0a00', 'Opp for The Kwicky Koala Show', '100', '100', '2020-07-31', 'Prospecting', '10');
INSERT INTO accounts_opportunities (id, opportunity_id, account_id) VALUES (UUID(), 'fd20b5cf7ffcd8044b27f715a3cd0a00', '9dfe5b93acc0ab7030430492b7cfb0f3');
INSERT INTO opportunities_contacts (id, opportunity_id, contact_id) VALUES (UUID(), 'fd20b5cf7ffcd8044b27f715a3cd0a00', (SELECT ac.contact_id FROM accounts a JOIN accounts_contacts ac ON ac.account_id = a.id WHERE a.id = '9dfe5b93acc0ab7030430492b7cfb0f3' LIMIT 1));
```