<?php

namespace App\Http\Controllers;

use App\Models\Matches;
use Illuminate\Http\Request;
use Validator;
use DateTime;
use DateTimeZone;

class ListController extends Controller
{
    public function getListOfMatches(Request $request)
    {
        $matches = Matches::all();
        return view('lists.list', compact('matches'));
    }

    public function downloadXML(Request $request){
        $matches = Matches::all();
        $xml = $this->createXml($matches);
        echo $xml->asXML();
    }

    public function createXml($matches)
    {
        $xml = new \SimpleXMLElement("<tv></tv>");
        $xml->addAttribute('generator-info-name', 'EPG Service generator xmltv');
        $xml->addAttribute('generator-info-url', 'http://www.epgservice.ru');
        $channel = $xml->addChild('channel');
        $channel->addAttribute('id', '1');
        foreach ($matches as $match){
            $date_start = $this->convertDateTime($match->date_start);
            $date_end = $this->convertDateTime($match->date_end);
            $match_field = $xml->addChild('programme');
            $match_field->addAttribute('start', "$date_start");
            $match_field->addAttribute('stop', "$date_end");
            $match_field->addAttribute('channel', "$match->channel");
            $match_field->addAttribute('id', "$match->hash_id");
            $title = $match_field->addChild('title', "$match->title");
            $title->addAttribute('lang', 'ru');
            $description = $match_field->addChild('desc', "$match->description");
            $description->addAttribute('lang', 'ru');
        }
        header('Content-Disposition: attachment; filename="items.xml"');
        header('Content-Type: text/xml');
        return $xml;
    }

    public function convertDateTime($date)
    {
        // Create a DateTime object from the original string
        $dateTime = new DateTime($date, new DateTimeZone('Asia/Aqtau'));

        // Convert to UTC or any other timezone if necessary
        $dateTime->setTimezone(new DateTimeZone('UTC'));

        // Format the DateTime object to the desired string format
        $formattedDateTime = $dateTime->format('YmdHis') . " +0000";

        // Return or use the formatted date time
        return $formattedDateTime;
    }
}