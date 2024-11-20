package main

import (
	"fmt"
	"os"

	"github.com/fatih/color"
)

var decision int
var hackerNews = "The Hacker News"
var hackerNewsURL = "https://thehackernews.com/"
var animalsBand = "animals within animals"
var animalsBandURL = "http://news.animalswithinanimals.com/search?updated-max=2922-10-08T00:00:00-04:00&max-results=100"
var stallman = "Richard Stallman's Personal Site"
var stallmanURL = "https://stallman.org/"

func main() {
	checkFile()
	welcomeMessage()
	menu()
}

func welcomeMessage() {
	color.Magenta(`
╔───────────────────────────────────────────╗
│░░░░░░█░█░█▀█░█░█░█░█░▀▀█░█░░░█▀█░█▀▄░░░░░░│
│░░░░░░░█░░█▀█░▀▄▀░█░█░▄▀░░█░░░█▀█░█▀▄░░░░░░│
│░░░░░░░▀░░▀░▀░░▀░░▀▀▀░▀▀▀░▀▀▀░▀░▀░▀░▀░░░░░░│
│░█░█░█▀▀░█▀▄░░░█▀▀░█▀▀░█▀▄░█▀█░█▀█░█▀▀░█▀▄░│
│░█▄█░█▀▀░█▀▄░░░▀▀█░█░░░█▀▄░█▀█░█▀▀░█▀▀░█▀▄░│
│░▀░▀░▀▀▀░▀▀░░░░▀▀▀░▀▀▀░▀░▀░▀░▀░▀░░░▀▀▀░▀░▀░│
╚───────────────────────────────────────────╝
`)
}

func menu() {
	color.Yellow("\nKazınacak site:")
	fmt.Printf("[1] %s\n", hackerNews)
	fmt.Printf("[2] %s\n", animalsBand)
	fmt.Printf("[3] %s\n", stallman)
	color.Red("[4] Çıkış\n\n")
	fmt.Scanln(&decision)
	menuDecision(decision)
}

func menuDecision(input int) {
	decision = input
	fmt.Println("───────────────────────")
	switch decision {
	case 1:
		color.Red("%s\n\n", hackerNews)
		scrapHackerNews()
		menu()
	case 2:
		fmt.Printf("%s\n\n", animalsBand)
		scrapAnimalsBand()
		menu()
	case 3:
		fmt.Printf("%s\n\n", stallman)
		scrapStallman()
		menu()
	case 4:
		exit()
	default:
		color.Red("Geçersiz değer girdiniz.\n\n")
		menu()
	}
}

func exit() {
	fmt.Println("Çıkış yapılıyor...")
	os.Exit(0)
}
