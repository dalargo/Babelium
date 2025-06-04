# 📋 Guía de Instalación - Babelium

Esta guía te ayudará a instalar y configurar Babelium en tu servidor local o de producción.

## 📋 Requisitos del Sistema

### Mínimos
- **PHP:** 8.0 o superior
- **MySQL:** 8.0 o superior (o MariaDB 10.4+)
- **Servidor web:** Apache 2.4+ o Nginx 1.18+
- **Memoria RAM:** 512 MB mínimo
- **Espacio en disco:** 100 MB mínimo

### Recomendados
- **PHP:** 8.1 o superior
- **MySQL:** 8.0 o superior
- **Servidor web:** Apache 2.4+ con mod_rewrite
- **Memoria RAM:** 1 GB o más
- **Espacio en disco:** 500 MB o más

### Extensiones PHP requeridas
\`\`\`bash
# Verificar extensiones instaladas
php -m | grep -E "(mysqli|pdo|pdo_mysql|mbstring|json|session)"
\`\`\`

Extensiones necesarias:
- `mysqli` o `pdo_mysql`
- `mbstring`
- `json`
- `session`
- `fileinfo`

---

## 🚀 Instalación Rápida

### 1. Clonar el repositorio
\`\`\`bash
git clone https://github.com/dalargo/Babelium.git
cd Babelium
\`\`\`

### 2. Configurar base de datos
\`\`\`bash
# Crear base de datos
mysql -u root -p -e "CREATE DATABASE babelium_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Importar estructura y datos completos
mysql -u root -p babelium_db < scripts/babelium_db_completa.sql
\`\`\`

### 3. Configurar conexión
\`\`\`bash
# Copiar archivo de configuración
cp db/connection.example.php db/connection.php

# Editar con tus credenciales
nano db/connection.php
\`\`\`

### 4. Configurar permisos
\`\`\`bash
# Para Apache/Nginx
sudo chown -R www-data:www-data /path/to/Babelium
sudo chmod -R 755 /path/to/Babelium
sudo chmod 600 db/connection.php
\`\`\`

### 5. Acceder a la aplicación
- **URL:** `http://localhost/Babelium`
- **Admin:** admin@babelium.edu / admin123

---

## 🔧 Instalación Detallada

### 1. Preparar el entorno

#### Ubuntu/Debian
\`\`\`bash
# Actualizar sistema
sudo apt update && sudo apt upgrade -y

# Instalar LAMP stack
sudo apt install apache2 mysql-server php8.1 php8.1-mysql php8.1-mbstring php8.1-xml php8.1-curl -y

# Habilitar módulos Apache
sudo a2enmod rewrite
sudo systemctl restart apache2
\`\`\`

#### CentOS/RHEL
\`\`\`bash
# Instalar LAMP stack
sudo yum install httpd mariadb-server php php-mysql php-mbstring php-xml php-curl -y

# Iniciar servicios
sudo systemctl start httpd mariadb
sudo systemctl enable httpd mariadb
\`\`\`

### 2. Configurar servidor web

#### Apache
```apache
# /etc/apache2/sites-available/babelium.conf
<VirtualHost *:80>
    ServerName babelium.local
    DocumentRoot /var/www/html/Babelium
    
    <Directory /var/www/html/Babelium>
        AllowOverride All
        Require all granted
    </Directory>
    
    # Proteger archivos sensibles
    <Files "connection.php">
        Require all denied
    </Files>
    
    <Directory /var/www/html/Babelium/scripts>
        Require all denied
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/babelium_error.log
    CustomLog ${APACHE_LOG_DIR}/babelium_access.log combined
</VirtualHost>
