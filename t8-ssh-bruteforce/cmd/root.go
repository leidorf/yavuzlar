package cmd

import (
	"bufio"
	"fmt"
	"os"
	"strings"

	"github.com/spf13/cobra"
)

var (
	password     string
	passwordFile string
)

var rootCmd = &cobra.Command{
	Use:   "lei",
	Short: "lei-bruteforce is an SSH brute force tool",
	Long:  "lei-bruteforce is an SSH brute force tool under GPLv3 license and FOSS!",
	Run: func(cmd *cobra.Command, args []string) {
		if password == "" && passwordFile == "" {
			fmt.Fprintln(os.Stderr, "Error: You must specify either a single password (-p) or a password file (-P).")
			os.Exit(1)
		}
		if password != "" && passwordFile != "" {
			fmt.Fprintln(os.Stderr, "Error: You cannot specify both a single password (-p) and a password file (-P).")
			os.Exit(1)
		}

		if password != "" {
			fmt.Printf("Using single password for brute force: %s\n", password)
		} else if passwordFile != "" {
			passwords, err := readPasswordsFromFile(passwordFile)
			if err != nil {
				fmt.Fprintf(os.Stderr, "Error reading passwords from file '%s': %v\n", passwordFile, err)
				os.Exit(1)
			}

			fmt.Printf("Loaded %d passwords from file '%s'\n", len(passwords), passwordFile)
			for _, pass := range passwords {
				fmt.Println(pass)
			}
		}
	},
}

func Execute() {
	if err := rootCmd.Execute(); err != nil {
		fmt.Fprintf(os.Stderr, "Oops. An error occurred: %v\n", err)
		os.Exit(1)
	}
}

func init() {
	rootCmd.Flags().StringVarP(&password, "password", "p", "", "Single password to use for brute force")
	rootCmd.Flags().StringVarP(&passwordFile, "password-file", "P", "", "File containing passwords for brute force")
}

func readPasswordsFromFile(filename string) ([]string, error) {
	file, err := os.Open(filename)
	if err != nil {
		return nil, err
	}
	defer file.Close()

	var passwords []string
	scanner := bufio.NewScanner(file)
	for scanner.Scan() {
		password := strings.TrimSpace(scanner.Text())
		if password != "" {
			passwords = append(passwords, password)
		}
	}

	if err := scanner.Err(); err != nil {
		return nil, err
	}

	return passwords, nil
}
