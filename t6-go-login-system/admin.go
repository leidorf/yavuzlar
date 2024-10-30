package main

import (
	"fmt"
	"os"
)

func admin_menu() {
	fmt.Println("───────────────────────")
	fmt.Println("ANA MENÜ")
	fmt.Println("[0] Müşteri ekleme")
	fmt.Println("[1] Müşteri silme")
	fmt.Println("[2] Logları listeleme")
	fmt.Println("[9] Çıkış")
	fmt.Scanln(&decision)
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
		fmt.Println("──────────────────────────────────────────────")
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
	fmt.Println("──────────────────────────────────────────────")
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
		fmt.Printf("%s adında kullanıcı bulunuyor!\n", username)
		admin_menu()
	}
	fmt.Println("Müşteri başarıyla eklendi!")
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
	fmt.Println("──────────────────────────────────────────────")
	fmt.Println("Müşteri sil")
	fmt.Println("Silmek istediğiniz müşterinin kullanıcı adı:")
	fmt.Scanln(&username)

	err = delete_user(db, username)
	if err != nil {
		fmt.Printf("%s adında kullanıcı bulunamadı!\n", username)
		admin_menu()
	}
	fmt.Println("Müşteri başarıyla silindi!")
	admin_menu()
}

func list_logs() {
	logs := get_logs()
	fmt.Println("──────────────────────────────────────────────")
	fmt.Fprintf(os.Stdout, logs, []any{}...)
	fmt.Println("──────────────────────────────────────────────")
	fmt.Println("[0] Ana Menü")
	fmt.Println("[9] Çıkış")
	fmt.Scanln(&decision)

	switch decision {
	case 0:
		admin_menu()
	case 9:
		exit()
	default:
		fmt.Println("Geçersiz değer girdiniz.")
		fmt.Println("──────────────────────────────────────────────")
		list_logs()
	}
}