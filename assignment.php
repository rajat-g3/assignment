<?php
ini_set('memory_limit', '256M');

class Assignment
{
    /*
     * @var $fileName 
     */
    private $fileName;
    
    /*
     * Constructor to assign filename in intance variable filename
     * @string $fileName
     */
    function __construct($fileName)
    {
        $this->fileName = $fileName;
    }
    
    /*
     * This function will traverse all the records from the file 'person_wine_3.txt' and assign the unique wine brand to each individual and 
     * everybody can have maximum 3 wine bottle
     */
    public function process()
    {
        $wineWishlist = array();
        $wineList     = array();
        $wineSold     = 0;
        $finalList    = array();
        $file         = fopen($this->fileName, "r");
        while (($line = fgets($file)) !== false) {
            $wineName = explode("\t", $line);
            $name     = trim($wineName[0]);
            $wine     = trim($wineName[1]);
            if (!array_key_exists($wine, $wineWishlist)) {
                $wineWishlist[$wine] = array();
            }
            $wineWishlist[$wine][] = $name;
            $wineList[]            = $wine;
        }
        fclose($file);
        $wineList = array_unique($wineList);
        foreach ($wineList as $key => $wine) {
            $maxSize = count($wine);
            $counter = 0;
            
            while ($counter < 10) {
                $i      = intval(floatval(rand() / (float) getrandmax()) * $maxSize);
                $person = $wineWishlist[$wine][$i];
                if (!array_key_exists($person, $finalList)) {
                    $finalList[$person] = array();
                }
                if (count($finalList[$person]) < 3) {
                    $finalList[$person][] = $wine;
                    $wineSold++;
                    break;
                }
                $counter++;
            }
        }
        
        $fh = fopen("Result.txt", "w");
        fwrite($fh, "Total number of wine bottles sold : " . $wineSold . "\n");
        foreach (array_keys($finalList) as $key => $person) {
            foreach ($finalList[$person] as $key => $wine) {
                fwrite($fh, $person . " " . $wine . "\n");
            }
        }
        fclose($fh);
    }
}

$puzzle = new Assignment("person_wine_3.txt");
$puzzle->process();
echo "Script executed. Please check Result.txt file";
