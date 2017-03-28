<?php

ini_set('memory_limit', '-1');

/**
 * puzzle.php is a PHP script which provides the solution for wine puzzle.
 *
 * Environment : PHP version 5.5.X+, 5.5.9-1ubuntu4.9 (cli), this script on an average took 15 seconds to execute and provide
 * result with the solution below we receive maximum sale by Apan Vineyard are : 297448. It runs on PHP CLI.
 * 
 * Class Puzzle contain a function which iterate between file "person_wine_3.txt" and retun another set of file which contain desired result.
 *
 * PHP version 5.5.X
 *
 *
 * @package    Wine Yard Puzzle
 * @author     Anshul Gupta<anshulgupta619@gmail.com>
 * @link       https://github.com/anshulgupta619/wine-puzzle
 * @since      File available since Release 0.1
 */
class Puzzle {

    /**
     * Class Puzzle
     *
     * input the file name in class to process
     *
     * @var $fileName
     */
    public $fileName;

    function __construct($text) {
        $this->fileName = $text;
    }

    /**
     * function assignWines
     *
     * input the file which contain the person and wine data, output a TSV file which contain the desired result based on puzzle.
     *
     */
    public function assignWines() {
        $wineWishlist = [];
        $wineList = [];
        $wineSold = 0;
        $finalList = [];
        $file = fopen($this->fileName, "r");
        while (($line = fgets($file)) !== false) {
            $name_and_wine = explode("\t", $line);
            $name = trim($name_and_wine[0]);
            $wine = trim($name_and_wine[1]);
            if (!array_key_exists($wine, $wineWishlist)) {
                $wineWishlist[$wine] = [];
            }
            $wineWishlist[$wine][] = $name;
            $wineList[] = $wine;
        }
        fclose($file);
        $wineList = array_unique($wineList);

        foreach ($wineList as $key => $wine) {
            $maxSize = count($wine);
            $counter = 0;

            while ($counter < 10) {
                $i = intval(floatval(rand() / (float) getrandmax()) * $maxSize);
                $person = $wineWishlist[$wine][$i];
                if (!array_key_exists($person, $finalList)) {
                    $finalList[$person] = [];
                }
                if (count($finalList[$person]) < 3) {
                    $finalList[$person][] = $wine;
                    $wineSold++;
                    break;
                }
                $counter++;
            }
        }

        $fh = fopen("finalAssign.txt", "w");
        fwrite($fh, "Total number of wine bottles sold in aggregate : " . $wineSold . "\n");
        foreach (array_keys($finalList) as $key => $person) {
            foreach ($finalList[$person] as $key => $wine) {
                fwrite($fh, $person . " " . $wine . "\n");
            }
        }
        fclose($fh);
    }

}

echo "Script Execution started at : " . date('Y-m-d H:i:s') . "\n";

//Choose the desired test file by uncommenting one among the following 3 lines
$puzzle = new Puzzle("person_wine_3.txt");
//$puzzle = new Puzzle("person_wine_3.txt");
//$puzzle = new Puzzle("person_wine_3.txt");
$puzzle->assignWines();
echo "Script Execution stoped at : " . date('Y-m-d H:i:s') . "\n";
?>
