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
