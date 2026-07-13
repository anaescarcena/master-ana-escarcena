<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

  <xsl:output method="html" encoding="UTF-8" indent="yes"/>

  <xsl:template match="/">
    <html lang="es">
    <head>
      <meta charset="UTF-8"/>
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <title>Sitemap · SEO Office Hours en Español</title>
      <link rel="preconnect" href="https://fonts.googleapis.com"/>
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin=""/>
      <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&amp;family=DM+Sans:wght@400;500;600&amp;display=swap" rel="stylesheet"/>
      <link rel="icon" href="https://sohesp.es/favicon.png?3" type="image/png"/>
      <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        a {
            color: unset;
            text-decoration: unset;
        }
        :root {
          --red:    #DA384E;
          --red-dk: #a82538;
          --yellow: #FFD22F;
          --dark:   #0e0e0e;
          --dark2:  #1a1a1a;
          --dark3:  #242424;
          --dark4:  #2e2e2e;
          --light:  #e8e8e8;
          --muted:  #888;
          --radius: 8px;
        }

        html { background: var(--dark); }

        body {
          font-family: 'DM Sans', sans-serif;
          background: var(--dark);
          color: var(--light);
          line-height: 1.5;
          min-height: 100vh;
        }

        .site-header {
          background: var(--dark2);
          border-bottom: 3px solid var(--red);
          padding: 1.5rem 2rem;
          display: flex;
          align-items: center;
          gap: 1.5rem;
          position: sticky;
          top: 0;
          z-index: 100;
        }
        .header-badge {
          font-family: 'Bebas Neue', sans-serif;
          background: var(--red);
          color: #fff;
          font-size: 0.95rem;
          letter-spacing: 0.08em;
          padding: 0.3rem 0.8rem;
          border-radius: 4px;
          white-space: nowrap;
          flex-shrink: 0;
        }
        .header-titles h1 {
          font-family: 'Bebas Neue', sans-serif;
          font-size: 1.6rem;
          letter-spacing: 0.04em;
          color: #fff;
          line-height: 1;
        }
        .header-titles p {
          font-size: 0.8rem;
          color: var(--muted);
          margin-top: 0.2rem;
        }
        .header-count {
          margin-left: auto;
          background: var(--dark3);
          border: 1px solid var(--dark4);
          border-radius: 20px;
          padding: 0.4rem 1rem;
          font-size: 0.82rem;
          color: var(--muted);
          white-space: nowrap;
        }
        .header-count strong {
          font-family: 'Bebas Neue', sans-serif;
          font-size: 1rem;
          color: var(--yellow);
          letter-spacing: 0.05em;
        }

        .wrap {
          max-width: 1100px;
          margin: 2rem auto;
          padding: 0 1.5rem 4rem;
        }

        .sitemap-table {
          width: 100%;
          border-collapse: collapse;
          background: var(--dark2);
          border: 1px solid var(--dark4);
          border-radius: var(--radius);
          overflow: hidden;
          font-size: 0.88rem;
        }
        .sitemap-table thead tr {
          background: var(--dark3);
          border-bottom: 2px solid var(--red);
        }
        .sitemap-table thead th {
          font-family: 'Bebas Neue', sans-serif;
          font-size: 0.85rem;
          letter-spacing: 0.1em;
          color: var(--yellow);
          padding: 0.85rem 1.25rem;
          text-align: left;
          white-space: nowrap;
        }
        .sitemap-table tbody tr {
          border-bottom: 1px solid var(--dark4);
          transition: background 0.12s;
        }
        .sitemap-table tbody tr:last-child { border-bottom: none; }
        .sitemap-table tbody tr:hover { background: var(--dark3); }
        .sitemap-table td {
          padding: 0.7rem 1.25rem;
          vertical-align: middle;
        }

        .col-num {
          width: 3rem;
          color: var(--muted);
          font-size: 0.75rem;
          text-align: right;
        }
        .col-thumb {
          width: 80px;
        }
        .col-thumb img {
          width: 80px;
          height: 45px;
          object-fit: cover;
          border-radius: 4px;
          display: block;
          background: var(--dark4);
        }
        .col-title {
          min-width: 0;
        }
        .col-title a {
          color: var(--light);
          text-decoration: none;
          font-weight: 500;
          font-size: 0.88rem;
          transition: color 0.15s;
          display: block;
        }
        .col-title a:hover { color: var(--red); }
        .col-title .ep-url {
          display: block;
          font-size: 0.72rem;
          color: var(--muted);
          margin-top: 0.15rem;
          word-break: break-all;
        }
        .col-title .ep-url::after {
          content: ' ↗';
        }
        .col-date {
          width: 7rem;
          color: var(--muted);
          font-size: 0.78rem;
          white-space: nowrap;
        }
        .col-dur {
          width: 5rem;
          white-space: nowrap;
        }
        .dur-badge {
          display: inline-flex;
          align-items: center;
          gap: 0.3rem;
          background: var(--dark4);
          color: var(--light);
          font-size: 0.75rem;
          font-variant-numeric: tabular-nums;
          padding: 0.2rem 0.55rem;
          border-radius: 4px;
        }

        .sitemap-footer {
          text-align: center;
          margin-top: 2rem;
          font-size: 0.78rem;
          color: var(--muted);
        }
        .sitemap-footer a {
          color: var(--red);
          text-decoration: none;
        }
        .sitemap-footer a:hover { text-decoration: underline; }

        @media (max-width: 640px) {
          .site-header { flex-wrap: wrap; gap: 0.75rem; padding: 1rem; }
          .header-count { margin-left: 0; }
          .col-thumb, .col-date { display: none; }
          .sitemap-table thead th:nth-child(2),
          .sitemap-table thead th:nth-child(4) { display: none; }
        }
        .sitemap-table tbody tr {
            position: relative;
        }
        .col-title a:after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
      </style>
    </head>
    <body>

      <header class="site-header">
        <span class="header-badge"><a href="#">SITEMAP</a></span>
        <div class="header-titles">
          <h1><a href="/">SEO Office Hours en Español</a></h1>
        </div>
        <div class="header-count">
          <strong><xsl:value-of select="count(//*[local-name()='url'])"/></strong> episodios
        </div>
      </header>

      <div class="wrap">
        <table class="sitemap-table">
          <thead>
            <tr>
              <th class="col-num">#</th>
              <th class="col-thumb"></th>
              <th>Título</th>
              <th>Fecha</th>
              <th>Duración</th>
            </tr>
          </thead>
          <tbody>
            <xsl:for-each select="//*[local-name()='url']">
              <xsl:sort select="*[local-name()='lastmod']" order="descending"/>
              <tr>
                <td class="col-num"><xsl:value-of select="position()"/></td>
                <td class="col-thumb">
                  <xsl:if test="*[local-name()='video']/*[local-name()='thumbnail_loc']">
                    <img>
                      <xsl:attribute name="src">
                        <xsl:value-of select="*[local-name()='video']/*[local-name()='thumbnail_loc']"/>
                      </xsl:attribute>
                      <xsl:attribute name="alt">
                        <xsl:value-of select="*[local-name()='video']/*[local-name()='title']"/>
                      </xsl:attribute>
                      <xsl:attribute name="loading">lazy</xsl:attribute>
                    </img>
                  </xsl:if>
                </td>
                <td class="col-title">
                  <a href="{*[local-name()='loc']}" target="_blank" rel="noopener">
                    <xsl:value-of select="*[local-name()='video']/*[local-name()='title']"/>
                  </a>
                  <span class="ep-url">
                    <xsl:value-of select="*[local-name()='loc']"/>
                  </span>
                </td>
                <td class="col-date">
                  <xsl:value-of select="*[local-name()='lastmod']"/>
                </td>
                <td class="col-dur">
                  <xsl:if test="*[local-name()='video']/*[local-name()='duration']">
                    <span class="dur-badge">
                      <!-- Convertir segundos a h:mm:ss / m:ss -->
                      <xsl:variable name="s" select="number(*[local-name()='video']/*[local-name()='duration'])"/>
                      <xsl:variable name="h" select="floor($s div 3600)"/>
                      <xsl:variable name="m" select="floor(($s mod 3600) div 60)"/>
                      <xsl:variable name="sec" select="$s mod 60"/>
                      <xsl:if test="$h > 0">
                        <xsl:value-of select="$h"/>
                        <xsl:text>:</xsl:text>
                        <xsl:if test="$m &lt; 10">0</xsl:if>
                      </xsl:if>
                      <xsl:value-of select="$m"/>
                      <xsl:text>:</xsl:text>
                      <xsl:if test="$sec &lt; 10">0</xsl:if>
                      <xsl:value-of select="$sec"/>
                    </span>
                  </xsl:if>
                </td>
              </tr>
            </xsl:for-each>
          </tbody>
        </table>

        <p class="sitemap-footer">
          Generado por <a href="https://asdrubalseo.com/" target="_blank" rel="noopener">Asdrubal SEO</a> ·
          Sitemap XML estándar acorde a <a href="https://www.sitemaps.org/protocol.html" target="_blank" rel="noopener nofollow">sitemaps.org</a>
        </p>
      </div>

    </body>
    </html>
  </xsl:template>

</xsl:stylesheet>