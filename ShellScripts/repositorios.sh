#!/bin/bash

export PATH=/usr/local/bin:/usr/bin:/bin:/usr/sbin:/sbin
echo "Ejecutando script" >> /var/log/repositorios.log
if [ $UID != 0 ]; then
	echo "Necesitas ejecutar como root" >> /var/log/repositorios.log
	exit 1
fi

repositorio_base="/mnt/backups"
clientes="/VPN_cli/clientes.txt"
fecha=$(date '+%H:%M:%S %d-%m-%Y')

export RESTIC_PASSWORD="ClaveRoot#20"

for linea in $(cat "$clientes"); do
	ip=$(echo "$linea" | cut -d ":" -f1)
	nombre=$(echo "$linea" | cut -d ":" -f2)
	repo_cliente="$repositorio_base/repo_$nombre"

	if [ ! -d "$repo_cliente" ];then
		mkdir -p "$repo_cliente"
		echo "Creando directorio $repo_cliente - $fecha" /var/log/repositorios.log
		
		export RESTIC_REPOSITORY="$repo_cliente"
		restic init --repo "$RESTIC_REPOSITORY"
		echo "Repositorio creado en $repo_cliente - $fecha" >> /var/log/repositorios.log
		echo
	
	else
		echo "El directorio $repo_cliente ya existe - $fecha" >> /var/log/repositorios.log
	fi

done

chown root:www-data -R /mnt/backups
chmod -R 770 /mnt/backups
