package main

import (
	"database/sql"
	"fmt"
	"os"

	_ "github.com/mattn/go-sqlite3"
)

type User struct {
	id       int
	username string
	password string
	role     int
}

var decision int

func main() {
	init_db()
	welcome_message()
}

// db features
func connect_db() (*sql.DB, error) {
	db, err := sql.Open("sqlite3", "./login-system.db")
	if err != nil {
		return nil, err
	}

	err = db.Ping()
	if err != nil {
		return nil, err
	}
	fmt.Println("Connected to DB!")
	return db, nil
}

func init_db() {
	db, err := connect_db()
	if err != nil {
		fmt.Println("Error connecting to the database:", err)
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
	fmt.Println("Database initialized successfully.")
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
	_, err := db.Exec("INSERT INTO users (username, password, role) VALUES (?, ?, ?)", username, password, role)
	return err
}

func query_user(db *sql.DB) ([]User, error) {
	rows, err := db.Query("SELECT * FROM users")
	if err != nil {
		return nil, err
	}
	defer rows.Close()

	var users []User
	for rows.Next() {
		var user User
		if err := rows.Scan(&user.id, &user.username, &user.password, &user.role); err != nil {
			return nil, err
		}
		users = append(users, user)
	}
	return users, nil
}

func update_user(db *sql.DB, id int, new_username, new_password string, new_role int) error {
	_, err := db.Exec("UPDATE users SET username = ?, password = ?, role = ? WHERE id = ?", new_username, new_password, new_role, id)
	return err
}

func delete_user(db *sql.DB, username string) error {
	_, err := db.Exec("DELETE FROM users WHERE username = ?", username)
	return err
}

// file features
func check_log() bool {
    filename := "log.txt"
    _, err := os.Stat(filename)
    return err == nil || !os.IsNotExist(err)
}

func welcome_message() {
	if !check_log() {
        fmt.Println("Log dosyası bulunamadı, sisteme giriş engellendi.")
        return
    }
	fmt.Println("Yavuzlar CLI Login System'e hoş geldiniz.")
	fmt.Println("Giriş:")
	fmt.Println("[0] Admin")
	fmt.Println("[1] Müşteri")
	fmt.Scanln(&decision)
	login_decision(decision)
}

func login_decision(input int) {
	decision = input
	fmt.Println("----------------------")
	switch decision {
	case 0:
		fmt.Println("Admin girişi")
		login(decision)
	case 1:
		fmt.Println("Müşteri girişi")
		login(decision)
	default:
		fmt.Println("Geçersiz değer girdiniz.")
		fmt.Println("----------------------")
		welcome_message()
	}
}

func login(input int) {
	decision = input
	db, err := connect_db()
	if err != nil {
		fmt.Println("Database connection error:", err)
		return
	}
	defer db.Close()

	var username, password string
	fmt.Println("Kullanıcı adı:")
	fmt.Scanln(&username)
	fmt.Println("Şifre:")
	fmt.Scanln(&password)

	valid, err := validate_credentials(db, username, password, decision)
	if err != nil {
		fmt.Println("Error validating credentials:", err)
		return
	}

	if !valid {
		fmt.Println("Geçersiz kullanıcı adı veya şifre")
		return
	}

	switch decision {
	case 0:
		fmt.Println("Hoşgeldiniz!")
		admin_menu()
	case 1:
		fmt.Println("Hoşgeldiniz!")
		customer_menu()
	default:
		fmt.Println("Geçersiz değer girdiniz.")
	}
}

// admin features
func admin_menu() {
	fmt.Println("----------------------")
	fmt.Println("İşlemler:")
	fmt.Println("[0] Müşteri ekleme")
	fmt.Println("[1] Müşteri silme")
	fmt.Println("[2] Logları listeleme")
	fmt.Println("[9] Çıkış")
	fmt.Scanln(&decision)
	fmt.Println("----------------------")
	switch decision {
	case 0:
		add_customer()
	case 1:
		delete_customer()
	case 2:
		list_logs()
	case 9:
		exit()
	default:
		fmt.Println("Geçersiz değer girdiniz.")
		fmt.Println("----------------------")
		admin_menu()
	}
}

func add_customer() {
	db, err := connect_db()
	if err != nil {
		fmt.Println("Database connection error:", err)
		return
	}
	defer db.Close()

	var username, password string
	var role int
	fmt.Println("Müşteri ekle")
	fmt.Println("Müşteri bilgileri:")
	fmt.Println("Kullanıcı adı:")
	fmt.Scanln(&username)
	fmt.Println("Şifre:")
	fmt.Scanln(&password)
	fmt.Println("Rol ([0] Admin, [1] Müşteri):")
	fmt.Scanln(&role)

	err = add_customer_db(db, username, password, role)
	if err != nil {
		fmt.Printf("Error adding customer: %s\n", err)
		return
	}
	fmt.Println("Müşteri başarıyla eklendi.")
	admin_menu()
}

func delete_customer() {
	db, err := connect_db()
	if err != nil {
		fmt.Println("Database connection error:", err)
		return
	}
	defer db.Close()

	var username string
	fmt.Println("----------------------")
	fmt.Println("Müşteri sil")
	fmt.Println("Silmek istediğiniz müşterinin kullanıcı adı:")
	fmt.Scanln(&username)

	err = delete_user(db, username)
	if err != nil {
		fmt.Printf("Error deleting customer: %s\n", err)
		return
	}
	fmt.Println("Müşteri başarıyla silindi.")
	admin_menu()
}

func list_logs() {
	fmt.Println("Logları listele")
}

// customer features
func customer_menu() {
	fmt.Println("----------------------")
	fmt.Println("Lütfen bir işlem seçiniz:")
	fmt.Println("[0] Profili görüntüle")
	fmt.Println("[9] Çıkış")
	fmt.Scanln(&decision)
	fmt.Println("----------------------")

	switch decision {
	case 0:
		view_profile()
	case 9:
		exit()
	default:
		fmt.Println("Geçersiz değer girdiniz.")
		fmt.Println("----------------------")
		customer_menu()
	}
}

func view_profile() {
	fmt.Println("----------------------")
	fmt.Println("Profil")
	fmt.Println("Kullanıcı adı: ")
	fmt.Println("Rol: ")
	fmt.Println("----------------------")
	fmt.Println("[0] Şifre değiştir")
	fmt.Println("[9] Çıkış")
	fmt.Scanln(&decision)

	switch decision {
	case 0:
		change_password()
	case 9:
		exit()
	default:
		fmt.Println("Geçersiz değer girdiniz.")
		fmt.Println("----------------------")
		view_profile()
	}
}

func change_password() {
	fmt.Println("Şifre değiştir")
}

func exit() {
	os.Exit(0)
}
