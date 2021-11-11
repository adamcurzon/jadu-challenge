<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(): Response
    {
        $functions = [
            [
                "function" => "isPalindrome",
                "input" => ["anna"],
                "expected output" => "true",
            ],
            [
                "function" => "isPalindrome",
                "input" => ["Bark"],
                "expected output" => "false",
            ],
            [
                "function" => "isAnagram",
                "input" => ["coalface","cacao elf"],
                "expected output" => "true",
            ],
            [
                "function" => "isAnagram",
                "input" => ["coalface","dark elf"],
                "expected output" => "false",
            ],
            [
                "function" => "isPangram",
                "input" => ["The quick brown fox jumps over the lazy dog"],
                "expected output" => "true",
            ],
            [
                "function" => "isPangram",
                "input" => ["The British Broadcasting Corporation (BBC) is a British public service broadcaster"],
                "expected output" => "false",
            ],
        ];
        
        foreach($functions as $key => $f){
            $functions[$key]["output"] = $this->{$f["function"]}(...$f["input"]);
        }

        return $this->render('testTable/index.html.twig', ['functions' => $functions]);
    }

    public function isPalindrome(string $word) : bool
    {
        // Pointer variables to keep track of the position of chars we are checking
        $pointer_1 = 0;
        $pointer_2 = strlen($word) - 1;

        // Loop until we hit the center of the word at which point all chars will of been checked
        while($pointer_1 <= $pointer_2)
        {
            // If the characters don't match the word isn't a palindrome
            if($word[$pointer_1] != $word[$pointer_2])
            {
                return false;
            }

            // Update pointers to check next character
            $pointer_1++;
            $pointer_2--;
        }

        // If the loop ran without returning early the word is a palindrome
        return true;
    }

    public function isPalindromeForLoop(string $word) : bool
    {
        // For loop implementation
        for(
            $pointer_1 = 0, $pointer_2 = strlen($word) - 1;
            $pointer_1 <= $pointer_2;
            $pointer_1++, $pointer_2--
            ){
                // If the characters don't match the word isn't a palindrome
                if($word[$pointer_1] != $word[$pointer_2])
                {
                    return false;
                }
            }

        // If the loop ran without returning early the word is a palindrome
        return true;
    }

    public function isAnagram(string $word, string $comparison) : bool
    {
        // Create array of character counts
        $word_char_count = $this->count_chars($word);
        $comparison_char_count = $this->count_chars($comparison);

        // Compare the two arrays
        foreach($word_char_count as $char => $count)
        {
            // Check character exists in comparison array
            if(!isset($comparison_char_count[$char]))
            {
                return false;
            }

            // Check the comparison has more or equal occourences of the char
            if($comparison_char_count[$char] < $word_char_count[$char])
            {
                return false;
            }
        }

        return true;
    }

    // Function to split string into array containing a count of each char
    public function count_chars(string $string) : array
    {
        $char_count = [];

        // Split string into an array
        $string_array = str_split($string);

        // Loop through each letter and count each char
        foreach($string_array as $char)
        {
            if(isset($char_count[$char]))
            {
                $char_count[$char]++;
            } else {
                $char_count[$char] = 1;
            }
        }

        return $char_count;
    }


    public function isPangram(string $phrase) : bool
    {
        // Remove everything that isn't an alphabet character
        $phrase = preg_replace('/[^A-Za-z]/', "", $phrase);

        // Change all chars to lowercase to prevent duplicate letter count
        $phrase = strtolower($phrase);

        // Change phrase into an array
        $phrase_array = str_split($phrase);

        // Remove array duplicates
        $phrase_array = array_unique($phrase_array);
        
        // Count amount of unique characters in each array
        if(sizeOf($phrase_array) != 26){
            return false;
        }

        return true;
    }
}
