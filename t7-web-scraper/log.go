package main

import (
	"fmt"
	"os"
)

var fileName = "output.txt"

func checkFile() {
	var _, err = os.Stat(fileName)

	if os.IsNotExist(err) {
		file, err := os.Create(fileName)
		if err != nil {
			fmt.Println(err)
			return
		}
		defer file.Close()
	}
}

func writeToFile(content string) error {
	file, err := os.OpenFile(fileName, os.O_APPEND|os.O_WRONLY|os.O_CREATE, 0644)
	if err != nil {
		return fmt.Errorf("error while opening output file: %w", err)
	}
	defer file.Close()

	if _, err = file.WriteString(content); err != nil {
		return fmt.Errorf("error while writing to output file: %w", err)
	}
	return nil
}

func scrapSite(sitename, url string) error {
	header := fmt.Sprintf("#######################\n%s\n(%s)\n\n", sitename, url)
	return writeToFile(header)
}

func updateFile(title, description, datetime string) error {
	output := fmt.Sprintf("%s\n(%s)\n%s\n\n───────────────────────\n\n", title, datetime, description)
	return writeToFile(output)
}
