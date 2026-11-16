# 🚀 Pterodactyl Dynamic Theme & Universal Cloud Suite

<p align="center">
  <img src="https://raw.githubusercontent.com/OddBoyXD/Pterodactyl-theme/main/resources/scripts/assets/images/logo.png" alt="Pterodactyl Dynamic Theme" width="96" height="96" onerror="this.style.display='none'"/>
</p>

<p align="center">
  <b>A next-generation, high-performance responsive Obsidian theme for Pterodactyl v1.x</b><br/>
  Featuring an integrated <b>Client Subdomain Manager</b>, <b>Zero-Disk-Waste Cloud Backups</b>, <b>Support Tickets</b>, <b>Plugins/Versions Downloader</b>, and <b>Admin Branding Customizer</b>.
</p>

<p align="center">
  <a href="#-quick-one-line-installation"><img src="https://img.shields.io/badge/Install-1--Line%20Curl-8b5cf6?style=for-the-badge&logo=gnu-bash&logoColor=white" alt="Install Script"/></a>
  <a href="#-key-features"><img src="https://img.shields.io/badge/Pterodactyl-v1.11.x%20%7C%20v1.12.x-06b6d4?style=for-the-badge&logo=pterodactyl&logoColor=white" alt="Version"/></a>
  <a href="#-key-features"><img src="https://img.shields.io/badge/Mobile-100%25%20Responsive-10b981?style=for-the-badge&logo=android&logoColor=white" alt="Mobile Friendly"/></a>
  <a href="https://github.com/OddBoyXD/Pterodactyl-theme/blob/main/LICENSE.md"><img src="https://img.shields.io/badge/License-MIT-f59e0b?style=for-the-badge" alt="License"/></a>
</p>

---

## ⚡ Quick One-Line Installation

Run the following automated installation command as **root** (or with `sudo`) directly on your Pterodactyl Panel VPS:

```bash
curl -sSL https://raw.githubusercontent.com/OddBoyXD/Pterodactyl-theme/main/install.sh | sudo bash
```

> [!TIP]
> **What the script does automatically:**
> 1. Detects your Pterodactyl installation directory (defaults to `/var/www/pterodactyl`).
> 2. Verifies and installs missing dependencies (`Node.js 20.x`, `Yarn`, `Composer`).
> 3. Downloads all theme controller, migration, React TSX, and blade view files.
> 4. Builds the frontend webpack bundle with a memory-safety cap (`--max-old-space-size=1536`).
> 5. Runs database migrations (`php artisan migrate --force`), clears caches, and restarts PHP-FPM.

---

## 📖 Manual Step-by-Step Installation

If you prefer installing and building manually step by step, follow this guide:

### 1. Prerequisites Check
Ensure your panel host has Node.js (18+ or 20+), Yarn, and build tools installed:
```bash
# Ubuntu / Debian
curl -fsSL https://deb.nodesource.com/setup_20.x | sudo -E bash -
sudo apt-get install -y nodejs git zip unzip
sudo npm install -g yarn
```

### 2. Backup Existing Files (Recommended)
```bash
cd /var/www/pterodactyl
cp -r resources resources.backup.$(date +%F)
cp -r app app.backup.$(date +%F)
cp -r routes routes.backup.$(date +%F)
```

### 3. Clone or Download Theme Files
```bash
# Clone the repository to a temporary workspace
cd /tmp
rm -rf Pterodactyl-theme
git clone https://github.com/OddBoyXD/Pterodactyl-theme.git
cd Pterodactyl-theme

# Copy files into your Pterodactyl panel directory
cp -r app /var/www/pterodactyl/
cp -r database /var/www/pterodactyl/
cp -r resources /var/www/pterodactyl/
cp -r routes /var/www/pterodactyl/
cp -r public /var/www/pterodactyl/
cp tailwind.config.js /var/www/pterodactyl/
cp babel.config.js /var/www/pterodactyl/
```

### 4. Enable Database Settings & Fix .env
```bash
cd /var/www/pterodactyl
# Ensure database settings can load dynamically
sed -i 's/APP_ENVIRONMENT_ONLY=true/APP_ENVIRONMENT_ONLY=false/g' .env
if ! grep -q "APP_ENVIRONMENT_ONLY=false" .env; then
    echo "APP_ENVIRONMENT_ONLY=false" >> .env
fi
```

### 5. Install Dependencies & Build Frontend
```bash
cd /var/www/pterodactyl

# Clean old compiled bundles
cd public/assets && find . \( -name "*.js" -o -name "*.map" \) -type f -delete
cd /var/www/pterodactyl

# Install React & JS dependencies
yarn install --ignore-engines

# Build production bundle with memory cap safeguard for 1GB/2GB RAM VPS
NODE_OPTIONS="--max-old-space-size=1536" NODE_ENV=production ./node_modules/.bin/webpack --mode production
```

### 6. Run Migrations & Clear System Caches
```bash
# Run new table migrations (subdomains, tickets, universal backups)
php artisan migrate --force

# Flush view, configuration, and route caches
php artisan view:clear
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan queue:restart

# Set web ownership & permissions
mkdir -p public/assets/branding
chown -R www-data:www-data /var/www/pterodactyl/*
chmod -R 755 storage/* bootstrap/cache
```

### 7. Restart Services
```bash
# Restart PHP-FPM (choose your active version: 8.3, 8.2, or 8.1)
sudo systemctl restart php8.3-fpm || sudo systemctl restart php8.2-fpm || sudo systemctl restart php8.1-fpm
sudo systemctl restart nginx
```

---

## 🌟 Key Features Deep Dive

### 1. 📱 Modern Obsidian Sidebar & Mobile Off-Canvas Drawer
* **Categorized Navigation**: Logically separates links into **Global** (*Dashboard*, *Account*), **Server Management** (*Console*, *File Manager*, *Databases*, *Schedules*, *Users*, *Backups*, *Network*, *Startup*, *Settings*), and **System Control** (*Subdomains*, *Plugins*, *Versions*, *Tickets*, *Admin Panel*).
* **Left-Docked Mobile Drawer**: On mobile devices ($< 768\text{px}$), the sidebar operates as a native off-canvas drawer that slides out smoothly from the **LEFT** with zero content squishing or off-screen horizontal scrolling.
* **Smart Backdrop Overlay**: Touch backdrop filter (`backdrop-filter: blur(4px)`) closes the drawer on any outside tap or pressing the `ESC` key.

### 2. 🌐 Client Server Subdomain Manager
* **Automated Cloudflare DNS Sync**: Integrates with Cloudflare API to provision subdomains automatically when assigned by users.
* **Auto-Fill VPS Allocations**: Automatically populates the node IP and allocation port into records.
* **Supported Record Types**:
  * **SRV (`_minecraft._tcp`)**: Full native support for Minecraft Java/Bedrock connections without exposing port numbers.
  * **A & CNAME Records**: Direct record mapping for Discord bots, Node/Python applications, web servers, and voice proxy bots.
* **Per-Server Subdomain Quotas**: Admins can customize the subdomain allocation limit per server.

### 3. ☁️ Universal Google Drive Cloud Backups (Zero Disk Waste)
* **On-the-Fly Streaming**: Compresses and streams server data directly to Google Drive via Rclone (`rclone rcat`) without creating massive local zip files on the node VPS, eliminating disk full crashes.
* **Dual Authentication**: Works with **Google Drive OAuth2** or **Google Cloud Service Account JSON** keys.
* **Disaster Recovery**: Restores panel database, user accounts, and server volumes seamlessly.

### 4. 🎫 Integrated Client Support Ticket System
* Client support tickets with file attachments, status tags (*Open*, *Replied*, *Resolved*, *Closed*), and admin priority dispatch.
* Complete Admin Ticket Hub under `/admin/settings/tickets`.

### 5. 🧩 In-Panel Plugin & Version Downloader
* One-tap client installation of Minecraft plugins from Modrinth and SpigotMC directly into `/plugins`.
* One-tap server jar installer for Paper, Purpur, Fabric, Forge, Vanilla, BungeeCord, and Velocity.

### 6. 🎨 Dynamic Admin Branding Customizer
* Admin dashboard UI to customize the panel logo, favicon, accent colors, Discord invite URL, and announcement banners on the fly without editing code.

---

## ⚙️ Admin Configuration Guide

### 1. Configuring Cloudflare Subdomains
1. Go to **Admin Panel** $ightarrow$ **Settings** $ightarrow$ **Subdomains**.
2. Add your base domains (e.g., `invmc.in`, `playmc.org`).
3. Enter your **Cloudflare API Token** with `Zone:DNS:Edit` and `Zone:Read` permissions.
4. Select default record type (`SRV` or `A/CNAME`) and save.

### 2. Configuring Google Drive Backups
1. Go to **Admin Panel** $ightarrow$ **Settings** $ightarrow$ **Universal Backups**.
2. Select your Authentication method:
   * **Service Account JSON**: Paste your Google Cloud service account JSON content.
   * **OAuth2**: Enter your Google Cloud Client ID, Client Secret, and Refresh Token.
3. Enter your Google Drive **Target Folder ID** (found in the Google Drive folder URL).
4. Toggle **Ignore Server Backup Limits** as desired and click **Save Configurations**.

---

## 🔄 How to Update the Theme

To pull the latest improvements, fixes, and responsive updates:

```bash
curl -sSL https://raw.githubusercontent.com/OddBoyXD/Pterodactyl-theme/main/install.sh | sudo bash
```

---

## 🧹 Restoring Vanilla Pterodactyl (Uninstallation)

If you ever wish to restore official vanilla Pterodactyl:

```bash
cd /var/www/pterodactyl

# 1. Download official release
curl -Lo panel.tar.gz https://github.com/pterodactyl/panel/releases/latest/download/panel.tar.gz
tar -xzvf panel.tar.gz
rm -f panel.tar.gz

# 2. Reset permissions
chmod -R 755 storage/* bootstrap/cache/

# 3. Re-install vanilla dependencies & build
composer install --no-dev --optimize-autoloader
yarn install --ignore-engines
yarn build:production

# 4. Flush caches & restart services
php artisan view:clear
php artisan config:clear
php artisan queue:restart
sudo systemctl restart php8.3-fpm || sudo systemctl restart php8.2-fpm
```

---

## ❓ Troubleshooting & FAQ

<details>
<summary><b>1. Webpack fails with "JavaScript heap out of memory"</b></summary>
If your VPS has 1GB or 2GB of RAM, webpack can run out of memory. The installer automatically includes <code>NODE_OPTIONS="--max-old-space-size=1536"</code>. You can also create a temporary 2GB swap file:
<pre>
sudo fallocate -l 2G /swapfile && sudo chmod 600 /swapfile && sudo mkswap /swapfile && sudo swapon /swapfile
</pre>
</details>

<details>
<summary><b>2. Subdomains save to database but not to Cloudflare</b></summary>
Ensure your Cloudflare API token has <code>Zone:DNS:Edit</code> and <code>Zone:Read</code> permissions for your domain's specific Zone.
</details>

<details>
<summary><b>3. Changes not reflecting after install</b></summary>
Run <code>php artisan view:clear && php artisan config:clear && php artisan cache:clear</code> and clear your browser cache (Ctrl + Shift + R).
</details>

---

## 📄 License & Credits

* **Developer**: [OddBoyXD](https://github.com/OddBoyXD)
* **Framework**: Built on top of [Pterodactyl Software](https://github.com/pterodactyl/panel)
* **License**: Inherits standard Pterodactyl MIT License.
