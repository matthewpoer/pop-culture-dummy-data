# Pop Culture Dummy Data
Sometimes you need your CRM system, e-commerce tool or even a public website to just have a little more _something there_ to demonstrate what it is you're doing. [_Lorem Ipsum_](https://en.wikipedia.org/wiki/Lorem_ipsum) is great as filler text but isn't really relatable, and doesn't look like customer record data that so many tools work with.

Enter **Pop Culture Dummy Data**. More unique than repeatedly entering variations of `firstname123`, and certainly more fun, this is a practical set of mock customer data, including common person-style data fields and company references. Records are stored in this repository in [UTF-8](https://en.wikipedia.org/wiki/UTF-8) compatible and vendor neutral [CSV format](https://en.wikipedia.org/wiki/Comma-separated_values).

The benefit of using pop culture references? You (and your audience) are much more likely to see that _Daffy Duck_ is the test record, so there's a lower risk of confusing production and testing data/systems.

## Converting to Other Data Types
Most tools and spreadsheet applications will natively open CSV files, but what if you need your data in JSON? or a PHP array? We have a few scripts to help with that in the [`converters/`](converters/) directory.
