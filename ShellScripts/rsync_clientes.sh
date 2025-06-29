#!/bin/bash

if [ $UID != 0 ]; then
	echo "Necesitas ejecutar como root"
	exit 1
fi

dir_base="/VPN_cli/rsync_tmp"
dir_restore="/VPN_cli/restore_tmp"
clientes="/VPN_cli/clientes.txt"
fecha=$(date '+%H:%M:%S %d-%m-%Y')

for linea in $(cat "$clientes"); do
	nombre=$(echo "$linea" | cut -d ":" -f2)

	directorio="$dir_base/rsync_$nombre"
	directorio_restore="$dir_restore/restore_$nombre"

	if [ ! -d "$directorio" ];then
		mkdir -p "$directorio"
		echo "Creando directorio $directorio - $fecha" >> /var/log/rsync_clientes.log
	else
		echo "El directorio $directorio ya existe - $fecha" >> /var/log/rsync_clientes.log
	fi

	if [ ! -d "$directorio_restore" ]; then
		mkdir -p "$directorio_restore"
		echo "Creando directorio $directorio_restore - $fecha" >> /var/log/rsync_clientes.log
	else
		echo "Ya existe $directorio_restore - $fecha" >> /var/log/rsync_clientes.log
	fi
done

chmod 755 -R "$dir_base"
chmod 755 -R "$dir_restore"
