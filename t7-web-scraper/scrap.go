package main

import (
	"fmt"
	"github.com/fatih/color"
	"net/http"
	"strings"

	"github.com/PuerkitoBio/goquery"
)

func scrapHackerNews() {
	res, _ := http.Get(hackerNewsURL)
	if res.StatusCode != 200 {
		fmt.Println("error	", res.StatusCode)
		return
	}

	scrapSite(hackerNews, hackerNewsURL)

	doc, _ := goquery.NewDocumentFromReader(res.Body)
	doc.Find(".home-right").Each(func(i int, s *goquery.Selection) {
		title := s.Find("h2").Text()

		datetime := s.Find(".h-datetime").Text()
		datetime = strings.Trim(datetime, "")

		description := s.Find(".home-desc").Text()
		description = strings.TrimLeft(description, " ")

		color.Magenta("%s\n\n", title)
		color.Yellow("(%s)\n\n", datetime)
		fmt.Printf("%s\n\n───────────────────────\n\n", description)

		updateFile(title, description, datetime)
	})
}

func scrapAnimalsBand() {
	res, _ := http.Get(animalsBandURL)
	if res.StatusCode != 200 {
		fmt.Println("error", res.StatusCode)
		return
	}

	scrapSite(animalsBand, animalsBandURL)

	doc, _ := goquery.NewDocumentFromReader(res.Body)
	doc.Find(".date-outer").Each(func(i int, s *goquery.Selection) {
		title := s.Find("h3").Text()
		datetime := s.Find(".date-header").Text()
		description := s.Find(".entry-content").Text()

		color.Magenta("%s", title)
		color.Yellow("(%s)", datetime)
		fmt.Printf("%s───────────────────────\n", description)
		updateFile(title, description, datetime)
	})
}

func scrapStallman() {
	res, _ := http.Get(stallmanURL)
	if res.StatusCode != 200 {
		fmt.Println("error", res.StatusCode)
		return
	}
	scrapSite(stallman, stallmanURL)

	doc, _ := goquery.NewDocumentFromReader(res.Body)
	doc.Find("dt").Each(func(i int, s *goquery.Selection) {
		title := s.Find("b").Text()
		datetime := s.Find("i").Text()
		description := s.Next().Find("p").Text()

		color.Magenta("%s", title)
		color.Yellow("(%s)", datetime)
		fmt.Printf("%s\n───────────────────────\n\n", description)
		updateFile(title,description,datetime)
	})
}
