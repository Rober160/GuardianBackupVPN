# GuardianBackupVPN
Proyecto Final de grado 2ºASIR realizado por Roberto Negrete García

_GuardianBackupVPN_ es un sistema seguro de copias de seguridad y de recuperación de datos vía VPN. El objetivo es ofrecer y garantizar la protección y disponibilidad de la información para los clientes, permitiendo una conexión segura para gestionar sus backups.

**Requisitos**
  - **VirtualBox**
  - **Distribución de Linux** (Ubuntu Server, Ubuntu y Debian)
  - **Servidor Web** (Apache)
  - **Servidor de Aplicación** (PHP y MySQL)

# Objetivos
**Objetivo General**

Desarrollar _GuardianBackupVPN_, un sistema seguro de copias de seguridad y recuperación de datos que permita a los clientes gestionar sus backups de manera segura y eficiente mediante una conexión VPN.

**Objetivos Específicos**
1. Implementar una solución de copias de seguridad configurando un servidor central que utilice **Rsync** y **Restic** para realizar copias de seguridad de los datos de los clientes.
2. Establecer una VPN configurando **WireGuard** para asegurar todas las conexiones al servidor de backups.
3. Registrar las actividades en una Base de Datos **MySQL**, estas actividades incluyen: fechas de creación, tamaño de los backups, estado…
4. Implementar un servidor DNS interno con **dnsmasq** para facilitar el acceso a la interfaz web mediante un nombre de dominio en lugar de direcciones IP.
5. Desarrollar una interfaz Web mediante **PHP** que permita la gestión de las copias de seguridad. La interfaz se divide en dos secciones: la primera para el administrador, y la segunda para los clientes.
6. Automatizar el proceso de gestión de usuarios y sus repositorios de backups mediante **cron** y **systemd**, además de implementar un registro de logs.
7. Garantizar la recuperación de los datos.

# Justificación

Actualmente, la gestión de los datos es fundamental tanto para individuos como para organizaciones. La pérdida de datos puede dar resultado en consecuencias desastrosas como la pérdida de información personal valiosa y, en el caso de empresas, la pérdida de ingresos y reputación.
Este proyecto, _GuardianBackupVPN_ se desarrolla con la finalidad de solucionar este problema, ofreciendo una solución que combina la seguridad, la facilidad de uso en el proceso de copias de seguridad y la recuperación de datos.
