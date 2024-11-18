package main

import (
	"fmt"
	"os"
)

func welcomeMessage() {
	fmt.Println(`
╔───────────────────────────────────────────╗
│░░░░░░█░█░█▀█░█░█░█░█░▀▀█░█░░░█▀█░█▀▄░░░░░░│
│░░░░░░░█░░█▀█░▀▄▀░█░█░▄▀░░█░░░█▀█░█▀▄░░░░░░│
│░░░░░░░▀░░▀░▀░░▀░░▀▀▀░▀▀▀░▀▀▀░▀░▀░▀░▀░░░░░░│
│░█░█░█▀▀░█▀▄░░░█▀▀░█▀▀░█▀▄░█▀█░█▀█░█▀▀░█▀▄░│
│░█▄█░█▀▀░█▀▄░░░▀▀█░█░░░█▀▄░█▀█░█▀▀░█▀▀░█▀▄░│
│░▀░▀░▀▀▀░▀▀░░░░▀▀▀░▀▀▀░▀░▀░▀░▀░▀░░░▀▀▀░▀░▀░│
╚───────────────────────────────────────────╝
`)

fmt.Println("Kazınacak site:")
fmt.Println("[1] The Hacker News")
fmt.Println("[2] Site 1")
fmt.Println("[3] Site 2")
fmt.Println("[4] Çıkış")
fmt.Scanln(&decision)
menuDecision(decision)
}

func menuDecision(input int){
	decision = input
	fmt.Println("───────────────────────")
	switch decision {
	case 1:
		fmt.Println("The Hacker News")
	case 2:
		fmt.Println("Site 1")
	case 3:
		fmt.Println("Site 2")
	case 4:
		exit()
	default:
		fmt.Printf("Geçersiz değer girdiniz.")
		welcomeMessage()
	}
}

func exit(){
	fmt.Println("Çıkış yapılıyor...")
	os.Exit(0)
}

