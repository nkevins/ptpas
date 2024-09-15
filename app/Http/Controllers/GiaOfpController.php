<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class GiaOfpController extends Controller
{

    public function index()
    {
        return view('admin/ofp/index');
    }

    public function generate(Request $request)
    {
        // Construct the URL
        $simbriefPilotId = $request->input('simbriefPilotId');
        $simbriefUrl = 'https://www.simbrief.com/api/xml.fetcher.php?userid=' . $simbriefPilotId;

        // Create a new Guzzle HTTP client
        $client = new Client();

        // Perform the HTTP GET request
        try {
            $response = $client->get($simbriefUrl);
            $data = simplexml_load_string($response->getBody()->getContents());
        } catch (RequestException $e) {
            $data = simplexml_load_string((string)$e->getResponse()->getBody());
            flash()->error((string)$data->fetch->status)->important();
            return redirect()->action('GiaOfpController@index');
        }

        $pdf = Pdf::loadView('admin.ofp.output', compact('data'));
        $pdf->render();

        // Get the total number of pages
        $totalPages = $pdf->get_canvas()->get_page_count();

        $pdf = PDF::loadView('admin.ofp.output', compact('data', 'totalPages'));
        $pdf->setPaper('A4');
        return $pdf->stream();
    }
}
