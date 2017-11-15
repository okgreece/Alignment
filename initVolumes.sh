#!/usr/bin/env bash

# Alignment MySQL DB:
mkdir -p volumes/alignment/mysql
mkdir -p volumes/alignment/composer

# Alignment
mkdir -p volumes/alignment/storage
mkdir -p volumes/alignment/storage/app/projects
mkdir -p volumes/alignment/storage/app/public/json_serializer
mkdir -p volumes/alignment/storage/logs
mkdir -p volumes/alignment/stappler

chmod -R oga+rwx ./volumes
