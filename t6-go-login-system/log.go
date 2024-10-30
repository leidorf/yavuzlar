package main

import (
    "fmt"
    "os"
    "time"
)

var log_fname = "log.txt"
var current_user User
var decision int

func check_logfile() {
	var _, err = os.Stat(log_fname)

	if os.IsNotExist(err) {
		file, err := os.Create(log_fname)
		if err != nil {
			fmt.Println(err)
			return
		}
		defer file.Close()
	}
}

func update_log(logged_in bool, username string, dec int) error {
	t := time.Now().UTC().Format(time.RFC850)
	var log string
	role := "Müşteri"
	if dec == 0 {
		role = "Admin"
	}
	if logged_in {
		log = fmt.Sprintf("Başarılı - %s(%s) - %s\n", username, role, t)
	} else {
		log = fmt.Sprintf("Başarısız - %s(%s) - %s\n", username, role, t)
	}
	file, err := os.OpenFile(log_fname, os.O_APPEND|os.O_WRONLY|os.O_CREATE, 0644)
	if err != nil {
		return fmt.Errorf("error opening log file: %w", err)
	}
	defer file.Close()

	if _, err = file.WriteString(log); err != nil {
		return fmt.Errorf("error writing to log file: %w", err)
	}

	return nil
}

func get_logs() string {
	logs, err := os.ReadFile(log_fname)
	if err != nil {
		return fmt.Sprintf("Error reading logs: %v", err)
	}
	return string(logs)
}