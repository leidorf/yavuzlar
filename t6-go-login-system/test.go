package main

import (
	"os"
    "database/sql"
    "fmt"
    _ "github.com/mattn/go-sqlite3"
)

type User struct {
	id int
	username string
	password string
	role int
}

func main() {
	welcome_message()
}

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

func add_customer_db(db *sql.DB, username, password string, role int) error {
	_, err := db.Exec("INSERT INTO users (username, password, role) VALUES (?, ?, ?)", username, password, role)
	return err
}

func query_user(db *sql.DB) ([]User, error){
	rows, err := db.Query("SELECT * FROM users")
	if err != nil {
		return nil, err
	}
	defer rows.Close()

	var users []User
	for rows.Next(){
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

func delete_user(db *sql.DB, id int) error {
	_, err := db.Exec("DELETE FROM users WHERE id = ?", id)
	return err
}

func welcome_message() {
	var decision int
	fmt.Println("Yavuzlar CLI Login System'e hoş geldiniz.")
	fmt.Println("Giriş:")
	fmt.Println("[0] Admin")
	fmt.Println("[1] Müşteri")
	fmt.Scanln(&decision)
	login_decision(decision)
}

func login_decision(input int) {
	decision:=input
	fmt.Println("----------------------")
	switch decision{
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

func login(input int){
	decision:=input
	var username string
	var password string
	fmt.Println("Kullanıcı adı:")
	fmt.Scanln(&username)
	fmt.Println("Şifre:")
	fmt.Scanln(&password)

	// buraya kullanici bilgi kontrolu gelecek 
	switch decision{
	case 0:
		admin_menu()
	case 1:
		customer_menu()
	default:
		fmt.Println("Geçersiz değer girdiniz.")
	}
}

// admin features
func admin_menu(){
	var decision int
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

func add_customer(){
	db, error := connect_db()
	var username string
	var password string
	var role int
	fmt.Println("Müşteri ekle")
	fmt.Println("Müşteri bilgileri:")
	fmt.Println("Kullanıcı adı:")
	fmt.Scanln(&username)
	fmt.Println("Şifre:")
	fmt.Scanln(&password)
	fmt.Println("Rol:")
	fmt.Scanln(&role)
	add_customer_db(db, username,password,role)
	if error != nil{
		fmt.Printf("%s",error)
	}

}

func delete_customer(){
fmt.Println("Müşteri sil")
}

func list_logs(){
fmt.Println("Logları listele")
}

//customer features
func customer_menu(){
	var decision int
	fmt.Println("Lütfen bir işlem seçiniz:")
	fmt.Println("[0] Profili görüntüle")
	fmt.Println("[9] Çıkış")
	fmt.Scanln(&decision)

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

func view_profile(){
	var decision int
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

func change_password(){
	fmt.Println("Şifre değiştir")
}

func exit(){
os.Exit(0)
}