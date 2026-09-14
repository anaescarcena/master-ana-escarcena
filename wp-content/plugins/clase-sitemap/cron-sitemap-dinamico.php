<?php
/**
 * cron-sitemap-dinamico.php
 * -----------------------------------------------------------------------------
 * Genera sitemaps DINÁMICOS a partir de los arrays del proyecto y los escribe
 * físicamente en disco. Pensado para lanzarse por CRON (CLI):
 *
 *     * /15 * * * *  php /ruta/al/proyecto/wp-content/plugins/clase-sitemap/cron-sitemap-dinamico.php
 *
 * Archivos que genera (nombres propios para NO pisar los sitemaps estáticos):
 *
 *     - sitemap-blog.xml              -> URLs de la colección "blog"
 *     - sitemap-paginas.xml           -> URLs de la colección "paginas"
 *     - sitemap-dinamico-index.xml    -> sitemap index que enlaza a los anteriores
 *
 * REGLA ESTRICTA:
 *   Al recorrer los arrays se lee la configuración de las etiquetas meta de cada
 *   URL. Si esa URL está marcada como "noindex", el condicional la EXCLUYE del
 *   sitemap (no se añade el <url> y se contabiliza como excluida en el resumen).
 *
 * XML generado con PHP nativo (DOMDocument). Sin dependencias, sin cargar WP.
 * -----------------------------------------------------------------------------
 */

/* =============================================================================
 * 1) CONFIGURACIÓN
 * ========================================================================== */

/** URL base pública del sitio (sin barra final). Se usa para el <loc> del index. */
$BASE_URL = 'https://master-ana-escarcena.test';

/** Carpeta donde se escriben los .xml. Por defecto, la raíz del WordPress. */
$OUTPUT_DIR = dirname(__DIR__, 3); // .../wp-content/plugins/clase-sitemap -> raíz WP
// $OUTPUT_DIR = __DIR__;          // ...o al lado de este script, si lo prefieres

/** Nombre del sitemap index dinámico. */
$INDEX_FILENAME = 'sitemap-dinamico-index.xml';


/* =============================================================================
 * 2) DATOS DEL PROYECTO
 * -----------------------------------------------------------------------------
 * Descomenta el include y define ahí tu variable $SITEMAP_DATA con tus arrays.
 * El fichero incluido debe dejar $SITEMAP_DATA con esta forma:
 *
 *   $SITEMAP_DATA = [
 *       'blog' => [                          // -> sitemap-blog.xml
 *           [
 *               'loc'        => 'https://master-ana-escarcena.test/blog/articulo-1/',
 *               'lastmod'    => '2026-08-30',          // opcional (Y-m-d)
 *               'changefreq' => 'weekly',              // opcional
 *               'priority'   => '0.8',                 // opcional
 *               'images'     => [                      // opcional
 *                   'https://master-ana-escarcena.test/wp-content/uploads/foto-1.jpg',
 *               ],
 *               'meta'       => [
 *                   // La config de etiquetas meta. Acepta string o array.
 *                   // Si contiene "noindex" -> la URL se excluye del sitemap.
 *                   'robots' => 'index, follow',
 *               ],
 *           ],
 *           // ...más URLs
 *       ],
 *       'paginas' => [ ... ],               // -> sitemap-paginas.xml
 *   ];
 * ========================================================================== */

// require __DIR__ . '/mis-datos-sitemap.php';   // <-- DESCOMENTA y mete aquí tus datos


/* -----------------------------------------------------------------------------
 * Datos de DEMO (solo se usan si no has definido $SITEMAP_DATA arriba).
 * Sirven para que el script funcione tal cual y para ver el formato esperado.
 * -------------------------------------------------------------------------- */
if (!isset($SITEMAP_DATA)) {
    $SITEMAP_DATA = [
        'blog' => [
            [
                'loc'        => $BASE_URL . '/blog/articulo-nuevo-para-el-sitemap/',
                'lastmod'    => '2026-08-30',
                'changefreq' => 'weekly',
                'priority'   => '0.8',
                'images'     => [
                    $BASE_URL . '/wp-content/uploads/logo-ana-scaled.png',
                ],
                'meta'       => ['robots' => 'index, follow'],
            ],
            [
                'loc'        => $BASE_URL . '/blog/lo-que-hace-el-marketing-digital/',
                'lastmod'    => '2026-03-27',
                'meta'       => ['robots' => 'index, follow'],
            ],
            [
                // Esta NO debe aparecer en el sitemap: está marcada noindex.
                'loc'        => $BASE_URL . '/blog/borrador-interno/',
                'lastmod'    => '2026-09-01',
                'meta'       => ['robots' => 'noindex, follow'],
            ],
        ],
        'paginas' => [
            [
                'loc'      => $BASE_URL . '/quienes-somos/',
                'lastmod'  => '2026-08-15',
                'priority' => '0.6',
                'meta'     => ['robots' => 'index, follow'],
            ],
            [
                'loc'     => $BASE_URL . '/aviso-legal/',
                'meta'    => ['robots' => ['noindex']], // formato array -> también excluida
            ],
        ],
    ];
}


/* =============================================================================
 * 3) FUNCIONES AUXILIARES
 * ========================================================================== */

/**
 * Lee la configuración de etiquetas meta de una URL y decide si es "noindex".
 * Acepta:
 *   - $meta['robots'] como string: "noindex, follow"
 *   - $meta['robots'] como array:  ['noindex'] / ['all','index']
 *   - $meta['noindex'] booleano:   true
 */
function sm_es_noindex($meta): bool
{
    if (!is_array($meta)) {
        return false;
    }

    if (!empty($meta['noindex'])) {
        return true;
    }

    if (isset($meta['robots'])) {
        $robots = $meta['robots'];

        if (is_array($robots)) {
            $robots = implode(',', $robots);
        }

        if (is_string($robots) && stripos($robots, 'noindex') !== false) {
            return true;
        }
    }

    return false;
}

/**
 * Construye un documento <urlset> a partir de una lista de URLs.
 * Devuelve [DOMDocument $dom, array $añadidas, array $excluidas].
 */
function sm_construir_urlset(array $urls): array
{
    $dom = new DOMDocument('1.0', 'UTF-8');
    $dom->formatOutput = true;

    $urlset = $dom->createElement('urlset');
    $urlset->setAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
    $urlset->setAttribute('xmlns:image', 'http://www.google.com/schemas/sitemap-image/1.1');
    $dom->appendChild($urlset);

    $anadidas  = [];
    $excluidas = [];

    foreach ($urls as $item) {
        if (empty($item['loc'])) {
            continue;
        }

        // ---- REGLA ESTRICTA: si la meta dice noindex, se excluye ----
        if (sm_es_noindex($item['meta'] ?? null)) {
            $excluidas[] = $item['loc'];
            continue;
        }

        $url = $dom->createElement('url');
        $urlset->appendChild($url);

        $url->appendChild($dom->createElement('loc', htmlspecialchars($item['loc'], ENT_XML1)));

        $lastmod = $item['lastmod'] ?? date('Y-m-d');
        $url->appendChild($dom->createElement('lastmod', $lastmod));

        if (!empty($item['changefreq'])) {
            $url->appendChild($dom->createElement('changefreq', $item['changefreq']));
        }
        if (isset($item['priority']) && $item['priority'] !== '') {
            $url->appendChild($dom->createElement('priority', (string) $item['priority']));
        }

        // Imágenes opcionales
        if (!empty($item['images']) && is_array($item['images'])) {
            foreach ($item['images'] as $img) {
                if (!$img) {
                    continue;
                }
                $imageEl = $dom->createElement('image:image');
                $imageEl->appendChild(
                    $dom->createElement('image:loc', htmlspecialchars($img, ENT_XML1))
                );
                $url->appendChild($imageEl);
            }
        }

        $anadidas[] = $item['loc'];
    }

    return [$dom, $anadidas, $excluidas];
}

/**
 * Construye el <sitemapindex> que enlaza a los sitemaps generados.
 */
function sm_construir_index(array $sitemaps, string $baseUrl): DOMDocument
{
    $dom = new DOMDocument('1.0', 'UTF-8');
    $dom->formatOutput = true;

    $index = $dom->createElement('sitemapindex');
    $index->setAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
    $dom->appendChild($index);

    foreach ($sitemaps as $sm) {
        $node = $dom->createElement('sitemap');
        $node->appendChild(
            $dom->createElement('loc', htmlspecialchars(rtrim($baseUrl, '/') . '/' . $sm['file'], ENT_XML1))
        );
        $node->appendChild($dom->createElement('lastmod', $sm['lastmod']));
        $index->appendChild($node);
    }

    return $dom;
}

/**
 * Escribe el XML en disco. Lanza excepción si no puede.
 */
function sm_guardar(DOMDocument $dom, string $ruta): int
{
    $bytes = $dom->save($ruta);
    if ($bytes === false) {
        throw new RuntimeException("No se pudo escribir: {$ruta}");
    }
    return $bytes;
}

/** Línea de log que funciona igual en CLI y en navegador. */
function sm_line(string $txt = ''): void
{
    echo $txt . PHP_EOL;
}


/* =============================================================================
 * 4) GENERACIÓN
 * ========================================================================== */

if (php_sapi_name() !== 'cli' && !headers_sent()) {
    header('Content-Type: text/plain; charset=UTF-8');
}

if (!is_dir($OUTPUT_DIR) || !is_writable($OUTPUT_DIR)) {
    fwrite(STDERR, "ERROR: la carpeta de salida no existe o no es escribible: {$OUTPUT_DIR}" . PHP_EOL);
    exit(1);
}

$inicio          = microtime(true);
$resumen         = [];   // por sitemap
$sitemapsIndex   = [];    // para el index
$totalAnadidas   = 0;
$totalExcluidas  = 0;

foreach ($SITEMAP_DATA as $coleccion => $urls) {
    $filename = 'sitemap-' . preg_replace('/[^a-z0-9\-]/i', '-', $coleccion) . '.xml';
    $ruta     = rtrim($OUTPUT_DIR, '/\\') . DIRECTORY_SEPARATOR . $filename;

    [$dom, $anadidas, $excluidas] = sm_construir_urlset($urls);

    // Si toda la colección quedó vacía tras aplicar noindex, igualmente
    // escribimos un urlset vacío para mantener el archivo coherente.
    $bytes = sm_guardar($dom, $ruta);

    $lastmodSitemap = date('Y-m-d\TH:i:sP', filemtime($ruta) ?: time());

    $resumen[] = [
        'file'      => $filename,
        'ruta'      => $ruta,
        'bytes'     => $bytes,
        'anadidas'  => $anadidas,
        'excluidas' => $excluidas,
    ];

    // Solo enlazamos en el index los sitemaps que tienen al menos 1 URL.
    if (!empty($anadidas)) {
        $sitemapsIndex[] = ['file' => $filename, 'lastmod' => $lastmodSitemap];
    }

    $totalAnadidas  += count($anadidas);
    $totalExcluidas += count($excluidas);
}

// ---- Sitemap index dinámico ----
$domIndex   = sm_construir_index($sitemapsIndex, $BASE_URL);
$rutaIndex  = rtrim($OUTPUT_DIR, '/\\') . DIRECTORY_SEPARATOR . $INDEX_FILENAME;
$bytesIndex = sm_guardar($domIndex, $rutaIndex);


/* =============================================================================
 * 5) RESUMEN POR CONSOLA
 * ========================================================================== */

$dur = number_format((microtime(true) - $inicio) * 1000, 1);

sm_line();
sm_line('==================================================================');
sm_line(' RESUMEN GENERACIÓN DE SITEMAPS DINÁMICOS');
sm_line(' Fecha : ' . date('Y-m-d H:i:s'));
sm_line(' Salida: ' . $OUTPUT_DIR);
sm_line('==================================================================');

foreach ($resumen as $r) {
    sm_line();
    sm_line('[' . $r['file'] . ']  (' . $r['bytes'] . ' bytes)');

    sm_line('  URLs añadidas (' . count($r['anadidas']) . '):');
    if ($r['anadidas']) {
        foreach ($r['anadidas'] as $u) {
            sm_line('    + ' . $u);
        }
    } else {
        sm_line('    (ninguna)');
    }

    if ($r['excluidas']) {
        sm_line('  Excluidas por noindex (' . count($r['excluidas']) . '):');
        foreach ($r['excluidas'] as $u) {
            sm_line('    - ' . $u);
        }
    }
}

sm_line();
sm_line('[' . $INDEX_FILENAME . ']  (' . $bytesIndex . ' bytes)');
if ($sitemapsIndex) {
    sm_line('  Enlaza ' . count($sitemapsIndex) . ' sitemap(s):');
    foreach ($sitemapsIndex as $sm) {
        sm_line('    · ' . rtrim($BASE_URL, '/') . '/' . $sm['file']);
    }
} else {
    sm_line('  (sin sitemaps con URLs indexables)');
}

sm_line();
sm_line('------------------------------------------------------------------');
sm_line(' TOTAL: ' . $totalAnadidas . ' URL(s) añadidas, '
                   . $totalExcluidas . ' excluidas por noindex.');
sm_line(' Tiempo: ' . $dur . ' ms');
sm_line('------------------------------------------------------------------');

exit(0);
