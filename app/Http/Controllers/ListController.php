<?php

namespace App\Http\Controllers;

use App\Models\Channels;
use App\Models\Genre;
use App\Models\Matches;
use Illuminate\Http\Request;
use Validator;
use DateTime;
use DateTimeZone;
use Storage;

class ListController extends Controller
{
    public function getListOfMatches(Request $request)
    {
        $query = Matches::with(['genre_info']);
        if ($request->has('date_start') && !empty($request->date_start)) {
            $datetime1 = new DateTime($request->date_start);
            $datetime2 = new DateTime($request->date_start);
            $query->where('date_start', '>', $datetime1->setTime(0,0,0));
            $query->where('date_start', '<', $datetime2->setTime(23,59,59));
        }
        if ($request->has('channel') && !empty($request->channel)) {
            $query->where('channel', $request->channel);
        }
        $query->orderBy('date_start', 'DESC')->orderBy('channel', 'DESC');
        $matches = $query->get();
        $genres = Genre::all();
        $channels = Channels::all();
        $last_modified_time_xml = date('YmdHis +0500', Storage::disk('local')->lastModified('epg.xml') + 18000);
        return view('lists.list', compact('matches', 'last_modified_time_xml', 'channels'));
    }

    public function downloadXML(Request $request)
    {
        $today = new DateTime('Asia/Aqtau'); // Current date and time
        $channels = Channels::orderBy('id')->get();
        $matches_old = Matches::with(['genre_info'])->get();
        $matches = Matches::with(['genre_info'])->where('date_start', '>=', $today->format('Y-m-d'))->orderBy('channel')->orderBy('date_start')->get();
        $xml = $this->createXml($channels, $matches);
        header('Content-Disposition: attachment; filename="epg.xml"');
        header('Content-Type: text/xml');
        echo $xml->asXML();
    }

    public function updateXML(Request $request)
    {
        $today = new DateTime('Asia/Aqtau'); // Current date and time
        $channels = Channels::orderBy('id')->get();
        $matches = Matches::with(['genre_info'])->where('date_start', '>=', $today->format('Y-m-d'))->orderBy('channel')->orderBy('date_start')->get();
        $this->createXml($channels, $matches);
        return back()->with('success', 'Данные успешно обновлены');
    }

    public function downloadServerXml(Request $request)
    {
        $xml = new \SimpleXMLElement(Storage::disk('local')->get('epg.xml'));
        header('Content-Disposition: attachment; filename="epg.xml"');
        header('Content-Type: text/xml');
        echo $xml->asXML();
    }

    public function getXmlServer(Request $request){
        $xmlContent = Storage::disk('local')->get('epg.xml');
        return response($xmlContent, 200)
            ->header('Content-Type', 'application/xml');
    }

    public function createXml($channels, $matches)
    {
        $dateTime = new DateTime('Asia/Aqtau'); // Current date and time
        $formattedDateTime = $dateTime->format('YmdHis') . " +0500";
        $xml = new \SimpleXMLElement("<tv></tv>");
        $xml->addAttribute('generator-info-name', 'EPG generator');
        $xml->addAttribute('generator-info-url', 'epg.mmm.kz');
        $xml->addAttribute('last_modified', "$formattedDateTime");
        foreach ($channels as $channel_match) {
            $channel = $xml->addChild('channel');
            $channel->addAttribute('id', "$channel_match->id");
            $display_name = $channel->addChild('display-name', "$channel_match->title");
            $display_name->addAttribute('lang', 'ru');
        }
        foreach ($matches as $match) {
            $date_start = $this->convertDateTime($match->date_start);
            $date_end = $this->convertDateTime($match->date_end);
            $match_field = $xml->addChild('programme');
            $match_field->addAttribute('start', $date_start);
            $match_field->addAttribute('stop', $date_end);
            $match_field->addAttribute('channel', $match->channel);
            $match_field->addAttribute('id', $match->hash_id);
            $title = $match_field->addChild('title', $match->title);
            $title->addAttribute('lang', 'ru');
            $description = $match_field->addChild('desc', $match->description);
            $description->addAttribute('lang', 'ru');
            $picture = $match_field->addChild('icon');
            $picture->addAttribute('lang', 'ru');
            $picture->addAttribute('type', 'poster');
            $picture->addAttribute('position', 'gorizontal');
            $picture->addAttribute('aspect-ratio', '16:9');
            $picture->addAttribute('official', 'true');
            $picture->addAttribute('text', 'true');
            $picture->addAttribute('src', "$match->picture");
            if (!empty($match->genre)) {
                $genre = $match_field->addChild('genre', $match->genre_info->title);
                $genre->addAttribute('lang', 'ru');
                $genre->addAttribute('id', $match->genre_info->id);
            }
        }
        Storage::disk('local')->put('epg.xml', $xml->asXML());
        return $xml;
    }

    public function convertDateTime($date)
    {
        // Create a DateTime object from the provided date string in Asia/Aqtau timezone (UTC+5)
        $date_time = new DateTime($date, new DateTimeZone('Asia/Aqtau'));

        // Set the timezone to UTC+4
        $date_time->setTimezone(new DateTimeZone('Atlantic/Reykjavik')); // 'Etc/GMT+4' represents UTC+0

        // Format the DateTime object to the desired string format
        $formattedDateTime = $date_time->format('YmdHis') . " +0000";
        return $formattedDateTime;
    }
}