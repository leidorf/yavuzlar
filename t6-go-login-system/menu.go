package main

import (
	"fmt"
	"os"
)

func welcome_message() {
	fmt.Println(`
┌──────────────────────────────────────────────┐
│░█░█░█▀█░█░█░█░█░▀▀█░█░░░█▀█░█▀▄░░░█▀▀░█░░░▀█▀│
│░░█░░█▀█░▀▄▀░█░█░▄▀░░█░░░█▀█░█▀▄░░░█░░░█░░░░█░│
│░░▀░░▀░▀░░▀░░▀▀▀░▀▀▀░▀▀▀░▀░▀░▀░▀░░░▀▀▀░▀▀▀░▀▀▀│
│░█░░░█▀█░█▀▀░▀█▀░█▀█░░░█▀▀░█░█░█▀▀░▀█▀░█▀▀░█▄█│
│░█░░░█░█░█░█░░█░░█░█░░░▀▀█░░█░░▀▀█░░█░░█▀▀░█░█│
│░▀▀▀░▀▀▀░▀▀▀░▀▀▀░▀░▀░░░▀▀▀░░▀░░▀▀▀░░▀░░▀▀▀░▀░▀│
└──────────────────────────────────────────────┘
	`)

	fmt.Println("Giriş:")
	fmt.Println("[0] Admin")
	fmt.Println("[1] Müşteri")
	fmt.Scanln(&decision)
	login_decision(decision)
}

func login_decision(input int) {
	decision = input
	fmt.Println("───────────────────────")
	switch decision {
	case 0:
		fmt.Println("Admin girişi")
		login(decision)
	case 1:
		fmt.Println("Müşteri girişi")
		login(decision)
	default:
		fmt.Printf("Geçersiz değer girdiniz.")
		welcome_message()
	}
}

func exit() {
	os.Exit(0)
}
