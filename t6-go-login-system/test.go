package main

import "fmt"

func main() {
	login_decision()

}

func welcome_message() int {
	var decision int
	fmt.Println("Yavuzlar CLI Login System'e hoş geldiniz.")
	fmt.Println("Giriş için '0' (admin) / '1' (müşteri) giriniz:")
	fmt.Scanln(&decision)
	return decision
}

func login_decision() {
	decision:=welcome_message()
	if decision == 0 {
		fmt.Println("Admin girişine hoş geldiniz.")
		login(decision)
	} else if decision == 1 {
		fmt.Println("Müşteri girişine hoş geldiniz.")
		login(decision)
	} else {
		fmt.Println("Geçersiz değer girdiniz.")
	}
}

func login(decision int){
	var username string
	var password string
	fmt.Println("Kullanıcı adı:")
	fmt.Scanln(&username)
	fmt.Println("Şifre:")
	fmt.Scanln(&password)
	fmt.Printf("Girilen rol: %d",decision)
	fmt.Println()
	fmt.Printf("Kullanıcı adı: %s / Şifre: %s",username,password)
	fmt.Println()
}
