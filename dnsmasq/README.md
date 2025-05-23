# DNSMASQ

Instalación y configuración del DNS interno de la red privada virtual.

Instalación dnsmasq:

**sudo apt update && sudo apt upgrade -y**

**sudo apt install dnsmasq**

Comprobamos la instalación:

**sudo systemctl status dnsmasq.service**

# Archivo de Configuración

El archivo de configuración por defecto de _dnsmasq_ es _/etc/dnsmasq.conf_.

Nosotros creamos un archivo personalizado para la configuración: **_/etc/dnsmasq.d/guardianvpn.conf_**
