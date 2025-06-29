#!/bin/bash

while true; do
	/usr/local/bin/repositorios.sh >> /var/log/repositorios.log 2>&1
	sleep 6h
done
