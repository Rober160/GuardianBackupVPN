#!/bin/bash
USUARIO="$1"
CARPETA="/VPN_cli/rsync_tmp/rsync_$USUARIO"

chmod o+rx /VPN_cli
chmod o+rx /VPN_cli/rsync_tmp
chown -R www-data:www-data "$CARPETA"
chmod -R 755 "$CARPETA"
