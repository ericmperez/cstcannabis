# Deployment Guide — CST Cannabis Portal

## Production Environment

### Server Requirements

| Requirement | Minimum |
|-------------|---------|
| PHP | 8.1+ |
| MySQL/MariaDB | 5.7+ / 10.4+ |
| WordPress | 6.4+ |
| Web Server | Apache 2.4+ or Nginx |
| SSL | Required (HSTS enforced) |
| Memory | 256MB PHP memory_limit |

### Recommended Hosting

Government portals should use hosting that complies with:
- Puerto Rico data residency requirements
- FedRAMP or equivalent security standards
- 99.9% uptime SLA
- Daily automated backups

## Pre-deployment Checklist

- [ ] SSL certificate installed and configured
- [ ] PHP version 8.1+ confirmed
- [ ] WordPress 6.4+ installed
- [ ] `WP_DEBUG` set to `false` in `wp-config.php`
- [ ] `DISALLOW_FILE_EDIT` set to `true` in `wp-config.php`
- [ ] Database credentials are not hardcoded
- [ ] All plugin licenses activated (if using premium plugins)
- [ ] `.htaccess` or Nginx config reviewed for security

## Deployment Steps

### 1. Database Migration

```bash
# Export from staging
wp db export staging-backup.sql --add-drop-table

# Import to production
wp db import staging-backup.sql

# Search and replace URLs
wp search-replace 'https://staging.example.com' 'https://cannabis.cst.pr.gov' --all-tables
```

### 2. File Transfer

```bash
# Upload theme
rsync -avz themes/cst-cannabis-portal/ user@server:/path/to/wp-content/themes/cst-cannabis-portal/

# Upload plugin
rsync -avz plugins/cst-core/ user@server:/path/to/wp-content/plugins/cst-core/
```

### 3. Post-deployment

```bash
# Flush rewrite rules
wp rewrite flush

# Clear any object cache
wp cache flush

# Verify theme is active
wp theme activate cst-cannabis-portal

# Verify plugin is active
wp plugin activate cst-core
```

### 4. DNS Configuration

Point the domain to the production server:

```
cannabis.cst.pr.gov    A       [server IP]
cannabis.cst.pr.gov    AAAA    [server IPv6]
```

## SSL Configuration

### Apache (.htaccess)

```apache
# Force HTTPS
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

### Nginx

```nginx
server {
    listen 80;
    server_name cannabis.cst.pr.gov;
    return 301 https://$host$request_uri;
}

server {
    listen 443 ssl http2;
    server_name cannabis.cst.pr.gov;

    ssl_certificate /path/to/cert.pem;
    ssl_certificate_key /path/to/key.pem;
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers HIGH:!aNULL:!MD5;
}
```

## wp-config.php Security Settings

```php
// Disable file editing from admin
define( 'DISALLOW_FILE_EDIT', true );

// Disable auto-updates for controlled deployments
define( 'AUTOMATIC_UPDATER_DISABLED', true );

// Limit post revisions
define( 'WP_POST_REVISIONS', 5 );

// Security keys (generate at https://api.wordpress.org/secret-key/1.1/salt/)
// AUTH_KEY, SECURE_AUTH_KEY, LOGGED_IN_KEY, NONCE_KEY, etc.
```

## Backup Strategy

### Automated Backups

| What | Frequency | Retention |
|------|-----------|-----------|
| Full database | Daily | 30 days |
| Database diff | Hourly | 7 days |
| wp-content files | Daily | 30 days |
| Full server image | Weekly | 4 weeks |

### Manual Backup Before Updates

```bash
# Backup database
wp db export backup-$(date +%Y%m%d).sql

# Backup files
tar -czf wp-content-backup-$(date +%Y%m%d).tar.gz wp-content/
```

### Restoration

```bash
# Restore database
wp db import backup-20240115.sql

# Restore files
tar -xzf wp-content-backup-20240115.tar.gz
```

## Monitoring

### Health Checks

- WordPress Site Health (Tools > Site Health)
- Security headers: verify at securityheaders.com
- SSL: verify at ssllabs.com
- Accessibility: run axe DevTools monthly
- Performance: check Core Web Vitals in Google Search Console

### Uptime Monitoring

Set up external monitoring for:
- `https://cannabis.cst.pr.gov` (HTTP 200)
- `https://cannabis.cst.pr.gov/wp-json/cst/v1/statistics` (REST API)

### Log Monitoring

```bash
# WordPress debug log (if enabled in staging)
tail -f wp-content/debug.log

# Server error log
tail -f /var/log/apache2/error.log
```

## Update Procedure

1. **Staging first**: Apply all updates in staging environment
2. **Test**: Verify site functionality, run accessibility checks
3. **Backup**: Full database and file backup
4. **Deploy**: Apply updates to production during low-traffic hours
5. **Verify**: Check all critical pages and functionality
6. **Monitor**: Watch error logs for 24 hours

### Plugin Update Priority

| Priority | Plugins |
|----------|---------|
| Critical (same day) | WordPress core, CST Core (security patches) |
| High (within 1 week) | GeneratePress, Yoast SEO, CF7 |
| Normal (within 2 weeks) | Polylang, TEC, Download Manager, Progressify |
