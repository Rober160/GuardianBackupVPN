# Servicios con systemd

En este apartado se documentan los servicios personalizados creados mediante **`systemd`** dentro del proyecto _GuardianBackupVPN_.

A lo largo del desarrollo se ha optado por utilizar `systemd` para definir ciertos procesos como **servicios persistentes**, 
que pueden iniciarse automáticamente al arrancar el sistema, reiniciarse en caso de fallo o ejecutarse en segundo plano de forma controlada.
