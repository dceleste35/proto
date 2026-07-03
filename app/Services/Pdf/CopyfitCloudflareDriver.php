<?php

namespace App\Services\Pdf;

use Spatie\LaravelPdf\Drivers\CloudflareDriver;
use Spatie\LaravelPdf\PdfOptions;

/**
 * Driver Cloudflare Browser Rendering qui attend la fin du copyfitting de
 * l'affiche avant la capture : le script du canvas pose `data-affiche-fitted`
 * sur <html> une fois la description ajustée (équivalent du setDelay()
 * Browsershot utilisé en local, que ce driver ne supporte pas).
 */
class CopyfitCloudflareDriver extends CloudflareDriver
{
    /**
     * @return array<string, mixed>
     */
    protected function buildRequestBody(string $html, ?string $headerHtml, ?string $footerHtml, PdfOptions $options): array
    {
        return array_merge(parent::buildRequestBody($html, $headerHtml, $footerHtml, $options), [
            'gotoOptions' => ['waitUntil' => 'networkidle0'],
            'waitForSelector' => ['selector' => 'html[data-affiche-fitted]', 'timeout' => 10000],
        ]);
    }
}
