<?php

namespace App\Http\Controllers;

use App\Models\Affiche;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\LaravelPdf\PdfBuilder;

class AffichePdfController extends Controller
{
    /**
     * Génère l'affiche vitrine en PDF A4 paysage (Chrome headless via Browsershot).
     */
    public function __invoke(Affiche $affiche): PdfBuilder
    {
        $filename = 'affiche-'.str($affiche->ville)->slug().'-'.$affiche->id.'.pdf';

        return Pdf::view('affiche.pdf', ['affiche' => $affiche])
            ->format('a4')
            ->landscape()
            ->name($filename)
            ->withBrowsershot(function (Browsershot $browsershot): void {
                $browsershot
                    ->setNodeBinary(config('services.browsershot.node', '/opt/homebrew/bin/node'))
                    ->setChromePath(config('services.browsershot.chrome', '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome'))
                    ->waitUntilNetworkIdle()
                    ->setDelay(400); // laisse le copyfitting (JS) ajuster la description avant capture
            });
    }
}
