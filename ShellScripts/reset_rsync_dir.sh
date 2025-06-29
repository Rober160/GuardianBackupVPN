#!/bin/bash
USUARIO="$1"
DIR="/VPN_cli/rsync_tmp/rsync_$USUARIO"

rm -rf "$DIR"
mkdir -p "$DIR"
chown rsync-user:rsync-user "$DIR"
chmod 755 "$DIR"
