# Apache

Configuración sitio web Apache para alojar los sitios virtuales de Administración y de los Clientes.

Instalación Apache 2.0:

**sudo apt update && sudo apt upgrade -y**

**sudo apt install apache2 -y**

Comprobamos la instalación:

**apache2 -v**

**sudo systemctl status apache2**

# Sitios Virtuales

**Administración:** 
/var/www/admin

_Propiedad para www-data_

**Clientes:**
/var/www/clientes

_Propiedad para www-data_


# Archivos de Configuración

**Administración**

**HTTPS:** /etc/apache2/sites-available/admin-ssl.conf

**HTTP:** /etc/apache2/sites-available/admin.conf

**Clientes**

**HTTPS:** /etc/apache2/sites-available/clientes-ssl.conf

**HTTP:** /etc/apache2/sites-available/clientes.conf
