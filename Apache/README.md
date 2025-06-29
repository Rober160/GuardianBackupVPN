# Apache

Este directorio contiene la configuración necesaria para alojar los sitios virtuales de **Administración** y de los **Clientes** usando Apache.

---

## Instalación Apache 2.0

Para instalar Apache y mantener el sistema actualizado, ejecuta:

```bash
sudo apt update && sudo apt upgrade -y
sudo apt install apache2 -y
```

---

## Comprobar la instalación

```bash
apache2 -v
sudo systemctl status apache2
```

---

# Sitios Virtuales

- **Administración:**  
  Ubicación: `/var/www/admin`  
  Propietario: `www-data`

- **Clientes:**  
  Ubicación: `/var/www/clientes`  
  Propietario: `www-data`

---

# Archivos de configuración

### Administración

- **HTTPS:** `/etc/apache2/sites-available/admin-ssl.conf`  
- **HTTP:** `/etc/apache2/sites-available/admin.conf`

### Clientes

- **HTTPS:** `/etc/apache2/sites-available/clientes-ssl.conf`  
- **HTTP:** `/etc/apache2/sites-available/clientes.conf`

