#!/bin/bash

for i in `find /var/www/html/Frigg/camera/* -type d` ; do
  find $i -type f -mtime +2 -exec rm -f {} \;
done