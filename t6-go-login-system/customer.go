package main

import (
	"fmt"
)

func customer_menu() {
	fmt.Println("───────────────────────")
	fmt.Println("ANA MENÜ")
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
		customer_menu()
	}
}

func view_profile() {
	fmt.Println("──────────────────────────────────────────────")
	fmt.Println("Profil")
	fmt.Printf("Kullanıcı adı: %s\n", current_user.username)
	fmt.Println("Rol: Müşteri")
	fmt.Println("───────────────────────")
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
		fmt.Println("──────────────────────────────────────────────")
		view_profile()
	}
}

func change_password() {
	db, err := connect_db()
	if err != nil {
		fmt.Println("Database connection error:", err)
		return
	}
	defer db.Close()

	var new_password, new_password_confirm string
	fmt.Println("──────────────────────────────────────────────")
	fmt.Println("Şifre değiştir")
	fmt.Println("Yeni şifre:")
	fmt.Scanln(&new_password)
	fmt.Println("Yeni şifre onay:")
	fmt.Scanln(&new_password_confirm)

	if new_password_confirm != new_password {
		fmt.Println("Şifre doğrulanamadı!")
		customer_menu()
	}

	err = update_password(db, new_password, current_user.id)

	if err != nil {
		fmt.Printf("Error while changing password: %s\n", err)
		return
	}
	fmt.Println("Şifre başarıyla değiştirildi.")
	customer_menu()
}