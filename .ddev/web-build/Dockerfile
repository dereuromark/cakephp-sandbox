# Install wkhtmltopdf for the CakePdf WkHtmlToPdf engine demo.
# The upstream project is archived and removed from Debian repos, so we pull the
# pre-built bookworm .deb from the wkhtmltopdf/packaging release. It installs the
# patched-qt binary to /usr/local/bin/wkhtmltopdf (on PATH). apt resolves the
# runtime libs (libjpeg62-turbo, libxrender1, fontconfig, xfonts-*).
ARG WKHTMLTOPDF_VERSION=0.12.6.1-3
RUN curl -fsSL -o /tmp/wkhtmltox.deb \
        "https://github.com/wkhtmltopdf/packaging/releases/download/${WKHTMLTOPDF_VERSION}/wkhtmltox_${WKHTMLTOPDF_VERSION}.bookworm_amd64.deb" \
    && apt-get update \
    && apt-get install -y --no-install-recommends /tmp/wkhtmltox.deb \
    && rm -f /tmp/wkhtmltox.deb \
    && rm -rf /var/lib/apt/lists/* \
    && wkhtmltopdf --version
