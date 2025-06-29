# DNSMASQ

Instalación y configuración del DNS interno para la red privada virtual.

---

## Instalación dnsmasq

Actualiza el sistema e instala dnsmasq con los siguientes comandos:

```bash
sudo apt update && sudo apt upgrade -y
sudo apt install dnsmasq
```

---

## Comprobar la instalación

```bash
sudo systemctl status dnsmasq.service
```

# Archivo de configuración

El archivo de configuración por defecto de dnsmasq es:

```bash
/etc/dnsmasq.conf
```

Para este proyecto, se creó un archivo personalizado con la configuración específica en:

```bash
/etc/dnsmasq.d/guardianvpn.conf
