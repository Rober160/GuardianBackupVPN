# 🛡️ GuardianBackupVPN

**Proyecto Final de 2º ASIR**  
Autor: Roberto Negrete García

**_GuardianBackupVPN_** es un sistema seguro de copias de seguridad y recuperación de datos a través de VPN. Su objetivo principal es garantizar la **protección**, **disponibilidad** y **confidencialidad** de la información de los clientes, permitiendo la gestión remota de backups mediante una conexión cifrada.

---

## 📦 Requisitos del sistema

- 🖥️ **VirtualBox**
- 🐧 **Distribución Linux**: Ubuntu Server, Ubuntu Desktop o Debian
- 🌐 **Servidor Web**: Apache
- 🛠️ **Servidor de Aplicaciones**: PHP + MySQL

---

## 🎯 Objetivos del Proyecto

### ✅ Objetivo General

Desarrollar _GuardianBackupVPN_, una solución integral para la gestión de copias de seguridad y recuperación de datos que opere a través de una conexión VPN segura.

### 📌 Objetivos Específicos

1. 🗄️ Implementar un sistema de copias de seguridad utilizando **Rsync** y **Restic** en un servidor central.
2. 🔒 Configurar una **VPN segura con WireGuard** para cifrar todas las comunicaciones cliente-servidor.
3. 🧾 Registrar toda la actividad (fechas, tamaño, estado de backups, etc.) en una base de datos **MySQL**.
4. 🌐 Implementar un servidor DNS interno con **dnsmasq** para facilitar el acceso a la interfaz web mediante nombres de dominio.
5. 🧑‍💻 Desarrollar una **interfaz web con PHP**, dividida en dos secciones:
   - Panel de administración
   - Panel de cliente
6. 🔁 Automatizar la gestión de usuarios, repositorios y logs mediante **cron** y **systemd**.
7. ♻️ Asegurar la **recuperación efectiva de los datos**.

---

## 🧠 Justificación del Proyecto

En la era digital, la **gestión segura de los datos** se ha convertido en una necesidad crítica tanto para usuarios individuales como para organizaciones. La pérdida de información puede tener consecuencias graves, desde pérdidas personales hasta daños financieros y reputacionales para empresas.

_**GuardianBackupVPN**_ nace como respuesta a esta necesidad, ofreciendo una solución **segura**, **eficiente** y **accesible** para la creación, gestión y recuperación de copias de seguridad, aprovechando la potencia de herramientas de código abierto y tecnologías de red modernas.

---

✅ Este proyecto combina aspectos clave de la **administración de sistemas**, **seguridad informática** y **automatización**, reflejando competencias esenciales del perfil profesional de un técnico en Administración de Sistemas Informáticos y Redes.
