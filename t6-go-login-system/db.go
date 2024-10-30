package main

import (
	"database/sql"
	"fmt"
	_ "github.com/mattn/go-sqlite3"
)

func connect_db() (*sql.DB, error) {
	db, err := sql.Open("sqlite3", "./login-system.db")
	if err != nil {
		return nil, err
	}

	err = db.Ping()
	if err != nil {
		return nil, err
	}
	return db, nil
}

func init_db() {
	db, err := connect_db()
	if err != nil {
		fmt.Println(err)
		return
	}
	defer db.Close()

	query := `
    CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT NOT NULL UNIQUE,
        password TEXT NOT NULL,
        role INTEGER NOT NULL
    );`
	_, err = db.Exec(query)
	if err != nil {
		fmt.Println("Error creating table:", err)
		return
	}
}

func validate_credentials(db *sql.DB, username, password string, role int) (bool, error) {
	var user User
	err := db.QueryRow("SELECT id, username, password, role FROM users WHERE username = ? AND password = ? AND role = ?", username, password, role).Scan(&user.id, &user.username, &user.password, &user.role)
	if err != nil {
		if err == sql.ErrNoRows {
			return false, nil
		}
		return false, err
	}
	return true, nil
}

func add_customer_db(db *sql.DB, username, password string, role int) error {
	var user_id int

	err := db.QueryRow("SELECT id FROM users WHERE username = ?", username).Scan(&user_id)
	if err == nil {
		return fmt.Errorf("username is already in user")
	} else if err != sql.ErrNoRows {
		return err
	}

	_, err = db.Exec("INSERT INTO users (username, password, role) VALUES (?, ?, ?)", username, password, role)
	return err
}

func update_password(db *sql.DB, new_password string, id int) error {
	_, err := db.Exec("UPDATE users SET password = ? WHERE id = ?", new_password, id)
	return err
}

func delete_user(db *sql.DB, username string) error {
	result, err := db.Exec("DELETE FROM users WHERE username = ?", username)
	if err != nil {
		return err
	}

	rowsAffected, err := result.RowsAffected()
	if err != nil {
		return err
	}

	if rowsAffected == 0 {
		return fmt.Errorf("no user found with username: %s",username)
	}
	return err
}

func get_user(db *sql.DB, username string) (User, error) {
	query := "SELECT * FROM users WHERE username = ?"
	row := db.QueryRow(query, username)

	var user User
	err := row.Scan(&user.id, &user.username, &user.password, &user.role)
	if err != nil {
		return User{}, err
	}
	return user, nil
}