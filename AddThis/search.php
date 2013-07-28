<?php

//*************
//  **********  DONT FORGET TO TRIM TEXT FIELDS
// set a setting options for the satefy setting...
// verified,... good ... any
/*
 * add a feature to be able to turn on the google did you mean api for miss spealings
 * add a feature that will allow the user to query tv.com for the exact episodes ina season and store the data in a file
 * 
 * add a clear all button for or sometyhing have to think about it
 * 
 * speed up the search algorithm by excluding multiple seasons too, just search for the show in general ??
 */

$programsArray = array(0 =>
    array(
        "show" => "air crash investigation",
        "season" => 1,
        "episodes" =>
        array(
            1 => 0,
            4 => 0,
        ),
    ),
    1 =>
    array(
        "show" => "supernatural",
        "season" => 1,
        "episodes" =>
        array(
            1 => 0,
            2 => 0,
            4 => 0,
            9 => 0,
            10 => 0,
        ),
    ),
    2 =>
    array(
        "show" => "supernatural",
        "season" => 2,
        "episodes" =>
        array(
            1 => 0,
            2 => 0,
            4 => 0,
            9 => 0,
            10 => 0,
        ),
    ),
    3 =>
    array(
        "show" => "leverage",
        "season" => 3,
        "episodes" =>
        array(
            1 => 0,
            2 => 0,
            4 => 0,
            9 => 0,
            10 => 0,
        ),
    ),
    4 =>
    array(
        "show" => "Once upon A Time",
        "season" => 1,
        "episodes" =>
        array(
            1 => 0,
            2 => 1,
            4 => 0,
            9 => 1,
            10 => 0,
        ),
    ),
    5 =>
    array(
        "show" => "Futurama",
        "season" => 2,
        "episodes" =>
        array(
            1 => 0,
            2 => 0,
            4 => 0,
            9 => 0,
            10 => 0,
        ),
    ),
);



/* this will keep track of the length of the url,... 
 * need to incorporate this with the building of the url and if it gets bigger than 200 run the search then build a new url...
  $urlLength = 36;
  foreach ($programsArray as $show){
  if(($urlLength = $urlLength + strlen($show['show']) + 15)>200){
  echo $urlLength;
  echo "\n";
  $urlLength = $urlLength - strlen($show['show']) - 15;
  echo $urlLength;
  echo "\n";
  }
  }
 */

$resultsArray = array(); //DECLARE IN MAIN array for shows that meet the search criteria
require_once 'arrayToXML.mod';

//function dataMine() {

$showCount = 1;
$search = 'http://torrentz.eu/feed_verified?q="';
foreach ($programsArray as $show) {   //run through the array and first: convert the entered seson to be 0 padded, second: build the url
    $show['season'] = sprintf('%02d', $show['season']); // might do a check for 2 digits earlied on post
    // use "burn notice s01*" | "burn notice s02*" for multiple seasons
    if ($showCount == count($programsArray)) {
        $search = $search . urlencode($show['show']) . "+s{$show['season']}%2A\"&p=";
    } else {
        $search = $search . urlencode($show['show']) . "+s{$show['season']}%2A\"+%7C+\"";
    }
    $showCount++;
}

$xmlPage = 0;
while (1) {  //begin loop to search and convert requested shows
    $pageSearch = $search . $xmlPage;  //adds the xml page number to search
    echo "$pageSearch</br>";

    $xml = file_get_contents($pageSearch);

    $convert[] = ArrayToXML::toArray($xml);  //converts the xml to a array
    if ($convert[$xmlPage]['channel']['item'] === NULL) { //if the xml rss feed page is at the end 
        break;
    }
    $xmlPage++;
}

foreach ($programsArray as $show) { // will go through each show  
    $show['season'] = sprintf('%02d', $show['season']);

    for ($epCounter = 1; $epCounter <= 27; $epCounter++) {  //loop thru all the episode check boxes               
        if ($show['episode'][$epCounter] != 1) {         // if you want to download the episode           
            for ($index = 0; $index < $xmlPage; $index++) {  // loop through all the xml rss pages                
                foreach ($convert[$index]['channel']['item'] as $values) { //go through all the items on the current xml page                 
                    if ($epCounter < 10) {                     //convert j into a 0 padded 2 digit int in order to beable to compare against the xml titles
                        $epCounter = sprintf('%02d', $epCounter);
                    }	
                    if (stristr($values['title'], "{$show['show']} S{$show['season']}E$epCounter")) {   //compare the season and episode against the title of the download                                                                                                   
                        list (, $size, $byte,, $seeds,, $peers) = explode(' ', $values['description']);  //if the download is the right ep and season break apart the description
                        if ($epCounter < 10) {                     //convert j into a 0 padded 2 digit int in order to beable to compare against the xml titles
                            $epCounter = sprintf('%1d', $epCounter);
                        }
                        $resultsArray[] = //store the episode information into the next available spot in the returned shows array
                                array(
                                    "show" => $show['show'],
                                    "title" => $values['title'],
                                    "link" => $values['link'],
                                    "seeds" => $seeds,
                                    "peers" => $peers,
                                    "filesize" => $size,
                                    "byte" => $byte,
                                    "season" => $show['season'],
                                    "episode" => $epCounter,
                        );
                    }
                } // end inner foreach
            } //if ep !- 1
        } // end for loop
    } //end while loop for checking all episodes
}   // end outer foreach
//echo 'XML:<br /><pre>'.htmlspecialchars($xml).'</pre>';
echo '<xmp>' . var_export($resultsArray, true) . "</xmp>\n";
//} // end data mine
?>
