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

# Configuración DNS en los clientes

Para que los clientes puedan resolver el DNS necesitamos acceder al archivo de configuración
de la VPN WireGuard _/etc/wireguard/wg0.conf_ y añadir la directiva **DNS=IP-RESOLVER**

(No olvidar quitar las resoluciones realizadas directamente en el archivo _/etc/hosts_ si es
que había alguna resolución).
