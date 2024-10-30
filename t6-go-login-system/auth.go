package main

import "fmt"

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
		update_log(false, username, decision)
		fmt.Println("Error validating credentials:", err)
		return
	}

	if !valid {
		update_log(false, username, decision)
		fmt.Println("Geçersiz kullanıcı adı, şifre veya rol")
		return
	}

	current_user, err = get_user(db, username)
	if err != nil {
		fmt.Println("Error validating credentials:", err)
		return
	}

	update_log(true, current_user.username, current_user.role)
	fmt.Println("───────────────────────")
	fmt.Printf("Hoşgeldiniz %s!\n", current_user.username)
	switch decision {
	case 0:
		admin_menu()
	case 1:
		customer_menu()
	default:
		fmt.Println("Geçersiz değer girdiniz.")
	}
}