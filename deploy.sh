#!/usr/bin/env bash
# ==========================================================================
# CST Cannabis Portal — Deployment Script
#
# Usage:
#   ./deploy.sh package           Build a zip for manual transfer
#   ./deploy.sh push USER@HOST    Deploy via rsync to a remote server
#
# ==========================================================================
set -euo pipefail

SCRIPT_DIR="$(cd "$(dirname "$0")" && pwd)"
VERSION="$(date +%Y%m%d-%H%M%S)"
PACKAGE_NAME="cst-cannabis-deploy-${VERSION}"
BUILD_DIR="${SCRIPT_DIR}/build"
PACKAGE_DIR="${BUILD_DIR}/${PACKAGE_NAME}"

# Colors for output.
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m'

log()   { echo -e "${GREEN}[deploy]${NC} $1"; }
warn()  { echo -e "${YELLOW}[warn]${NC} $1"; }
error() { echo -e "${RED}[error]${NC} $1" >&2; exit 1; }

# --------------------------------------------------------------------------
# Validate project structure
# --------------------------------------------------------------------------
validate() {
    log "Validating project structure..."

    [[ -d "${SCRIPT_DIR}/plugins/cst-core" ]]              || error "Missing plugins/cst-core/"
    [[ -f "${SCRIPT_DIR}/plugins/cst-core/cst-core.php" ]] || error "Missing cst-core.php"
    [[ -d "${SCRIPT_DIR}/themes/cst-cannabis-portal" ]]     || error "Missing themes/cst-cannabis-portal/"
    [[ -f "${SCRIPT_DIR}/themes/cst-cannabis-portal/style.css" ]] || error "Missing theme style.css"

    log "Project structure OK."
}

# --------------------------------------------------------------------------
# Build a deployable package (zip)
# --------------------------------------------------------------------------
package() {
    validate

    log "Building deployment package: ${PACKAGE_NAME}"

    rm -rf "${PACKAGE_DIR}"
    mkdir -p "${PACKAGE_DIR}/plugins"
    mkdir -p "${PACKAGE_DIR}/themes"

    # Copy plugin.
    cp -r "${SCRIPT_DIR}/plugins/cst-core" "${PACKAGE_DIR}/plugins/"

    # Copy theme.
    cp -r "${SCRIPT_DIR}/themes/cst-cannabis-portal" "${PACKAGE_DIR}/themes/"

    # Copy production config files.
    cp "${SCRIPT_DIR}/wp-config-production.php" "${PACKAGE_DIR}/wp-config-production.php"
    cp "${SCRIPT_DIR}/.htaccess" "${PACKAGE_DIR}/.htaccess"

    # Remove development files from package.
    find "${PACKAGE_DIR}" -name ".DS_Store" -delete 2>/dev/null || true
    find "${PACKAGE_DIR}" -name "*.swp" -delete 2>/dev/null || true
    find "${PACKAGE_DIR}" -name ".git*" -delete 2>/dev/null || true

    # Create zip.
    cd "${BUILD_DIR}"
    zip -r "${PACKAGE_NAME}.zip" "${PACKAGE_NAME}/"
    cd "${SCRIPT_DIR}"

    log "Package created: build/${PACKAGE_NAME}.zip"
    echo ""
    echo "Next steps:"
    echo "  1. Transfer build/${PACKAGE_NAME}.zip to your production server"
    echo "  2. Unzip and copy plugins/ to wp-content/plugins/"
    echo "  3. Copy themes/ to wp-content/themes/"
    echo "  4. Copy .htaccess to WordPress root"
    echo "  5. Edit wp-config-production.php, fill in credentials, rename to wp-config.php"
    echo "  6. Run: wp plugin activate cst-core"
    echo "  7. Run: wp theme activate cst-cannabis-portal"
    echo "  8. Run: wp rewrite flush"
    echo "  9. Run: wp cache flush"
}

# --------------------------------------------------------------------------
# Deploy via rsync
# --------------------------------------------------------------------------
push() {
    local target="${1:-}"
    [[ -z "${target}" ]] && error "Usage: ./deploy.sh push USER@HOST [WP_PATH]\n  Example: ./deploy.sh push admin@server.pr.gov /var/www/html"

    local wp_path="${2:-/var/www/html}"

    validate

    log "Deploying to ${target}:${wp_path}"

    # Confirm before deploying.
    echo ""
    warn "This will rsync files to: ${target}:${wp_path}"
    read -rp "Continue? [y/N] " confirm
    [[ "${confirm}" =~ ^[Yy]$ ]] || { log "Deployment cancelled."; exit 0; }

    # Rsync plugin.
    log "Uploading plugin..."
    rsync -avz --delete \
        "${SCRIPT_DIR}/plugins/cst-core/" \
        "${target}:${wp_path}/wp-content/plugins/cst-core/"

    # Rsync theme.
    log "Uploading theme..."
    rsync -avz --delete \
        "${SCRIPT_DIR}/themes/cst-cannabis-portal/" \
        "${target}:${wp_path}/wp-content/themes/cst-cannabis-portal/"

    # Upload .htaccess.
    log "Uploading .htaccess..."
    rsync -avz \
        "${SCRIPT_DIR}/.htaccess" \
        "${target}:${wp_path}/.htaccess"

    log "Files deployed successfully!"
    echo ""
    echo "Post-deployment steps (run on the server):"
    echo "  cd ${wp_path}"
    echo "  wp plugin activate cst-core"
    echo "  wp theme activate cst-cannabis-portal"
    echo "  wp rewrite flush"
    echo "  wp cache flush"
}

# --------------------------------------------------------------------------
# Main
# --------------------------------------------------------------------------
case "${1:-}" in
    package)
        package
        ;;
    push)
        push "${2:-}" "${3:-}"
        ;;
    *)
        echo "CST Cannabis Portal — Deployment Script"
        echo ""
        echo "Usage:"
        echo "  ./deploy.sh package              Build a .zip for manual file transfer"
        echo "  ./deploy.sh push USER@HOST [PATH] Deploy via rsync (default path: /var/www/html)"
        echo ""
        echo "Examples:"
        echo "  ./deploy.sh package"
        echo "  ./deploy.sh push admin@cst.pr.gov /var/www/html"
        exit 1
        ;;
esac
