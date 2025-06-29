#!/bin/bash

if [ $UID != 0 ]; then
	echo "Necesitas ejecutar como root"
	exit 1
fi
resultado="/VPN_cli/clientes.txt"
fecha=$(date '+%H:%M:%S %d-%m-%Y')

> "$resultado"

cli=2
numero=1
for cliente in $(seq 2 100); do
	ip="10.0.0.$cliente"	

	if ping -c 1 "$ip" &> /dev/null; then
		nom_cliente="usuario$numero"
		echo "$ip:$nom_cliente" >> $resultado 
		
		echo "Ping $ip exitoso --> $nom_cliente - $fecha"
		let cli=cli+1
		let numero=numero+1
	else

		echo "No se encuentra $ip - $fecha"	
	fi
done
