#!/bin/bash

echo "Creating snapshot in $1"
cat $1/image-list.txt | xargs wget -P $1/images