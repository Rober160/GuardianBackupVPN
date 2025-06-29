#!/bin/bash

if [ "$UID" != 0 ]; then
    echo "❌ Necesitas ejecutar este script como root"
    exit 1
fi

USUARIO="$1"
BACKUP_ID="$2"
TIMESTAMP=$(date +"%Y%m%d_%H%M%S")

RESTIC_REPO="/mnt/backups/repo_$USUARIO"
RESTIC_PASSWORD="ClaveRoot#20"
DIR_RESTORE="/VPN_cli/restore_tmp/restore_$USUARIO"
ZIP_NAME="backup_restaurado_${USUARIO}_${TIMESTAMP}.zip"
DEST_ZIP="/VPN_cli/restore_tmp/$ZIP_NAME"
DEST_PUBLIC="/var/www/clientes/descargas/$ZIP_NAME"

export RESTIC_PASSWORD="$RESTIC_PASSWORD"
export HOME="/var/www/tmp_home_wwwdata"
export RESTIC_CACHE_DIR="/var/www/tmp_home_wwwdata/.cache"

echo "🗑️ Eliminando restauraciones anteriores..."
rm -rf "$DIR_RESTORE"

echo "🔁 Restaurando snapshot $BACKUP_ID para el usuario $USUARIO..."
restic -r "$RESTIC_REPO" restore "$BACKUP_ID" --target "$DIR_RESTORE" --path "/VPN_cli/rsync_tmp/rsync_$USUARIO"

chown -R www-data:www-data "$DIR_RESTORE"
chmod -R 755 "$DIR_RESTORE"

RESTORE_CONTENIDO="$DIR_RESTORE/VPN_cli/rsync_tmp/rsync_$USUARIO"

if [ ! -d "$RESTORE_CONTENIDO" ]; then
    echo "⚠️ Carpeta restaurada no encontrada. Creando carpeta vacía..."
    mkdir -p "$RESTORE_CONTENIDO"
fi

echo "📦 Comprimiendo archivos restaurados (aunque estén vacíos)..."
cd "$RESTORE_CONTENIDO" || exit 1

# Añadir archivo marcador si está vacío
if [ -z "$(ls -A)" ]; then
    echo "(restauración vacía)" > __VACIO__.txt
fi

# Comprimir contenido
zip -r "$DEST_ZIP" . > /dev/null

# Validar que se creó el ZIP
if [ ! -f "$DEST_ZIP" ]; then
    echo "❌ No se creó el archivo ZIP esperado: $DEST_ZIP"
    exit 1
fi

echo "📤 Moviendo zip a carpeta pública..."
cp "$DEST_ZIP" "$DEST_PUBLIC"
chmod 644 "$DEST_PUBLIC"

echo "✅ Backup restaurado y disponible en:"
echo "$DEST_PUBLIC"

chown -R rsync-user:rsync-user "/VPN_cli/rsync_tmp/rsync_$USUARIO"


echo "[ZIP_RESULT] $ZIP_NAME"
