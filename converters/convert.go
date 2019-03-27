package main

import (
	"bufio"
	"encoding/csv"
	"fmt"
	"io"
	"io/ioutil"
	"log"
	"os"
)

func main() {
	convertCompany()
	convertPerson()
}

func convertCompany() {

	companyCsvFile, err := os.Open("company.csv")
	if err != nil {
		fmt.Print("Could not find file company.csv\n")
	}

	firstLinePassed := false
	var companyData string
	reader := csv.NewReader(bufio.NewReader(companyCsvFile))
	for {
		line, error := reader.Read()
		if error == io.EOF {
			break
		} else if error != nil {
			log.Fatal(error)
		}
		if !firstLinePassed {
			firstLinePassed = true
		} else {
			companyData += "\tcompanyData[\"" + line[0] + "\"] = Company{\n"
			companyData += "\t\tAccountName:  \"" + line[0] + "\",\n"
			companyData += "\t\tAccountEmail: \"" + line[1] + "\",\n"
			companyData += "\t\tWebsite:      \"" + line[2] + "\",\n"
			companyData += "\t}\n"
		}
	}

	// build the Golang syntax and file structure, inserting the generated
	// Structs in the main func, and write out the new file
	company := `package dummydata

type Company struct {
	AccountName  string
	AccountEmail string
	Website      string
}

var companyData map[string]Company

func buildCompanyData() {`
	company += "\n" + companyData + "\n}\n"
	ioutil.WriteFile("output/company.go", []byte(company), 0644)

}

func convertPerson() {
	personCsvFile, err := os.Open("person.csv")
	if err != nil {
		fmt.Print("Could not find file person.csv\n")
	}

	firstLinePassed := false
	var personData string
	reader := csv.NewReader(bufio.NewReader(personCsvFile))
	for {
		line, error := reader.Read()
		if error == io.EOF {
			break
		} else if error != nil {
			log.Fatal(error)
		}
		if !firstLinePassed {
			firstLinePassed = true
		} else {
			personData += "\tpersonData[\"" + line[0] + "\"] = Person{\n"
			personData += "\t\tFirstName:    \"" + line[0] + "\",\n"
			personData += "\t\tLastName:     \"" + line[1] + "\",\n"
			personData += "\t\tEmailAddress: \"" + line[2] + "\",\n"
			personData += "\t\tAccountName:  \"" + line[3] + "\",\n"
			personData += "\t}\n"
		}
	}

	// build the Golang syntax and file structure, inserting the generated
	// Structs in the main func, and write out the new file
	person := `package dummydata

type Person struct {
	FirstName    string
	LastName     string
	EmailAddress string
	AccountName  string
}

var personData map[string]Person

func buildPersonData() {`
	person += "\n" + personData + "\n}\n"
	ioutil.WriteFile("output/person.go", []byte(person), 0644)
}
