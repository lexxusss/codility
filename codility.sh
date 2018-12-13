#!/bin/bash

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" >/dev/null && pwd )";

for file in "$DIR"/files/*
do
    filename=$(basename -- "$file");
    extension="${filename##*.}";
#    echo "$filename";
    if [ "$extension" == "jpg" ] || [ "$extension" = "png" ]; then
        if [ ! -d images ]; then
          mkdir -p images;
        fi

        mv "$file" images/"$filename";
    elif [ "$extension" == "mp3" ] || [ "$extension" = "flac" ]; then
        if [ ! -d music ]; then
          mkdir -p music;
        fi

        mv "$file" music/"$filename";
    elif [ "$extension" == "avi" ] || [ "$extension" = "mov" ]; then
        if [ ! -d videos ]; then
          mkdir -p videos;
        fi

        mv "$file" videos/"$filename";
    elif [ "$extension" == "log" ]; then
        rm "$file";
    fi
done
