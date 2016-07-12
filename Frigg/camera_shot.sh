#!/bin/bash

camera_name="Zacharie"
dst_url="http://192.168.1.22:81/Heimdall/collect.php"
refresh=5 # delais entre chaque photo

while true ; do
  img_tag=$camera_name" - "`date "+%Y-%m-%d %A %B %H:%M:%S"`
  img_name="cam_img.jpg"

  ##################################################################
  # POUR LES MODULES RASPBERRY PI CAMERA
  ##################################################################
  raspistill -t 1 -w 640 -h 480 -q 50 -o $img_name

  if [ -f $img_name ] ; then
    convert -pointsize 15 -undercolor black -fill white -draw 'text 0,12 "'"$img_tag"'"' $img_name $img_name
    curl --form camera_image=@$img_name --form camera_name=$camera_name --form token=azerty $dst_url
    rm $img_name
  fi
  sleep $refresh
done