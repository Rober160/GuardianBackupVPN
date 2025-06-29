# Workflows n8n

En este directorio se encuentran todos los workflows desarrollados con **n8n**, la herramienta de automatización integrada en el proyecto.

---

## Contexto

El proyecto GuardianBackupVPN está integrado con n8n para automatizar procesos clave relacionados con la gestión de backups. Gracias a esta integración, se envían notificaciones automáticas al administrador en los siguientes casos:

- Cuando un cliente crea un backup exitosamente.
- Cuando un cliente solicita la restauración de un backup.

---

## Funcionalidad

Cada workflow está diseñado para escuchar eventos específicos del sistema y ejecutar acciones automáticas, como el envío de correos electrónicos o alertas, facilitando así la supervisión y respuesta rápida ante las actividades de los clientes.

---

> Todos los workflows se encuentran en formato JSON exportado, listos para importarse en una instancia de n8n.
